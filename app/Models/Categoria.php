<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'idCategoria';

    protected $fillable = [
        'uuid',
        'idEmpresa',
        'nombreCategoria',
        'descripcionCategoria',
        'iconoCategoria',
        'urlIconoCategoria',
        'idIconoCategoria'
    ];

    //Automatizar la lógica de negocio antes de que los datos toquen la base de datos
    protected static function boot()
    {
        parent::boot(); //Fundamental para que funcione el método

        static::creating(function ($categoria) { //Justo antes de guardar en la db, se ejecuta este método
            if (empty($categoria->uuid)) { //Revisa si el campo uuid se encuentra vacío, si lo está genera uno automáticamente
                $categoria->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Obtener la ruta del modelo usando UUID
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class,'idEmpresa','idEmpresa');
    }

    public function productos(){
        return $this->hasMany(Producto::class,'idCategoria','idCategoria');
    }

}
