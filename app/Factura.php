<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
	/** Obtiene todas las facturas asociadas a un vehiculo **/
    public static function obtenerFacturasVehiculo( $idVehiculo) {

		$data = Factura::select( 	'facturas.id', 'facturas.codigo', 'facturas.consecutivodian',
									'facturas.created', 'usuarios.nombre', 'clientes.nombre',
									'facturas.pagocontado', 'facturas.factura' )

				->leftjoin( 'clientes', 'clientes.id', '=', 'facturas.cliente_id' )				
				->join( 'usuarios', 'usuarios.id', '=', 'facturas.usuario_id' )
				->leftjoin( 'ordentrabajos', 'ordentrabajos.id', '=', 'facturas.ordentrabajo_id' )
				->leftjoin( 'vehiculos', 'vehiculos.id', '=', 'ordentrabajos.vehiculo_id' )

                ->where( 'vehiculos.id', '=', $idVehiculo )
                
                ->orderByDesc( 'facturas.id' )
                
                ->get();

    	return $data;
    }

    /** Obtiene una factura especifica **/
    public static function obtenerFacturaPorId( $id ) {

		$data = Factura::select()

                ->where( 'facturas.id', '=', $id )
                
                ->get();

    	return $data;

    }
}
