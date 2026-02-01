<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidad';
    protected $primaryKey = 'idUnidad';
    public $timestamps = false;

    protected $fillable = [
        'nombreUnidad',
        'descripcionUnidad'
    ];

    public function productos(){
        return $this->hasMany(Producto::class,'idProducto','idProducto');
    }
}
