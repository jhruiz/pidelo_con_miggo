<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdentrabajosSuministro extends Model
{
    public static function obtenerSuministrosPorIdOrden( $ordenId ){
		$data = OrdentrabajosSuministro::select()                

                ->join( 'cargueinventarios', 'cargueinventarios.id', '=', 'ordentrabajos_suministros.cargueinventario_id' )
                ->join( 'productos', 'productos.id', '=', 'cargueinventarios.producto_id')

                ->where( 'ordentrabajos_suministros.ordentrabajo_id', '=', $ordenId )
                
                ->get();

    	return $data;
    }
}
