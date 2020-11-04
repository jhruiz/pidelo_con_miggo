<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
	/** Obtiene la informacion completa del vehiculo con join a tipo y la marca **/
    public static function obtenerVehiculoXPlaca( $placa ) {

		$data = Vehiculo::select(	'vehiculos.id', 'vehiculos.placa', 'vehiculos.cilindraje',
									'vehiculos.modelo', 'vehiculos.color', 'vehiculos.linea',
									'vehiculos.soat', 'vehiculos.tecno', 'tipovehiculos.descripcion',
									'marcavehiculos.descripcion')

				->join( 'tipovehiculos', 'vehiculos.tipovehiculo_id', '=', 'tipovehiculos.id' )
                ->join( 'marcavehiculos', 'vehiculos.marcavehiculo_id', '=', 'marcavehiculos.id' )
                
                ->where( 'vehiculos.placa', '=', $placa )
                
                ->get();

        return $data;    	
    }

    /** Obtiene la informacion del vehiculo por el id **/
    public static function obtenerVehiculoXId( $id ) {
		$data = Vehiculo::select()

				->join( 'tipovehiculos', 'vehiculos.tipovehiculo_id', '=', 'tipovehiculos.id' )
                ->join( 'marcavehiculos', 'vehiculos.marcavehiculo_id', '=', 'marcavehiculos.id' )
                
                ->where( 'vehiculos.id', '=', $id )
                
                ->get();

        return $data;  
    }
}
