<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordentrabajo extends Model
{
	/** Obtiene las ordenes de trabajo asociadas a un vehículo **/
    public static function obtenerOrdenesVehiculo( $idVehiculo ) {
		$data = Ordentrabajo::select(	'ordentrabajos.id', 'ordentrabajos.kilometraje', 'ordentrabajos.fecha_ingreso',
										'ordentrabajos.fecha_salida', 'ordentrabajos.codigo', 'ordentrabajos.soat',
										'ordentrabajos.tecnomecanica', 'usuarios.nombre AS tecnico', 'clientes.nombre AS cliente',
										'ordenestados.descripcion')

				->join( 'vehiculos', 'vehiculos.id', '=', 'ordentrabajos.vehiculo_id' )
				->join( 'usuarios', 'usuarios.id', '=', 'ordentrabajos.usuario_id' )
				->join( 'clientes', 'clientes.id', '=', 'ordentrabajos.cliente_id' )
				->join( 'ordenestados', 'ordenestados.id', '=', 'ordentrabajos.ordenestado_id' )

                ->where( 'vehiculos.id', '=', $idVehiculo )
                
                ->orderByDesc( 'ordentrabajos.id' )
                
                ->get();

    	return $data;    	
    }

    /** Obtiene una orden de trabajo específica **/
    public static function obtenerOrdenTrabajo( $id ) {
		$data = Ordentrabajo::select( )

				->join( 'vehiculos', 'vehiculos.id', '=', 'ordentrabajos.vehiculo_id' )
				->join( 'usuarios', 'usuarios.id', '=', 'ordentrabajos.usuario_id' )
				->join( 'clientes', 'clientes.id', '=', 'ordentrabajos.cliente_id' )
				->join( 'ordenestados', 'ordenestados.id', '=', 'ordentrabajos.ordenestado_id' )

                ->where( 'ordentrabajos.id', '=', $id )
                
                ->get();

    	return $data;    	
    }    

    public static function obtenerOrdenPorId( $id ) {
		$data = Ordentrabajo::select( )

                ->where( 'ordentrabajos.id', '=', $id )
                
                ->get();

    	return $data;    	    	
    } 
}
