<?php

namespace App\Imports;

use App\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;  //Para incluir encabezados

class InventoryImport implements ToModel, WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //Retorna los registros en base al Modelo (Inventory)
        //Recomendacion: que las columnas de excel($row) esten en el mism orden que en la base da tos para evitar que un dato quede en un campo incorrecto
        return new Inventory([
            //Nombre en DB       | Columna en Excel
            'codigo_interno'        => $row['codigo_interno'],
            'referencia_fabrica'    => $row['referencia_fabrica'],
            'referencia_articulo'   => $row['referencia_articulo'],
            'serial'                => $row['serial'],
            'segemento'             => $row['segemento'],
            'lineas'                => $row['lineas'],
            'marca'                 => $row['marca'],
            'tipo_marca'            => $row['tipo_marca'],
            'descripcion'           => $row['descripcion'],
            'existencias'           => $row['existencias'],
            'ubicacion_bodega'      => $row['ubicacion_bodega'],
            'unidad_medida'         => $row['unidad_medida'],
            'costo'                 => $row['costo'],
            'precio_venta'          => $row['precio_venta'],
            'usuario'               => $row['usuario'],
            'contador'              => $row['contador'],
        ]);
    }


    //Se indica la fila donde empieza la fila de encabezados (En el caso fila 1, si empezara en la fila 10 sea signa return 10;)
    public function headingRow(): int{
        return 1;
    }
}
