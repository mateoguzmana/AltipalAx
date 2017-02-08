<?php

class ConsignacionesVendedorController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //  'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {


        if (!Yii::app()->getUser()->hasState('_cedula')) {
            $this->redirect('index.php');
        }

        $cedula = Yii::app()->user->_cedula;
        $Criteria = new CDbCriteria();
        $Criteria->condition = "Cedula = $cedula";

        $idPerfil = Yii::app()->user->_idPerfil;

        $controlador = Yii::app()->controller->getId();

        $PerfilAcciones = Consultas::model()->getPerfilAcciones($idPerfil, $controlador);


        Yii::import('application.extensions.function.Action');
        $estedAction = new Action();

        try {

            $actionAjax = $estedAction->getActions(ucfirst($controlador) . 'Controller', '');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        $acciones = array();
        foreach ($PerfilAcciones as $itemAccion) {
            array_push($acciones, $itemAccion['Descripcion']);
        }

        foreach ($actionAjax as $item) {
            $dato = strtolower('ajax' . $item);
            array_push($acciones, $dato);
        }

        /* validacion para no mostrar botones */
        $arrayAction = Listalink::model()->findPerfil(ucfirst($controlador), $idPerfil);
        $arrayDiferentes = $estedAction->diffActions(ucfirst($controlador) . 'Controller', '', $arrayAction);

        $session = new CHttpSession;
        $session->open();
        $session['diferencia'] = $arrayDiferentes;



        if (count($acciones) <= 0) {
            return array(
                array('deny',
                    'users' => array('*'),
                ),
            );
        } else {
            return array(
                array('allow',
                    'actions' => $acciones,
                    'users' => array('@'),
                ),
                array('deny',
                    'users' => array('*'),
                ),
            );
        }
    }

    public function actionIndex($zonaVentas) {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/consignacionVendedor/consignacionvendedor.js', CClientScript::POS_END
        );


        $Asesor = ConsignacionVendedor::model()->Asesor($zonaVentas);

        $sumaEfectivos = $this->sumaEfectivosConsignacion($zonaVentas);

        $this->render('index', array(
            'zonaVentas' => $zonaVentas,
            'Asesor' => $Asesor,
            'sumaEfectivos' => $sumaEfectivos
        ));
    }

    public function actionAjaxCuentas() {

        $idCodBanco = $_POST['CodBanco'];
        echo $idCodBanco;

        $data = Cuentasbancarias::model()->findAll(array("condition" => "CodBanco = '$idCodBanco'"));
        $cuentas = count($data);
        $data = CHtml::listData($data, 'CodCuentaBancaria', 'NumeroCuentaBancaria');
        if ($cuentas > 1) {
            echo "<option value=''>Seleccione una cuenta bancaria</option>";
        }
        foreach ($data as $value => $cuentabancaria_name)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cuentabancaria_name), true);
    }

    public function actionAjaxCreate() {

        if ($_POST) {

            $session = new CHttpSession;
            $session->open();
            $datosChequeConsig = $session['ChequeConsig'];

            $codzona = $_POST['codzona'];
            $codasesor = $_POST['codasesor'];
            $numeroconsignacion = $_POST['numconsignacion'];
            $banco = $_POST['banco'];
            $cuenta = $_POST['cuenta'];
            $valorefectivo = $_POST['valorefctivo'];
            $valorcheque = $_POST['valorcheque'];
            $oficina = $_POST['oficina'];
            $ciudad = $_POST['ciudad'];
            $fecha = $_POST['fecha'];
            $codBanco = $_POST['IdentificadorBanco'];
            $codagencia = $_POST['codagencia'];

            //$canales = ConsignacionVendedor::model()->getInfoJerarquiaComercial($codasesor,$codagencia);
            //$canal = $canales[0]['CodigoCanal'];

            $id = ConsignacionVendedor::model()->InsertarConsignacion($codzona, $codasesor, $numeroconsignacion, $banco, $codBanco, $cuenta, $fecha, $valorefectivo, $valorcheque, $oficina, $ciudad);

            print_r($datosChequeConsig);
            foreach ($datosChequeConsig as $itemCheques) {

                $txtNumeroCheque = $itemCheques['txtNumeroCheque'];
                $txtBancoCheque = $itemCheques['txtBancoCheque'];
                $txtCuentaCheque = $itemCheques['txtCuentaCheque'];
                $txtFechaCheque = $itemCheques['txtFechaCheque'];
                $txtValorCheque = $itemCheques['txtValorCheque'];
                $txtGirado = $itemCheques['txtGirado'];
                $txtOtro = $itemCheques['txtOtro'];

                ConsignacionVendedor::model()->InsertarChequesConsignacion($id, $txtNumeroCheque, $txtBancoCheque, $txtCuentaCheque, $txtFechaCheque, $txtGirado, $txtOtro, $txtValorCheque);
            }
            ConsignacionVendedor::model()->InserTransaccinAx($id, $codagencia);
            //$this->GenrarXML($codzona);

            $session['ChequeConsig'] = array();
            $session['ChequeNuevoConsig'] = array();
        }
    }

    /* private function GenrarXML($codzona) {


      $InfoXML = ConsignacionVendedor::model()->Cosignaciones($codzona);


      $xml = '<?xml version="1.0" encoding="utf-8"?>';

      foreach ($InfoXML as  $itemInfo) {

      $valorefectivo = $itemInfo['ValorConsignadoEfectivo'];
      $valorcheque = $itemInfo['ValorConsignadoEfectivo'];

      $total = $valorefectivo+$valorcheque;

      $xml .= '<Panel>';
      $xml .= '<Header>';
      $xml .= '<SalesAreaCode>'.$itemInfo['CodZonaVentas'].'</SalesAreaCode>';
      $xml .= '<AdvisorCode>'.$itemInfo['CodAsesor'].'</AdvisorCode>';
      $xml .= '<Description> Consignación Recaudo Ventas '.$itemInfo['CodZonaVentas'].'</Description>';
      $xml .= '<Date>'.$itemInfo['FechaConsignacion'].'</Date>';


      $xml .= '<detail>';
      $xml .= '<ConsignmentDate>'.$itemInfo['FechaConsignacionVendedor'].'</ConsignmentDate>';
      $xml .= '<Value>'.$total.'</Value>';
      $xml .= '<CityAndOffice>'.$itemInfo['Ciudad'].'--'.$itemInfo['Oficina'].'</CityAndOffice>';
      $xml .= '</detail>';
      $xml .= '</Header>';
      $xml .= '</Panel>';

      }
      // $xml .= '</Panel>';
      echo $xml;
      exit() ;

      } */

    public function actionAjaxConsignaciones() {

        $cont = 0;
        if ($_POST) {

            $zonaVentas = $_POST['codzona'];

            $consignadicones = "";

            $consignadicones.="<div style='width: 100%; overflow-x: scroll'>
          <table class='table' id='table2' style='width: 1600px'>
              <thead>
                 <tr>
                    <th>Nro Consignación</th>
                    <th>Código Zona Venta</th>
                    <th>Código Asesor</th>
                    <th>Banco</th>
                    <th>Cuenta</th>
                    <th>Fecha</th>
                    <th>Valor Efectivo</th>
                    <th>Valor Cheque</th>
                    <th>Oficina</th>
                    <th>Ciudad</th>
                 </tr>
              </thead>
              <tbody>";

            $consig = ConsignacionVendedor::model()->Consignaciones($zonaVentas);

            foreach ($consig as $itemConsig) {
                $cont++;

                $estado = $itemConsig['Estado'];
                if (empty($estado)) {
                    $estado = 0;

                    $consignadicones.="
                     <tr class='odd gradeX'>
                     <td>" . $itemConsig['NroConsignacion'] . "</td>
                     <td>" . $itemConsig['CodZonaVentas'] . "</td>
                     <td>" . $itemConsig['CodAsesor'] . "</td>
                     <td>" . $itemConsig['Nombre'] . "</td>
                     <td>" . $itemConsig['NumeroCuentaBancaria'] . "</td>  
                     <td>" . $itemConsig['FechaConsignacionVendedor'] . "</td>
                     <td>" . $itemConsig['ValorConsignadoEfectivo'] . "</td>
                     <td>" . $itemConsig['ValorConsignadoCheque'] . "</td>
                     <td>" . $itemConsig['Oficina'] . "</td>
                     <td>" . $itemConsig['Ciudad'] . "</td>  
                     <td><a href='javascript:eliminarconsignacion(" . $itemConsig['IdConsignacion'] . ")'><img src='images/delete.png' title='Eliminar' style='width: 27px;'></a></td>

                     </tr>

                 ";
                } else {

                    $estado = 1;

                    $consignadicones.="
                     <tr class='odd gradeX'>
                     <td>" . $itemConsig['NroConsignacion'] . "</td>
                     <td>" . $itemConsig['CodZonaVentas'] . "</td>
                     <td>" . $itemConsig['CodAsesor'] . "</td>
                     <td>" . $itemConsig['Nombre'] . "</td>
                     <td>" . $itemConsig['NumeroCuentaBancaria'] . "</td>  
                     <td>" . $itemConsig['FechaConsignacionVendedor'] . "</td>
                     <td>" . $itemConsig['ValorConsignadoEfectivo'] . "</td>
                     <td>" . $itemConsig['ValorConsignadoCheque'] . "</td>
                     <td>" . $itemConsig['Oficina'] . "</td>
                     <td>" . $itemConsig['Ciudad'] . "</td>  
                     

                     </tr>

                 ";
                }
            }
            $consignadicones.="</tbody>
           </table>
          </div>";
            if ($cont == 0) {
                $consignadicones = "";
            }
            echo $consignadicones;
        }
    }

    public function actionAjaxEliminar() {

        if ($_POST['idconsignacion']) {

            $idconsignacion = $_POST['idconsignacion'];


            ConsignacionVendedor::model()->DeleteConsignacion($idconsignacion);
        }
    }

    public function actionAjaxValidarCod($IdentificadorBanco, $codbanco) {

        $consulta = ConsignacionVendedor::model()->ConsultarBancos($IdentificadorBanco, $codbanco);


        foreach ($consulta as $Item) {

            if ($Item >= 1) {

                echo 'no';
            } else {

                echo 'si';
            }
        }
    }

    public function actionAjaxPrueba() {

        $client = new SoapClient('http://altipal.datosmovil.info/altipalAx/index.php?r=LoadService/action');
        echo $client->getConsignacion('11360');

        echo $client->__getLastRequest();
        echo $client->__getLastResponse();
    }

    public function actionAjaxFormasPagos() {

        if ($_POST) {

            $Zona = $_POST['codzona'];
            $agencia = $_POST['codagencia'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];

            $ReciboCaja = ConsignacionVendedor::model()->getRecibosCajas($Zona, $fechaini, $fechafin, $agencia);

            $formaspago.="<div class='table table-bordered' style='width: 590px;'>
           <table class='table' id='table2'>
            ";

            $efectivo = 0;
            $cheque = 0;
            $consignacionEfectivo = 0;
            $consignacionCheque = 0;
            $posfechado = 0;
            $total = 0;

            foreach ($ReciboCaja as $itemCaja) {

                $ReciboCajaFactura = ConsignacionVendedor::model()->getCajaFactura($itemCaja['Id'], $agencia);
                foreach ($ReciboCajaFactura as $itemCajaFactura) {


                    $Efectivo = ConsignacionVendedor::model()->getEfectivo($itemCajaFactura['Id'], $agencia);
                    $Cheque = ConsignacionVendedor::model()->getCheque($itemCajaFactura['Id'], $agencia);
                    $ConsignacionEfectivo = ConsignacionVendedor::model()->getConsignacionEfectivo($itemCajaFactura['Id'], $agencia);
                    $ConsignacionCheque = ConsignacionVendedor::model()->getConsignacioChequen($itemCajaFactura['Id'], $agencia);
                    $ChequePosfechado = ConsignacionVendedor::model()->getChequePosfechado($itemCajaFactura['Id'], $agencia);

                    if (count($Efectivo) > 0) {
                        $efectivo = $efectivo + $Efectivo[0]['Valor'];
                    }

                    if (count($Cheque) > 0) {

                        $cheque = $cheque + $Cheque[0]['Cheque'];
                    }


                    if (count($ConsignacionEfectivo) > 0) {

                        $consignacionEfectivo = $consignacionEfectivo + $ConsignacionEfectivo[0]['EfectivoConsignacion'];
                    }


                    if (count($ConsignacionCheque) > 0) {

                        $consignacionCheque = $consignacionCheque + $ConsignacionCheque[0]['ConsignacionCheque'];
                    }

                    if (count($ChequePosfechado) > 0) {

                        $posfechado = $posfechado + $ChequePosfechado[0]['ChequePosfechado'];
                    }
                }
            }

            $total = $efectivo + $cheque + $consignacionEfectivo + $consignacionCheque + $posfechado;

            $formaspago.="
                <tr>
                   <td class='text-center'>Efectivo</td>
                   <td class='text-center'>$ " . number_format($efectivo, '2', ',', '.') . "</td>
                </tr> 
                <tr>
                   <td class='text-center'>Cheque</td>
                   <td class='text-center'>$ " . number_format($cheque, '2', ',', '.') . "</td>
                </tr> 
                <tr>
                   <td class='text-center'>Cheque Posfechado</td>
                   <td class='text-center'>$ " . number_format($posfechado, '2', ',', '.') . "</td>
                </tr> 
                <tr>
                   <td class='text-center'>Consignacion Efectivo</td>
                   <td class='text-center'>$ " . number_format($consignacionEfectivo, '2', ',', '.') . "</td>
                </tr> 
                <tr>
                   <td class='text-center'>Consignacion Cheque</td>
                   <td class='text-center'>$ " . number_format($consignacionCheque, '2', ',', '.') . "</td>
                </tr> 
                 <tr>
                   <td class='text-center'>Total</td>
                   <td class='text-center'>$ " . number_format($total, '2', ',', '.') . "</td>
                </tr> 
            ";

            $formaspago.="</table></div>";

            echo $formaspago;
        }
    }

    public function actionAjaxChequesaldiaConsignaciones() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/consignacionVendedor/consignacionvendedor.js', CClientScript::POS_END
        );

        if ($_POST) {

            $zonaVentas = $_POST['codzona'];

            $agencia = $_POST['codagencia'];
            $fechaini = date('Y-m-d');

            $session = new CHttpSession;
            $session->open();
            $datosChequeConsig = $session['ChequeConsig'];
            $datosChequeNuevoConsig = $session['ChequeNuevoConsig'];

            $TotalCheques = array();
            $ReciboCaja = ConsignacionVendedor::model()->getRecibosCajasWeb($zonaVentas, $fechaini, $agencia);

            $contInfo = "";
            foreach ($ReciboCaja as $itemConsig) {

                $ReciboCajaFactura = ConsignacionVendedor::model()->getCajaFactura($itemConsig['Id'], $agencia);

                foreach ($ReciboCajaFactura as $itemCajaFactura) {

                    $ChequeSql = ConsignacionVendedor::model()->getChequeDeldia($itemCajaFactura['Id'], $agencia);

                    $contarCheques = ConsignacionVendedor::model()->ContarChequesdelDia($ChequeSql[0]['NroCheque'], $ChequeSql[0]['CodBanco']);

                   //echo $ChequeSql[0]['NroCheque']."  -  ".$ChequeSql[0]['CodBanco']. "  -  ".$contarCheques['cont'];
                   //die();
                    if ($contarCheques['cont'] > 0) {
                        
                    } else {
                        $Cheque = array_merge((array) $Cheque, (array) $ChequeSql);
                    }
                }
            }
            $Cheque = array_merge((array) $Cheque, (array) $datosChequeNuevoConsig);

            /* echo "<prev>";
              print_r($Cheque);
              echo "<prev>";
              print_r($datosChequeConsig);
              die(); */


            $arrayAux = array();
            $contadoKey = 0;
            foreach ($Cheque as $itemchec) {
                $contadoKey = 0;
                foreach ($datosChequeConsig as $item1) {
                    if ($itemchec['NroCheque'] == $item1['txtNumeroCheque'] && $itemchec['CodBanco'] == $item1['txtBancoCheque']) {
                        $contadoKey++;
                    }
                }

                if ($contadoKey > 0) {
                    
                } else {

                    array_push($arrayAux, $itemchec);
                }
            }


            if (count($arrayAux) > 0) {
                $TotalCheques = $arrayAux;
                echo $contInfo = $this->renderPartial('//mensajes/_alertChequealDiaConsignacionVendedor', array('chequesAldia' => $TotalCheques));
            } else {
                echo $contInfo = "";
            }
        }
    }

    public function sumaEfectivosConsignacion($zonaVentas) {

        $agencia = Yii::app()->user->_Agencia;

        $fechaini = date('Y-m-d');

        $ReciboCaja = ConsignacionVendedor::model()->getRecibosCajasWeb($zonaVentas, $fechaini, $agencia);

        $efectivosConsignados = ConsignacionVendedor::model()->getSumaEfectivoConsgnados($zonaVentas, $agencia, $fechaini);

        foreach ($ReciboCaja as $itemConsig) {

            $ReciboCajaFactura = ConsignacionVendedor::model()->getCajaFactura($itemConsig['Id'], $agencia);
            foreach ($ReciboCajaFactura as $itemCajaFactura) {

                $Efectivo = ConsignacionVendedor::model()->getEfectivo($itemCajaFactura['Id'], $agencia);


                if (count($Efectivo) > 0) {
                    $efectivo = $efectivo + $Efectivo[0]['Valor'];
                }
            }
        }
        //echo $efectivosConsignados['valorEfect']. "  -  ".$efectivo;
        //die();
        $efectivoTotal = $efectivo - $efectivosConsignados[0]['valorEfect'];
        return $efectivoTotal;
    }

    public function actionAjaxSetChequeConsig() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/consignacionVendedor/consignacionvendedor.js', CClientScript::POS_END
        );
        //die('hola');
        $session = new CHttpSession;
        $session->open();
        if ($session['ChequeConsig']) {
            $datos = $session['ChequeConsig'];
        } else {
            $datos = array();
        }

        /* if ($session['ChequeDetalleNuevo']) {
          $datosDetalle = $session['ChequeDetalleNuevo'];
          } else {
          $datosDetalle = array();
          } */

        $txtNumeroCheque = $_POST['txtNumeroCheque'];
        $txtBancoCheque = $_POST['txtBancoCheque'];
        $txtCuentaCheque = $_POST['txtCuentaCheque'];
        $txtFechaCheque = $_POST['txtFechaCheque'];
        $txtValorCheque = $_POST['txtValorCheque'];
        $txtGirado = $_POST['txtGirado'];
        $txtOtro = $_POST['txtOtro'];


        $datosItem = array(
            'txtNumeroCheque' => $txtNumeroCheque,
            'txtBancoCheque' => $txtBancoCheque,
            'txtCuentaCheque' => $txtCuentaCheque,
            'txtFechaCheque' => $txtFechaCheque,
            'txtValorCheque' => $txtValorCheque,
            'txtGirado' => $txtGirado,
            'txtOtro' => $txtOtro,
        );

        foreach ($datos as $item) {
            if ($item['txtBancoCheque'] == $txtBancoCheque && $item['txtNumeroCheque'] == $txtNumeroCheque) {
                echo '0';
                Yii::app()->end();
            }
        }


        array_push($datos, $datosItem);

        $session['ChequeConsig'] = $datos;

        /* $ValorSaldoCheque = 0;
          foreach ($datos as $item) {
          if ($item['facturaRecibo'] == $facturaRecibo && $item['txtNumeroCheque'] == $txtNumeroCheque) {
          $ValorSaldoCheque = $item['txtValorCheque'];
          }
          }

          $arrayAuxi = array();

          foreach ($datosDetalle as $itemDetalle) {

          $facturadetalle = $itemDetalle['txtNumeroCheque'] . '-' . $itemDetalle['txtBancoCheque'];

          if ($facturadetalle == $txtNumeroCheque) {

          $itemDetalle['txtValorChequeSaldo'] = $itemDetalle['txtValorChequeSaldo'] - $ValorSaldoCheque;
          }
          array_push($arrayAuxi, $itemDetalle);
          } */

        // $session['ChequeDetalle'] = $arrayAuxi;
        //echo $this->renderPartial('_cheque', true);
        echo "ok";
    }

    public function actionAjaxDeleteChequeConsig() {

        $session = new CHttpSession;
        $session->open();
        if ($session['ChequeConsig']) {
            $datos = $session['ChequeConsig'];
        } else {
            $datos = array();
        }

        /* if ($session['ChequeDetalle']) {
          $datosDetalle = $session['ChequeDetalle'];
          } else {
          $datosDetalle = array();
          } */

        if ($_POST) {

            $numero = $_POST['numero'];
            $codbanco = $_POST['codbanco'];


            /* foreach ($datos as $item) {
              $txtNumCh = explode('-', $item['txtNumeroCheque']);
              if ($txtNumCh[0] == $numero && $item['txtBancoCheque'] == $codbanco) {

              echo '1';
              return;
              }
              } */


            $arrayAux = array();
            foreach ($datos as $item) {
                if ($item['txtNumeroCheque'] == $numero && $item['txtBancoCheque'] == $codbanco) {
                    
                } else {

                    array_push($arrayAux, $item);
                }
            }

            $session['ChequeConsig'] = $arrayAux;

            //$option = "<option>Seleccione un numero cheque</option>";
            /*  foreach ($arrayAux as $numChe) {

              $option .='<option value="' . $numChe['txtNumeroCheque'] . '-' . $numChe['txtBancoCheque'] . '">' . $numChe['txtNumeroCheque'] . '</option>';
              } */
            echo 'OK';



            //echo $this->renderPartial('_chequeDetail');
        }
    }

    public function actionAjaxSumasChequesConsig() {

        $session = new CHttpSession;
        $session->open();
        if ($session['ChequeConsig']) {
            $datos = $session['ChequeConsig'];
        } else {
            $datos = array();
        }
        $sumaCheques = 0;

        foreach ($datos as $item) {

            $sumaCheques = $sumaCheques + $item['txtValorCheque'];
        }
        echo $sumaCheques;
    }

    public function actionAjaxSetChequeNuevoConsig() {
        //die('hola');
        $session = new CHttpSession;
        $session->open();
        if ($session['ChequeNuevoConsig']) {
            $datos = $session['ChequeNuevoConsig'];
        } else {
            $datosNevo = array();
        }

        /* if ($session['ChequeDetalleNuevo']) {
          $datosDetalle = $session['ChequeDetalleNuevo'];
          } else {
          $datosDetalle = array();
          } */

        $txtNumeroCheque = $_POST['txtNumeroCheque'];
        $txtBancoCheque = $_POST['txtBancoCheque'];
        $txtCuentaCheque = $_POST['txtCuentaCheque'];
        $txtFechaCheque = $_POST['txtFechaCheque'];
        $txtValorCheque = $_POST['txtValorCheque'];
        $txtGirado = $_POST['txtGirado'];
        $txtOtro = $_POST['txtOtro'];


        $datosItem = array(
            'NroCheque' => $txtNumeroCheque,
            'CodBanco' => $txtBancoCheque,
            'CuentaCheque' => $txtCuentaCheque,
            'Fecha' => $txtFechaCheque,
            'ValorTotal' => $txtValorCheque,
            'Girado' => $txtGirado,
            'Otro' => $txtOtro,
        );


        foreach ($datosNevo as $item) {
            if ($item['CodBanco'] == $txtBancoCheque && $item['NroCheque'] == $txtNumeroCheque) {
                echo '0';
                Yii::app()->end();
            }
        }


        array_push($datosNevo, $datosItem);

        $session['ChequeNuevoConsig'] = $datosNevo;

        /* $ValorSaldoCheque = 0;
          foreach ($datos as $item) {
          if ($item['facturaRecibo'] == $facturaRecibo && $item['txtNumeroCheque'] == $txtNumeroCheque) {
          $ValorSaldoCheque = $item['txtValorCheque'];
          }
          }

          $arrayAuxi = array();

          foreach ($datosDetalle as $itemDetalle) {

          $facturadetalle = $itemDetalle['txtNumeroCheque'] . '-' . $itemDetalle['txtBancoCheque'];

          if ($facturadetalle == $txtNumeroCheque) {

          $itemDetalle['txtValorChequeSaldo'] = $itemDetalle['txtValorChequeSaldo'] - $ValorSaldoCheque;
          }
          array_push($arrayAuxi, $itemDetalle);
          } */

        // $session['ChequeDetalle'] = $arrayAuxi;
        //echo $this->renderPartial('_cheque', true);
        echo "ok";
    }

}
