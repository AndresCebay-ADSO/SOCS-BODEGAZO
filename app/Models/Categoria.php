<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;

    protected $table = 'categorias';
    protected $primaryKey = 'idCat';
    
    protected $fillable = [
        'nomCat', 'desCat', 'estCat'
    ];
    
    protected $dates = ['deleted_at'];
    
    /**
     * Relación con productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'idcatPro', 'idCat');
    }
}