<?php

namespace App\Http\Controllers;

use App\Publicidadmovile;
use Illuminate\Http\Request;

class PublicidadmovilesController extends Controller
{
	/** las imágenes para la cabecera **/
    public function headerAdvertising( $empresaId = null ) {

    	$resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );
    	
    	/** Valida que llegue por parametro la placa del vehiculo **/
    	if( !empty( $empresaId )) {
    	    
    	    $ubicacion = '1';
    	    $visible = '1';

    		/** Obtiene los datos del vehículo por placa **/
    		$images = Publicidadmovile::getImages( $empresaId, $ubicacion, $visible );

    		/** Valida que la consulta retorne resultados **/
    		if( !empty( $images['0']['id'] )) {

    			$resp['estado'] = true;
    			$resp['data'] = $images;

    		} else {

    			$resp['mensaje'] = 'No se encontraron imagenes';

    		}
    	} else {

    		$resp['mensaje'] = 'No se encontraron imagenes';	
    		
    	}

    	return $resp; 
    }
    
	/** las imágenes para la cabecera **/
    public function footerAdvertising( $empresaId = null ) {

    	$resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );
    	
    	/** Valida que llegue por parametro la placa del vehiculo **/
    	if( !empty( $empresaId )) {
    	    
    	    $ubicacion = '0';
    	    $visible = '1';

    		/** Obtiene los datos del vehículo por placa **/
    		$images = Publicidadmovile::getImages( $empresaId, $ubicacion, $visible );

    		/** Valida que la consulta retorne resultados **/
    		if( !empty( $images['0']['id'] )) {

    			$resp['estado'] = true;
    			$resp['data'] = $images;

    		} else {

    			$resp['mensaje'] = 'No se encontraron imagenes';

    		}
    	} else {

    		$resp['mensaje'] = 'No se encontraron imagenes';	
    		
    	}

    	return $resp; 
    }    
}