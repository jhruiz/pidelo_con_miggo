<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudade extends Model
{
	/** Se obtiene la ciudad y el pais por medio del id de la ciudad**/
    public static function obtenerCiudadPais($ciudadId) {
		$data = Ciudade::select('ciudades.descripcion AS ciudad', 'paises.descripcion AS pais')                

                ->join( 'paises', 'paises.id', '=', 'ciudades.paise_id')

                ->where( 'ciudades.id', '=', $ciudadId )
                
                ->get();

    	return $data;
    }
}
