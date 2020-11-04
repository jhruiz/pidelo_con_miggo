<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordenestado extends Model
{
    public static function obtenerOrdenEstado( $id ) {
		$data = Ordenestado::select( )

                ->where( 'ordenestados.id', '=', $id )
                
                ->get();

    	return $data;       	
    }
}
