<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'idCliente';

    protected $fillable = [
        'idEmpresa',
        'idTipoCliente',
        'nombreCliente',
        'apellidoCliente',
        'dniCliente',
        'rucCliente',
        'razonSocialCliente',
        'emailCliente',
        'direccionCliente'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'idEmpresa','idEmpresa');
    }

    public function tipoCliente(){
        return $this->belongsTo(TipoCliente::class,'idTipoCliente','idTipoCliente');
    }

    public function ventas(){
        return $this->hasMany(Venta::class,'idCliente','idCliente');
    }


}
