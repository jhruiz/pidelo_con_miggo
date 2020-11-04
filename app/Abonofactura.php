<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abonofactura extends Model
{
    public static function obtenerAbonoFacturaVehiculo( $idFactura ) {
		$data = Abonofactura::select(	'abonofacturas.valor' )

                ->where( 'abonofacturas.factura_id', '=', $idFactura )
                
                ->get();

    	return $data;      	
    }
}
