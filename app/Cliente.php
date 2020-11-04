<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public static function obtenerClientePorId( $id ) {
		$data = Cliente::select()                

                ->where( 'clientes.id', '=', $id )
                
                ->get();

    	return $data;        
    }
}
