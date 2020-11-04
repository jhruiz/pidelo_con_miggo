<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
	/** Se obtiene la informacion del deposito que tiene configurado la resolución**/
    public static function obtenerConsDeposito($empresaId) {

		$data = Deposito::select()                

                ->where('depositos.empresa_id', '=', $empresaId)
                
                ->whereNotNull('depositos.resolucionfacturacion')
                
                ->get();

    	return $data;
    }    
}
