<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumeracionComprobante extends Model
{
    protected $table = 'numeracion_comprobante';
    protected $primaryKey = 'idNumeracionComprobante';
    public $timestamps = false;

    protected $fillable = [
        'idEmpresa',
        'idTipoComprobante',
        'ultimoNumero'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'idEmpresa','idEmpresa');
    }

    public function tipoComprobante(){
        return $this->belongsTo(TipoComprobante::class, 'idTipoComprobante', 'idTipoComprobante');
    }

    public function ventas(){
        return $this->hasMany(Venta::class,'idNumeracionComprobante','idNumeracionComprobante');
    }

    public function obtenerSiguienteNumero(){
        $this->ultimoNumero += 1;
        $this->save();
        return str_pad($this->ultimoNumero, 8,'0',STR_PAD_LEFT);
    }

}
