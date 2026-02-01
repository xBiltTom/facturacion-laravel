<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCliente extends Model
{
    protected $table = 'tipo_cliente';
    protected $primaryKey = 'idTipoCliente';

    public $timestamps = false;

    protected $filable = [
        'descripcionTipoCliente'
    ];

    public function clientes(){
        return $this->hasMany(Cliente::class,'idTipoCliente','idTipoCliente');
    }
}
