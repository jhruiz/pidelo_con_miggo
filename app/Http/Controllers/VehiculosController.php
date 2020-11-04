<?php

namespace App\Http\Controllers;

use App\Vehiculo;
use Illuminate\Http\Request;

class VehiculosController extends Controller
{
	/** Obtiene la informacion del vehiculo por placa **/
    public function vehiculoplaca( $placa = null ) {

    	$resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );
    	
    	/** Valida que llegue por parametro la placa del vehiculo **/
    	if( !empty( $placa )) {

    		/** Obtiene los datos del vehículo por placa **/
    		$vehiculo = Vehiculo::obtenerVehiculoXPlaca( $placa );

    		/** Valida que la consulta retorne resultados **/
    		if( !empty( $vehiculo['0']['id'] )) {

    			$resp['estado'] = true;
    			$resp['data'] = $vehiculo;

    		} else {

    			$resp['mensaje'] = 'El vehículo con placa ' . $placa . ' no se encuentra';

    		}
    	} else {

    		$resp['mensaje'] = 'Debe ingresar una placa de un vehículo';	
    		
    	}

    	return $resp; 
    }
}
