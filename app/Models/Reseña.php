<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reseña extends Model {
    protected $table = 'reseñas';
    protected $primaryKey = 'idRes';
    public $timestamps = false;
    protected $fillable = [
        'idRes',
        'idUsuRes',
        'CalRes',
        'ComRes',
        'FechCreRes',
    ];
}
