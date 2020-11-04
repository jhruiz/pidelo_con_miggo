<?php

namespace App\Http\Controllers;

use App\Ordentrabajo;
use App\Ordenestado;
use App\Vehiculo;
use App\Usuario;
use App\Cliente;
use App\OrdentrabajosPartevehiculo;
use App\OrdentrabajosSuministro;
use App\Empresa;
use App\Ciudade;

use Illuminate\Http\Request;

class OrdentrabajosController extends Controller
{
    /** Obtiene todas las ordenes de trabajo relacionadas a un vehiculo **/
    public function ordenesvehiculo( $idVehiculo ) {
		$resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

		if( !empty( $idVehiculo )){
			$ordenes = Ordentrabajo::obtenerOrdenesVehiculo( $idVehiculo );

			if( !empty( $ordenes['0']['id'] )){

				$resp['estado'] = true;
				$resp['data'] = $ordenes;

			} else {

				$resp['mensaje'] = 'No se encontraron ordenes asociadas al vehículo';

			}
		} else {
			$resp['mensaje'] = 'Debe ingresar el id del vehículo';
		}

		return $resp;
    }

    /** Obtiene una orden de trabajo especifica **/
    public function obtenerordentrabajo( $id ) {
    	$resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

    	if( !empty($id)) {

    		$ordenTrabajo = Ordentrabajo::obtenerOrdenPorId( $id );

    		if( !empty( $ordenTrabajo['0']['id'] )){

                $ordenInfo = $this->obtenerInfoOrdenTrabajo( $ordenTrabajo );

    			$resp['estado'] = true;
    			$resp['data'] = $ordenInfo;
    		} else {

    			$resp['mensaje'] = 'No se encontró la orden de trabajo solicitada';

    		}

    	}else {
    		$resp['mensaje'] = 'Debe ingresar el id de la orden de trabajo';
    	}

    	return $resp;
    }

    /** Obtiene toda la informacion relacionada a una orden de trabajo **/
    public function obtenerInfoOrdenTrabajo( $ordenTrabajo ) {

        $data = [];

        if(!empty( $ordenTrabajo )) {

            $data['ordenTrabajo'] = $ordenTrabajo; 

            $data['estadoOrden'] = Ordenestado::obtenerOrdenEstado( $ordenTrabajo['0']['ordenestado_id'] );
            
            $data['vehiculo'] = Vehiculo::obtenerVehiculoXId( $ordenTrabajo['0']['vehiculo_id'] );

            $data['usuario'] = Usuario::obtenerUsuarioPorId( $ordenTrabajo['0']['usuario_id'] );

            $data['cliente'] = Cliente::obtenerClientePorId( $ordenTrabajo['0']['cliente_id'] );

            $data['suministros'] = OrdentrabajosSuministro::obtenerSuministrosPorIdOrden( $ordenTrabajo['0']['id'] );

            $data['partevehiculos'] = OrdentrabajosPartevehiculo::obtenePartesporIdOrden( $ordenTrabajo['0']['id'] );

            $data['empresa'] = Empresa::obtenerEmpresaPorId( $data['usuario']['0']['empresa_id'] );
            
            $data['ubicacion'] = Ciudade::obtenerCiudadPais( $data['empresa']['0']['ciudade_id'] );            
            
        }

        return $data;

    }
}
