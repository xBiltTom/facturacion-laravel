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
        'iconoCategoria'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($categoria) {
            if (empty($categoria->uuid)) {
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
