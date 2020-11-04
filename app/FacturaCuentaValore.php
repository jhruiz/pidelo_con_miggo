<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaCuentaValore extends Model
{
	/** Se obtienen todos los pagos realizados a una factura **/
    public static function obtenerPagosFactura( $facturaId ){
		$data = FacturaCuentaValore::select()

                ->where( 'factura_cuenta_valores.factura_id', '=', $facturaId )
                
                ->get();

    	return $data;
    }
}
