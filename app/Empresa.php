<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
	/** Se obtiene la informaicion de la empresa por id **/
    public static function obtenerEmpresaPorId( $empresaId ){
		$data = Empresa::select()

                ->where( 'empresas.id', '=', $empresaId )
                
                ->get();

    	return $data;
    }
}
