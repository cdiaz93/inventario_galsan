<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //

    protected $table='inventory';

    //Campos para asignacion masiva
    protected $fillable = [
        'codigo_interno',
        'referencia_fabrica',
        'referencia_articulo',
        'serial',
        'segemento',
        'lineas',
        'marca',
        'tipo_marca',
        'descripcion',
        'existencias',
        'ubicacion_bodega',
        'unidad_medida',
        'costo',
        'precio_venta',
        'usuario',
        'contador'
    ];

}
