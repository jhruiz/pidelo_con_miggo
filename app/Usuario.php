<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public static function obtenerUsuarioPorId( $usuarioId ){
		$data = Usuario::select()

                ->where( 'usuarios.id', '=', $usuarioId )
                
                ->get();

    	return $data;
    }
}
