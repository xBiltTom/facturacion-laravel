<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    protected $table = 'tipo_comprobante';
    protected $primaryKey = 'idTipoComprobante';
    public $timestamps = false;

    protected $fillable = [
        'nombreTipoComprobante',
        'serieTipoComprobante'
    ];

    public function numeracionesComprobante(){
        return $this->hasMany(NumeracionComprobante::class,'idTipoComprobante','idTipoComprobante');
    }


}
