<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'idVenta';

    protected $fillable = [
        'idEmpresa',
        'idCliente',
        'idNumeracionComprobante',
        'fechaVenta',
        'montoTotalVenta'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'idEmpresa','idEmpresa');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class,'idCliente','idCliente');
    }

    public function numeracionComprobante(){
        return $this->belongsTo(NumeracionComprobante::class,'idNumeracionComprobante','idNumeracionComprobante');
    }

    public function detalleVenta(){
        //
    }

    //metodo para calcular el monto total de una venta

}
