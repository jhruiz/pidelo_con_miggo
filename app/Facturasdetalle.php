<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturasdetalle extends Model
{
    public static function obtenerFacturaDetalleFactId( $facturaId ) {
		$data = Facturasdetalle::select()

                ->join( 'productos', 'productos.id', '=', 'facturasdetalles.producto_id' )

                ->where( 'facturasdetalles.factura_id', '=', $facturaId )

                ->get();

    	return $data;    	
    }
}
