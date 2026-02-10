<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Producto extends Model
{
    protected $table = 'producto';
    protected  $primaryKey = 'idProducto';

    protected $fillable = [
        'uuid',
        'idEmpresa',
        'idCategoria',
        'idUnidad',
        'nombreProducto',
        'descripcionProducto',
        'precioVentaProducto',
        'tieneIGV',
        'stockProducto',
        'urlImagenProducto',
        'idImagenProducto'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($producto) {
            if(empty($producto->uuid)){
                $producto->uuid = (string) Str::uuid();
            }
        });
    }

    protected $casts = [
        'precioVentaProducto' => 'decimal:2',
        'tieneIGV' => 'boolean'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'idEmpresa','idEmpresa');
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'idCategoria', 'idCategoria');
    }

    public function unidad(){
        return $this->belongsTo(Unidad::class,'idUnidad','idUnidad');
    }

    public function detalleVenta(){
        return $this->hasMany(DetalleVenta::class,'idDetalleVenta','idDetalleVenta');
    }

    //posibles metodos para aumentar o descontar stock automaticamente
}
