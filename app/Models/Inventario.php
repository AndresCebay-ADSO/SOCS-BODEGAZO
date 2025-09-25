<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventarios';
    protected $primaryKey = 'idInv';
    protected $fillable = ['idProInv', 'canInv', 'ultactInv'];
    
    protected $casts = [
        'ultactInv' => 'datetime:Y-m-d H:i:s', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Mutador seguro para ultactInv
    public function setUltactInvAttribute($value)
    {
        $this->attributes['ultactInv'] = is_null($value) 
            ? null 
            : \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProInv');
    }
}