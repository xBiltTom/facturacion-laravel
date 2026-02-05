<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'idEmpresa';

    protected $fillable = [
        'razonSocialEmpresa',
        'urlLogoEmpresa',
        'idLogoEmpresa',
        'rucEmpresa',
        'telefonoEmpresa',
        'direccionEmpresa',
        'idUsuario'
    ];

    public function usuario(){
        return $this->belongsTo(User::class,'idUsuario','id');
    }

    public function categorias(){
        return $this->hasMany(Categoria::class,'idEmpresa','idEmpresa');
    }

    public function productos(){
        return $this->hasMany(Producto::class,'idEmpresa','idEmpresa');
    }

    public function clientes(){
        return $this->hasMany(Cliente::class,'idEmpresa','idEmpresa');
    }

    public function ventas(){
        return $this->hasMany(Venta::class,'idEmpresa','idEmpresa');
    }

    public function numeracionesComprobantes(){
        return $this->hasMany(NumeracionComprobante::class,'idEmpresa','idEmpresa');
    }
}
