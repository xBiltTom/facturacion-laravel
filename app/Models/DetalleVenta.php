<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';
    protected $primaryKey = 'idDetalleVenta';
    public $timestamps = false;

    protected $fillable = [
        'idVenta',
        'idProducto',
        'cantidadProducto',
        'precioUnitarioProducto'
    ];

    protected $casts = [
        'precioUnitarioProducto' => 'decimal:2'
    ];

    public function venta(){
        return $this->belongsTo(Venta::class,'idVenta','idVenta');
    }

    public function producto(){
        return $this->belongsTo(Producto::class,'idProducto','idProducto');
    }

}
