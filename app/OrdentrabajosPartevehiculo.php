<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdentrabajosPartevehiculo extends Model
{
    public static function obtenePartesporIdOrden( $ordenId ){
		$data = OrdentrabajosPartevehiculo::select(	'partevehiculos.descripcion AS partevehiculo', 
													'estadopartes.descripcion AS estadoparte')

				->join( 'partevehiculos', 'partevehiculos.id', '=', 'ordentrabajos_partevehiculos.partevehiculo_id' )
				->join( 'estadopartes', 'estadopartes.id', '=', 'ordentrabajos_partevehiculos.estadoparte_id' )

                ->where( 'ordentrabajos_partevehiculos.ordentrabajo_id', '=', $ordenId )               
                
                ->get();

    	return $data;
    }
}
