<?php

namespace App\Http\Controllers;

use App\Factura;
use App\Abonofactura;
use App\FacturaCuentaValore;
use App\Empresa;
use App\Usuario;
use App\Facturasdetalle;
use App\Ciudade;
use App\Relacionempresa;
use App\Ordentrabajo;
use App\Cliente;
use App\FacturasNotafactura;
use App\Deposito;
use Illuminate\Http\Request;

class FacturasController extends Controller
{
    /** Se obtiene el listado de facturas asociadas a un vehiculo **/
    public function facturasvehiculo( $idVehiculo ) {
        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        /** Se valida que llegue por parametro el id del vehiculo **/
        if( !empty( $idVehiculo )) {

            /** Obtiene las facturas asociadas a un vehiculo **/
            $facturas = Factura::obtenerFacturasVehiculo( $idVehiculo );

            /** Valida que existan facturas **/
            if( !empty( $facturas['0']['id'] )) {

                foreach ($facturas as $key => $value) {
                    $valueFact = $this->obtenerValorFactura($value);    
                    $facturas[$key]['totalPago'] = $valueFact;
                }                

                $resp['estado'] = true;
                $resp['data'] = $facturas;

            } else {

                $resp['mensaje'] = 'No se encontraron facturas para el vehículo';

            }
        } else {

            $resp['mensaje'] = 'No se ingreso el id del vehículo';

        }

        return $resp;
    }

    /** Obtiene una factura por id **/
    public function obtenerfactura( $id ) {
        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        if ( !empty( $id )) {
            
            $factura = Factura::obtenerFacturaPorId( $id );

            if ( !empty( $factura['0']['id'] )) {
                
                $facturaInfo = $this->gestionInfoFactura( $factura );

                $resp['estado'] = true;
                $resp['data'] = $facturaInfo;

            } else {
                $resp['mensaje'] = 'No se encontro registro de la factura';
            }
        } else {
            $resp['mensaje'] = 'No se ingreso el id de la factura';
        }

        return $resp;
    }

    /** Obtiene el valor total de una factura **/
    public function obtenerValorFactura( $values ){

        if( !empty( $values['id'] )){

            /** Se obtiene todos los pagos realizados a una factura**/
            $resp = $this->obtenerDetalleFactura( $values['id'], $values['factura'] );
            
            $ttalFactura = 0;

            if( count($resp) ){
                foreach ( $resp as $value ) {   
                    
                    if($values['factura'] == 0){
                        $ttalFactura += ($value['valxcant'] - $value['descuento']);    
                    }else{
                        $ttalFactura += (($value['valxcant'] + $value['valIva']) - $value['descuento']);
                    }
                    
                }                
            } else {
                $ttalFactura = $values['pagocontado'];
            }

        }

        return $ttalFactura;
        
    }
    
    /** Gestiona la informacion completa de la factura y sus datos relacionados **/
    public function gestionInfoFactura( $factura ) {

        $data = [];

        // se valida que la factura contenga datos
        if(!empty( $factura )){
            
            // se obtiene la informacion del cliente
            $data['infoCliente'] = Cliente::obtenerClientePorId( $factura['0']['cliente_id'] );
            
            // se obtienen los pagos realizados a la factura
            $data['infoPagos'] = FacturaCuentaValore::obtenerPagosFactura( $factura['0']['id'] ); 

            // se obtiene la informacion de la empresa
            $data['infoEmpresa'] = Empresa::obtenerEmpresaPorId( $factura['0']['empresa_id'] );

            // se obtiene la informacion del usuario que gestiono la factura
            $data['infoUsuario'] = Usuario::obtenerUsuarioPorId( $factura['0']['usuario_id'] );

            // se obtiene el detalle de la factura
            $data['infoDetFact'] = $this->obtenerDetalleFactura( $factura['0']['id'], $factura['0']['factura'] );

            // se obtiene la ciudad y el pais
            $data['ubicacion'] = Ciudade::obtenerCiudadPais( $data['infoEmpresa']['0']['ciudade_id'] );
            
            // se obtiene la informacion de la remision
            $data['remision'] = [];
            if( empty($factura['0']['factura']) ){
                $data['remision'] = Relacionempresa::obtenerDatosEmpresaRemision( $data['infoEmpresa']['0']['id'] );
            }

            // se valida si existe una orden de trabajo relacionada a la factura
            $data['ordenTrabajo'] = [];
            if( !empty( $factura['0']['ordentrabajo_id'] )) {
                $data['ordenTrabajo'] = Ordentrabajo::obtenerOrdenTrabajo( $factura['0']['ordentrabajo_id'] );
            }

            // se obtiene la informacion de la nota
            $data['notaFactura'] = FacturasNotafactura::obtenerNotasFactura( $factura['0']['id'] );

            // se obtiene la informacion del deposito que tiene configurada la numeracion y resolucion
            $data['resolucion'] = Deposito::obtenerConsDeposito( $data['infoEmpresa']['0']['id'] );                


            $data['factura'] = $factura;

        }

        return $data;
    }


    /** Se obtiene el detalle de la factura y se calculan impuestos y descuentos si es necesario **/
    public function obtenerDetalleFactura( $id, $tipoFactura ) {
        
        $detalleFactura = Facturasdetalle::obtenerFacturaDetalleFactId( $id );

        if( $tipoFactura == 0 ) {

            // el tipo de venta es para una remision, por lo que no se calculan impuestos
            foreach ($detalleFactura as $key => $value) {                
                $costoBase = $value['costoventa'];
                $valXCan = $costoBase * $value['cantidad'];

                $descuento =    !empty( $value['porcentaje'] ) ?
                                ceil(( $valXCan * ( $value['porcentaje'] )/100 ) ) :
                                0;

                $detalleFactura[$key]['costobase'] = $costoBase;
                $detalleFactura[$key]['dcto'] = $descuento;
                $detalleFactura[$key]['valxcant'] = $valXCan;
            }               
            
        } else {

            // el tipo de venta es para una factura, por lo que se calculan impuestos
            foreach ($detalleFactura as $key => $value) {                

                // se obtiene el costo base del producto, sacando el impuesto (si aplica)
                $costoBase =    !empty( $value['impuesto'] ) ? 
                                ceil( $value['costoventa'] / (( $value['impuesto']/100 )+1 )) : 
                                ceil( $value['costoventa'] );


                $descuento =    !empty( $value['porcentaje'] ) ?
                                ceil(( $costoBase * ( $value['porcentaje'] )/100 ) * $value['cantidad'] ) :
                                0;

                $valXCan = $costoBase * $value['cantidad'];

                $valorIVA = ceil(($valXCan - $descuento) * ($value['impuesto']/100));

                $detalleFactura[$key]['costobase'] = $costoBase;
                $detalleFactura[$key]['dcto'] = $descuento;
                $detalleFactura[$key]['valxcant'] = $valXCan;
                $detalleFactura[$key]['valIva'] = $valorIVA;
                
            }            
        }

        return $detalleFactura;

    }
}
