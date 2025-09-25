<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model {
    protected $table = 'login';
    protected $primaryKey = 'idLog';
    public $timestamps = false;
    protected $fillable = [
        'idLog',
        'usuLog',
        'passLog',
    ];
}
