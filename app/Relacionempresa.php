<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relacionempresa extends Model
{
    public static function obtenerDatosEmpresaRemision( $empresaId ) {
		$data = Relacionempresa::select()                

                ->where( 'relacionempresas.empresa_id', '=', $empresaId )

                ->orderBy( 'relacionempresas.id', 'DESC' )

                ->limit('1')
                
                ->get();

    	return $data;
    }
}
