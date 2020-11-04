<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturasNotafactura extends Model
{
	/** Se obtiene la nota asociada a una factura **/
    public static function obtenerNotasFactura( $facturaId ){
		$data = FacturasNotafactura::select()
		
		        ->join( 'notafacturas', 'notafacturas.id', '=', 'facturas_notafacturas.notafactura_id' )

                ->where( 'facturas_notafacturas.factura_id', '=', $facturaId )
                
                ->get();

    	return $data;
    }
}
