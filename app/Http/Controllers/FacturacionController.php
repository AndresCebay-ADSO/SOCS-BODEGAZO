<?php

namespace App\Http\Controllers;

use App\Models\FacturaElectronica;
use App\Models\DetalleFacturaElectronica;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FacturacionController extends Controller
{
    public function index()
    {
        $facturas = FacturaElectronica::with(['usuario', 'detalles'])
            ->orderBy('fecha_emision', 'desc')
            ->paginate(15);

        return view('admin.facturacion.index', compact('facturas'));
    }

    public function create()
    {
        $clientes = Usuario::where('idRolUsu', 2)->get();
        $productos = Producto::where('activo', 1)
            ->whereIn('estPro', ['Activo', 'disponible'])
            ->get();

        return view('admin.facturacion.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|exists:productos,idPro',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia,nequi,daviplata',
        ]);

        try {
            DB::beginTransaction();

            // Crear la factura
            $factura = FacturaElectronica::create([
                'numero_factura' => $this->generarNumeroFactura(),
                'fecha_emision' => now()->toDateString(),
                'hora_emision' => now()->toTimeString(),
                'id_usuario' => $request->id_usuario,
                'metodo_pago' => $request->metodo_pago,
                'estado' => 'borrador',
                'estado_pago' => 'pendiente',
                'ambiente' => config('app.env') === 'production' ? '2' : '1',
            ]);

            // Obtener información del cliente
            $cliente = Usuario::find($request->id_usuario);
            $factura->update([
                'tipo_documento_cliente' => $cliente->TipdocUsu ?? 'CC',
                'numero_documento_cliente' => $cliente->numdocUsu ?? '',
                'nombre_cliente' => $cliente->nomUsu . ' ' . $cliente->apeUsu,
                'direccion_cliente' => $cliente->dirUsu,
                'telefono_cliente' => $cliente->telUsu,
                'email_cliente' => $cliente->emaUsu,
            ]);

            // Configurar información de la empresa
            $this->configurarInformacionEmpresa($factura);

            // Crear detalles de la factura
            $subtotal = 0;
            $iva = 0;
            $descuento = 0;

            foreach ($request->productos as $item) {
                $producto = Producto::find($item['id_producto']);
                
                $detalle = DetalleFacturaElectronica::create([
                    'id_factura' => $factura->id,
                    'id_producto' => $producto->idPro,
                    'codigo_producto' => $producto->codPro,
                    'nombre_producto' => $producto->nomPro,
                    'descripcion' => $producto->descripcion,
                    'unidad_medida' => $producto->unidad_medida,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'porcentaje_iva' => 19.00, // IVA estándar en Colombia
                    'porcentaje_descuento' => 0,
                ]);

                $detalle->calcularTotales();
                
                $subtotal += $detalle->subtotal;
                $iva += $detalle->valor_iva;
                $descuento += $detalle->valor_descuento;
            }

            // Actualizar totales de la factura
            $factura->update([
                'subtotal' => $subtotal,
                'iva' => $iva,
                'descuento' => $descuento,
                'total' => $subtotal + $iva - $descuento,
            ]);

            DB::commit();

            return redirect()->route('admin.facturacion.show', $factura->id)
                ->with('success', 'Factura creada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear factura: ' . $e->getMessage());
            
            return back()->with('error', 'Error al crear la factura: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(FacturaElectronica $factura)
    {
        $factura->load(['usuario', 'detalles.producto']);
        
        return view('admin.facturacion.show', compact('factura'));
    }

    public function enviarDIAN(FacturaElectronica $factura)
    {
        try {
            // Generar CUFE
            $factura->update([
                'cufe' => $factura->generarCUFE(),
            ]);

            // Generar XML
            $xml = $this->generarXML($factura);
            $factura->update(['xml_content' => $xml]);

            // Enviar a DIAN (simulado)
            $response = $this->enviarADIAN($xml);
            
            if ($response['success']) {
                $factura->update([
                    'estado' => 'enviada',
                    'qr_code' => $response['qr_code'] ?? null,
                ]);

                return back()->with('success', 'Factura enviada a DIAN exitosamente');
            } else {
                return back()->with('error', 'Error al enviar a DIAN: ' . $response['message']);
            }

        } catch (\Exception $e) {
            Log::error('Error al enviar factura a DIAN: ' . $e->getMessage());
            return back()->with('error', 'Error al enviar la factura: ' . $e->getMessage());
        }
    }

    public function descargarPDF(FacturaElectronica $factura)
    {
        try {
            $pdf = $this->generarPDF($factura);
            
            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="factura_' . $factura->numero_factura . '.pdf"');

        } catch (\Exception $e) {
            Log::error('Error al generar PDF: ' . $e->getMessage());
            return back()->with('error', 'Error al generar el PDF');
        }
    }

    public function descargarXML(FacturaElectronica $factura)
    {
        try {
            $xml = $this->generarXML($factura);
            
            return response($xml)
                ->header('Content-Type', 'application/xml')
                ->header('Content-Disposition', 'attachment; filename="factura_' . $factura->numero_factura . '.xml"');

        } catch (\Exception $e) {
            Log::error('Error al generar XML: ' . $e->getMessage());
            return back()->with('error', 'Error al generar el XML');
        }
    }

    public function anular(FacturaElectronica $factura)
    {
        if (!$factura->puedeAnular()) {
            return back()->with('error', 'No se puede anular esta factura');
        }

        try {
            $factura->update(['estado' => 'anulada']);
            return back()->with('success', 'Factura anulada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al anular factura: ' . $e->getMessage());
            return back()->with('error', 'Error al anular la factura');
        }
    }

    // Métodos privados
    private function generarNumeroFactura()
    {
        $ultimaFactura = FacturaElectronica::whereYear('fecha_emision', now()->year)
            ->orderBy('numero_factura', 'desc')
            ->first();

        $numero = $ultimaFactura ? (int)$ultimaFactura->numero_factura + 1 : 1;
        
        return str_pad($numero, 8, '0', STR_PAD_LEFT);
    }

    private function configurarInformacionEmpresa($factura)
    {
        $factura->update([
            'nit_empresa' => config('facturacion.nit_empresa', '900000000-1'),
            'nombre_empresa' => config('facturacion.nombre_empresa', 'El Bodegazo SAS'),
            'direccion_empresa' => config('facturacion.direccion_empresa', 'Calle 123 # 45-67'),
            'telefono_empresa' => config('facturacion.telefono_empresa', '3001234567'),
            'email_empresa' => config('facturacion.email_empresa', 'info@elbodegazo.com'),
            'resolucion_dian' => config('facturacion.resolucion_dian', 'DIAN-123456789'),
        ]);
    }

    private function generarXML($factura)
    {
        // Generar XML según especificaciones DIAN
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">';
        
        // Información básica
        $xml .= '<cbc:UBLVersionID>2.1</cbc:UBLVersionID>';
        $xml .= '<cbc:CustomizationID>DIAN 2.1</cbc:CustomizationID>';
        $xml .= '<cbc:ProfileID>DIAN 2.1: Factura Electrónica de Venta</cbc:ProfileID>';
        $xml .= '<cbc:ID>' . $factura->numero_factura . '</cbc:ID>';
        $xml .= '<cbc:IssueDate>' . $factura->fecha_emision . '</cbc:IssueDate>';
        $xml .= '<cbc:IssueTime>' . $factura->hora_emision . '</cbc:IssueTime>';
        $xml .= '<cbc:DocumentCurrencyCode>' . $factura->moneda . '</cbc:DocumentCurrencyCode>';
        
        // Información del vendedor
        $xml .= '<cac:AccountingSupplierParty>';
        $xml .= '<cac:Party>';
        $xml .= '<cac:PartyIdentification>';
        $xml .= '<cbc:ID schemeID="31">' . $factura->nit_empresa . '</cbc:ID>';
        $xml .= '</cac:PartyIdentification>';
        $xml .= '<cac:PartyName>';
        $xml .= '<cbc:Name>' . $factura->nombre_empresa . '</cbc:Name>';
        $xml .= '</cac:PartyName>';
        $xml .= '</cac:Party>';
        $xml .= '</cac:AccountingSupplierParty>';
        
        // Información del comprador
        $xml .= '<cac:AccountingCustomerParty>';
        $xml .= '<cac:Party>';
        $xml .= '<cac:PartyIdentification>';
        $xml .= '<cbc:ID schemeID="1">' . $factura->numero_documento_cliente . '</cbc:ID>';
        $xml .= '</cac:PartyIdentification>';
        $xml .= '<cac:PartyName>';
        $xml .= '<cbc:Name>' . $factura->nombre_cliente . '</cbc:Name>';
        $xml .= '</cac:PartyName>';
        $xml .= '</cac:Party>';
        $xml .= '</cac:AccountingCustomerParty>';
        
        // Totales
        $xml .= '<cac:TaxTotal>';
        $xml .= '<cbc:TaxAmount currencyID="COP">' . $factura->iva . '</cbc:TaxAmount>';
        $xml .= '<cac:TaxSubtotal>';
        $xml .= '<cbc:TaxableAmount currencyID="COP">' . $factura->subtotal . '</cbc:TaxableAmount>';
        $xml .= '<cbc:TaxAmount currencyID="COP">' . $factura->iva . '</cbc:TaxAmount>';
        $xml .= '<cac:TaxCategory>';
        $xml .= '<cac:TaxScheme>';
        $xml .= '<cbc:ID>01</cbc:ID>';
        $xml .= '<cbc:Name>IVA</cbc:Name>';
        $xml .= '</cac:TaxScheme>';
        $xml .= '</cac:TaxCategory>';
        $xml .= '</cac:TaxSubtotal>';
        $xml .= '</cac:TaxTotal>';
        
        $xml .= '<cbc:LineExtensionAmount currencyID="COP">' . $factura->subtotal . '</cbc:LineExtensionAmount>';
        $xml .= '<cbc:TaxExclusiveAmount currencyID="COP">' . $factura->subtotal . '</cbc:TaxExclusiveAmount>';
        $xml .= '<cbc:TaxInclusiveAmount currencyID="COP">' . $factura->total . '</cbc:TaxInclusiveAmount>';
        $xml .= '<cbc:PayableAmount currencyID="COP">' . $factura->total . '</cbc:PayableAmount>';
        
        // Detalles de productos
        foreach ($factura->detalles as $detalle) {
            $xml .= '<cac:InvoiceLine>';
            $xml .= '<cbc:ID>' . $detalle->id . '</cbc:ID>';
            $xml .= '<cbc:InvoicedQuantity unitCode="94">' . $detalle->cantidad . '</cbc:InvoicedQuantity>';
            $xml .= '<cbc:LineExtensionAmount currencyID="COP">' . $detalle->subtotal . '</cbc:LineExtensionAmount>';
            $xml .= '<cac:Item>';
            $xml .= '<cbc:Description>' . $detalle->nombre_producto . '</cbc:Description>';
            $xml .= '<cac:StandardItemIdentification>';
            $xml .= '<cbc:ID>' . $detalle->codigo_producto . '</cbc:ID>';
            $xml .= '</cac:StandardItemIdentification>';
            $xml .= '</cac:Item>';
            $xml .= '<cac:Price>';
            $xml .= '<cbc:PriceAmount currencyID="COP">' . $detalle->precio_unitario . '</cbc:PriceAmount>';
            $xml .= '</cac:Price>';
            $xml .= '</cac:InvoiceLine>';
        }
        
        $xml .= '</Invoice>';
        
        return $xml;
    }

    private function generarPDF($factura)
    {
        // Generar PDF usando una librería como DomPDF
        // Por ahora retornamos un PDF básico
        $html = view('admin.facturacion.pdf', compact('factura'))->render();
        
        // Aquí usarías DomPDF o similar para convertir HTML a PDF
        return $html;
    }

    private function enviarADIAN($xml)
    {
        // Simulación de envío a DIAN
        // En producción, aquí harías la llamada real a la API de DIAN
        
        return [
            'success' => true,
            'message' => 'Factura enviada exitosamente',
            'qr_code' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($factura->cufe),
        ];
    }
}
