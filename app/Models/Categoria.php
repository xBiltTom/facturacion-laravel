<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'idCategoria';

    protected $fillable = [
        'idEmpresa',
        'nombreCategoria',
        'descripcionCategoria',
        'iconoCategoria'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'idEmpresa','idEmpresa');
    }

    public function productos(){
        return $this->hasMany(Producto::class,'idCategoria','idCategoria');
    }

}
