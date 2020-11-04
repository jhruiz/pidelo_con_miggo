<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicidadmovile extends Model
{
    public static function getImages( $empresaId, $ubicacion, $visible ) {
		$data = Publicidadmovile::select()                
                
                ->where('publicidadmoviles.ubicacion', '=', $ubicacion)

                ->get();

    	return $data;
    }
}