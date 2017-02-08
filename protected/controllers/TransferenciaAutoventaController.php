<?php

class TransferenciaAutoventaController extends Controller {

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
                Yii::app()->baseUrl . '/js/transferenicaAutoventa/transferenicaautoventa.js', CClientScript::POS_END
        );

        $codagencia = Yii::app()->user->_Agencia;


        if ($_POST) {


            $session = new CHttpSession;
            $session->open();
            if ($session['TrnasAutoForm']) {
                $datosTA = $session['TrnasAutoForm'];
            } else {
                $datosTA = array();
            }

            $dis = $_POST['dis'];
            $nombreasesor = $_POST['nombreasesor'];
            $asesor = $_POST['codasesor'];
            $zona = $_POST['zona'];
            $codzonatransferencia = $_POST['codzonatransferencia'];
            $fechatrasnferencia = date('Y-m-d');
            $horadigitado = $_POST['horatranfeautoventa'];
            $horaenviado = date('H:i:s');
            $Estado = '0';
            $ArchivoXml = '';
            $Web = '1';
            $PedidoMaquina = '0';
            $IdentificadorEnvio = '1';
            $CodUbicOrigen = $_POST['CodUbicacionRemitente'];
            $CodUbicDestino = $_POST['CodUbicacionaTransferir'];
            $TotalTransferencia = $_POST['totalTranferencia'];
            

            $arrayencabezado = array(
                'CodAsesor' => $asesor,
                'CodZonaVentas' => $zona,
                'CodZonaVentasTransferencia' => $codzonatransferencia,
                'FechaTransferenciaAutoventa' => $fechatrasnferencia,
                'HoraDigitado' => $horadigitado,
                'HoraEnviado' => $horaenviado,
                'Estado' => $Estado,
                'ArchivoXml' => $ArchivoXml,
                'Web' => $Web,
                'PedidoMaquina' => $PedidoMaquina,
                'IdentificadorEnvio' => $IdentificadorEnvio,
                'CodigoCanal' => $session['canalEmpleado'],
                'Responsable' => $session['Responsable'],
                'CodigoUbicacionOrigen' => $CodUbicOrigen,
                'CodigoUbicacionDestino' => $CodUbicDestino,
                'TotalTransferencia' => $TotalTransferencia
            );

            $model = new Transferenciaautoventa;
            $model->attributes = $arrayencabezado;
            
            
           
            foreach ($datosTA as $IteDetalle) {
                
                $TotalPrecioneto  = $IteDetalle['PrecioVenta'] * $IteDetalle['Cantidad'];
              
                if ($model->validate()) {

                    $model->save();

                    $IdTransferenciaAutoventa = $model->IdTransferenciaAutoventa;
                    $cantidad = $IteDetalle['Cantidad'];
                    $lote = $IteDetalle['Lote'];
                    $variante = $IteDetalle['CodVariante'];
                    $nombrearticulo = $IteDetalle['NombreArticulo'];
                    $codunidadmedida = $IteDetalle['CodigoUnidadMedida'];
                    $unidadmedida = $IteDetalle['NombreUnidadMedida'];
                    $codarticulo = $IteDetalle['CodigoArticulo'];
                    $PedidoMaquina = '0';
                    $IdentificadorEnvio = '1';
                    $precioVenta = $IteDetalle['PrecioVenta'];


                    $detalle = array(
                        'IdTransferenciaAutoventa' => $IdTransferenciaAutoventa,
                        'CodVariante' => $variante,
                        'CodigoArticulo' => $codarticulo,
                        'NombreArticulo' => $nombrearticulo,
                        'CodigoUnidadMedida' => $codunidadmedida,
                        'NombreUnidadMedida' => $unidadmedida,
                        'Cantidad' => $cantidad,
                        'Lote' => $lote,
                        'PedidoMaquina' => $PedidoMaquina,
                        'IdentificadorEnvio' => $IdentificadorEnvio,
                        'ValorUnitario'=>$precioVenta,
                        'TotalPrecioNeto'=> $TotalPrecioneto
                    );
                    
             
                    $modelDetalle = new Descripciontransferenciaautoventa;
                    $modelDetalle->attributes = $detalle;

                    if (!$modelDetalle->validate()) {

                        print_r($modelDetalle->getErrors());
                    } else {
                        $modelDetalle->save();
                        //$this->TransAutoventaXML($zona);
                    }
                } else {

                    print_r($model->getErrors());
                }
            }
            
            
            foreach ($datosTA as $IteDetalle){
                
                  $variante = $IteDetalle['CodVariante'];
                  $lote = $IteDetalle['Lote'];
                
                  $SaldosAutoventa = Transferenciaautoventa::model()->getSaldosAutoventa($CodUbicOrigen, $variante, $lote);
                    
                  if($SaldosAutoventa['CodigoUbicacion'] == $CodUbicOrigen && $SaldosAutoventa['CodigoVariante'] == $variante && $SaldosAutoventa['LoteArticulo'] == $lote){
                        
                       $Saldo = $SaldosAutoventa['Disponible'] - $IteDetalle['Cantidad']; 
                       
                       $UpdateSaldoAurtoventa = Transferenciaautoventa::model()->UpdateSaldo($CodUbicOrigen,$variante,$Saldo);
                        
                  } 
                
            }
                
            

            $codtipodoc = '3';
            $estado = '0';

            $TransaxConsigaAuto = array(
                'CodTipoDocumentoActivity' => $codtipodoc,
                'IdDocumento' => $IdTransferenciaAutoventa,
                'CodigoAgencia' => $codagencia,
                'EstadoTransaccion' => $estado
            );


            $modeltransax = new Transaccionesax;
            $modeltransax->attributes = $TransaxConsigaAuto;

            if (!$modeltransax->validate()) {

                print_r($modeltransax->getErrors());
            } else {

                $modeltransax->save();
            }


            $fechamnesaje = date('Y-m-d');
            $horamensaje = date('H:m:s');
            $mensaje = 'Se realizo a su  zona ventas una transferencia de autoventa enviada por la zona de ventas "' . $zona . '" correspondiente al asesor "' . $asesor . '" - "' . $nombreasesor . '"';
            $mensajeestado = '0';

            $mensaje = array(
                'IdDestinatario' => $codzonatransferencia,
                'IdRemitente' => $zona,
                'FechaMensaje' => $fechamnesaje,
                'HoraMensaje' => $horamensaje,
                'Mensaje' => $mensaje,
                'Estado' => $mensajeestado,
                'CodAsesor' => $asesor    
            );


            $modelMensaje = new Mensajes;
            $modelMensaje->attributes = $mensaje;

            if (!$modelMensaje->validate()) {

                print_r($modelMensaje->getErrors());
                
            } else {
                $modelMensaje->save();
            }
            
           
            Yii::app()->user->setFlash('success', '');
        }




        $informacion = Consultas::model()->getAutoVentasInformacion($zonaVentas);
        $portafolioZonaVentas = Consultas::model()->getPortafolioTranAutoventa($zonaVentas);


        $this->render('index', array(
            'zonaVentas' => $zonaVentas,
            'informacion' => $informacion,
            'portafolioZonaVentas' => $portafolioZonaVentas
        ));
    }

    /*private function TransAutoventaXML($codzona) {

        $InfoXMl = Transferenciaautoventa::model()->getTransferenciaAutoventa($codzona);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXMl as $itemInfo) {

            $xml .= '<panel>';
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<DailyCode>012</DailyCode>';
          

            $InfoXMLDetail = Transferenciaautoventa::model()->getDescripcionTrnasAtoventa($itemInfo['IdTransferenciaAutoventa']);

            foreach ($InfoXMLDetail as $Itemdetail) {

                $xml .= '<Detail>';
                $xml .= '<Date>' . $itemInfo['FechaTransferenciaAutoventa'] . '</Date>';
                $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                $xml .= '<OriginUbication>' . $itemInfo['CodigoUbicacionOrigen'] . '</OriginUbication>';
                $xml .= '<DestinyUbication>' . $itemInfo['CodigoUbicacionDestino'] . '</DestinyUbication>';
                $xml .= '<FromBatch>' . $Itemdetail['Lote'] . '</FromBatch>';
                $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                $xml .= '</Detail>';
                $xml .= '</Header>';
            }
            $xml .= '</panel>';
        }
        echo $xml;
        exit();
    }*/

    public function actionAjaxAddTransaccionAutoventa() {

        if ($_POST['codvarinate']) {


            $session = new CHttpSession;
            $session->open();
            $datos = $session['TrnasAutoForm'];



            $codvarinate = $_POST['codvarinate'];
            $asesor = $_POST['asesor'];
            $zona = $_POST['zona'];
            $transAuto = "";

            //$modal = Consultas::model()->getAddAtoventas($codvarinate, $asesor, $zona);
            $modal = Consultas::model()->getAddAtoventas($codvarinate);
            
            $datosArticulo = Consultas::model()->getArticuloByVariante($codvarinate);




            if ($modal['Disponible'] == 0 || $modal['LoteArticulo'] == null) {

                echo ' 
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">Este producto no tiene saldo disponible</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Cerrar</button>        
            </div>
        ';
            } else {


                $transAuto.='
                <div class="form-group">
                    <label class="col-sm-4 control-label">Código Artículo:</label>
                    <div class="col-sm-6">
                        <input type="text" id="codvariante"  class="form-control" value="' . $modal['CodigoVariante'] . '" readonly="true"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Nombre Artículo:</label>
                    <div class="col-sm-6">
                        <input type="text" id="nombrearticulo"  class="form-control" value="' . $modal['NombreArticulo'] . $modal['Caracteristica1'] . $modal['Caracteristica2'] . '(' . $modal['CodigoTipo'] . ')' . '" readonly="true"/>
                    </div>
                </div>
                
             
                <div class="form-group">
                    <label class="col-sm-4 control-label">Unidad Medida:</label>
                    <div class="col-sm-6">
                        <input type="text" id="unidadmedida"  class="form-control" value="' . $modal['NombreUnidadMedida'] . '" readonly="true"/>
                    </div>
                </div>
                
                 <input type="hidden" value="' . $modal['CodigoUnidadMedida'] . '" id="codunidad">   
                     
                 <input type="hidden" value="' . $modal['PrecioVenta'] . '" id="precioventa">   
               
                  <label>Seleccionar el número de lote del producto</label>
                  <br>
                  

                <div class="form-group">
                    <label class="col-sm-4 control-label">Lote:</label>
                    <div class="col-sm-6">
                       <select name="lote" class="form-control" id="selectlote" required onchange="Unidaddisponible()">';
                //$lotes = Consultas::model()->getAddAtoventasAll($codvarinate, $asesor, $zona);
                $lotes = Consultas::model()->getAddAtoventasAll($codvarinate,$zona,$asesor);
                $conlotes = count($lotes);
                if ($conlotes > 1) {
                    '<option value="">Seleccione un lote</option>';
                }
                //$lotes = Consultas::model()->getAddAtoventasAll($codvarinate, $asesor, $zona);
                $contador_validation = 0;
                foreach ($lotes as $itelotes) {
                    $contar_lotes = 0;
                    foreach ($datos as $ItemDa) {
                        if ($ItemDa['CodVariante'] == $codvarinate && $ItemDa['Lote'] == $itelotes['LoteArticulo']) {
                            $contar_lotes++;
                            break;
                        }
                    }
                    if ($contar_lotes == 0) {
                        $contador_validation++;
                        $transAuto.='<option value="' . $itelotes['LoteArticulo'] . '">' . $itelotes['LoteArticulo'] . '</option>';
                    }
                }
                if ($contador_validation == 0) {

                    echo ' 
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">Este producto ya no cuenta con lotes disponibles, elimine o modifique los lotes que ya haya seleccionado para este producto</p>
                    </div>
                </div>
            </div>
          ';
                }
                $transAuto.='</select>
                    </div>
                     <br>
                     <br>
                     <div class="col-sm-offset-5">
                    <div id="MsgError"></div>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Precio Venta:</label>
                    <div class="col-sm-6">
                        <input type="text" id="txtPrecioVenta" class="form-control" value="' . number_format($modal['PrecioVenta'], '2',',','.') . '" readonly="true"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Saldo Disponible:</label>
                    <div class="col-sm-6">
                        <div id="disponibles"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Cantidad Transferir:</label>
                    <div class="col-sm-6">
                        <input type="number" id="txtCantidad" class="form-control" onkeypress="return FilterInput (event)"/>
                    </div>
                     <br>
                     <br>
                     <div class="col-sm-offset-5">  
                    <div  id="MsgErrorDis"></div>
                    </div>
                    
                </div>
                  
                    
                
                 <input type="hidden" value="' . $codvarinate . '" id="variante">
                     

                 <input type="hidden" id="nombrearticulo" value="' . $datosArticulo['NombreArticulo'] . $datosArticulo['CodigoCaracteristica1'] . $datosArticulo['CodigoCaracteristica2'] . '">
                     
                 <input type="hidden" id="codarticulo" value="' . $datosArticulo['CodigoArticulo'] . '">
                       
                 <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-adicionar-pro">Adicionar</button>
            </div>       
                 ';


                echo $transAuto;
            }
        }
    }

    public function actionAjaxAgregarItemTransferenciaAutoventa() {


        if ($_POST) {


            $session = new CHttpSession;
            $session->open();
            if ($session['TrnasAutoForm']) {
                $datosTA = $session['TrnasAutoForm'];
            } else {
                $datosTA = array();
            }
            
            if($session['TrnasAutoPedido']){
               $datosPedido =  $session['TrnasAutoPedido'];
            }else{
                
                $datosPedido = array();  
            }



            $asesor = $_POST['asesor'];
            $zona = $_POST['codzona'];
            $codzonatransferencia = $_POST['codzonatransferencia'];
            $fechatrasnferencia = date('Y-m-d');
            $horadigitado = date('H:m:s');
            $horaenviado = date('H:m:s');
            $Estado = '';
            $ArchivoXml = '';
            $Web = '1';
            $PedidoMaquina = '0';
            $IdentificadorEnvio = '1';
            
            $PedidoZonaVenta = Consultas::model()->getPedidoZonaVentas($codzonatransferencia);
            $CupoLimite = Consultas::model()->getCupoLimite($codzonatransferencia);  

            $arrayencabezado = array(
                'CodAsesor' => $asesor,
                'CodZonaVentas' => $zona,
                'CodZonaVentasTransferencia' => $codzonatransferencia,
                'FechaTransferenciaAutoventa' => $fechatrasnferencia,
                'HoraDigitado' => $horadigitado,
                'HoraEnviado' => $horaenviado,
                'Estado' => $Estado,
                'ArchivoXml' => $ArchivoXml,
                'Web' => $Web,
                'PedidoMaquina' => $PedidoMaquina,
                'IdentificadorEnvio' => $IdentificadorEnvio,
            );



            $IdTransferenciaAutoventa = $model->IdTransferenciaAutoventa;
            $dis = $_POST['dis'];
            $cantidad = $_POST['cantidad'];
            $lote = $_POST['selectlote'];
            $variante = $_POST['variante'];
            $nombrearticulo = $_POST['nombrearticulo'];
            $codunidadmedida = $_POST['codunidad'];
            $unidadmedida = $_POST['unidadmedida'];
            $codarticulo = $_POST['codarticulo'];
            $PedidoMaquina = '0';
            $IdentificadorEnvio = '1';
            $precioVenta = $_POST['precioventa'];
            $TotalPedidos = $PedidoZonaVenta['Pedidos'];
            $CupoLimiteAutoventa = $CupoLimite['CupoLimiteAutoventa'];
            
          

            $detalle = array(
                'IdTransferenciaAutoventa' => $IdTransferenciaAutoventa,
                'CodVariante' => $variante,
                'CodigoArticulo' => $codarticulo,
                'NombreArticulo' => $nombrearticulo,
                'CodigoUnidadMedida' => $codunidadmedida,
                'NombreUnidadMedida' => $unidadmedida,
                'Cantidad' => $cantidad,
                'Lote' => $lote,
                'PedidoMaquina' => $PedidoMaquina,
                'IdentificadorEnvio' => $IdentificadorEnvio,
                'dis' => $dis,
                'PrecioVenta' => $precioVenta,
                
            );
            
            $pedidos = array(
              'TotalPedidos'=>$TotalPedidos,  
              'CupoLimiteAutoventa'=>$CupoLimiteAutoventa,
              'CodzonaTransferencia'=>$codzonatransferencia    
            );

            array_push($datosTA, $detalle);
            $session['TrnasAutoForm'] = $datosTA;
            
            $session['TrnasAutoPedido'] = $pedidos;

            echo $this->renderPartial('_view', array(), true);
        }
    }

    public function actionAjaxEliminarTransferenciaAutoventa() {

        $session = new CHttpSession;
        $session->open();
        $datos = $session['TrnasAutoForm'];

        if ($_POST) {

            $variante = $_POST['variante'];
            $lote = $_POST['lote'];

            // $arrayDatos = array();
            $cont = 0;
            $position = -1;
            $busqueda = false;
            foreach ($datos as $itemDatos) {
                if ($itemDatos['CodVariante'] == $variante && $itemDatos['Lote'] == $lote) {
                    $busqueda = true;
                    $position = $cont;
                }
                $cont++;
            }


            $auxiliar = array();



            if ($busqueda) {
                $llaves = array_keys($datos);
                foreach ($llaves as $key => $value) {

                    if ($datos[$value]['CodVariante'] == $variante && $datos[$value]['Lote'] == $lote) {
                        $position = $value;
                    }
                }

                unset($datos[$position]);
            }


            $session['TrnasAutoForm'] = $datos;

            echo $this->renderPartial('_view', array(), true);
        }
    }

    public function actionAjaxActualizaPortafolioAgregar() {

        $session = new CHttpSession;
        $session->open();
        $datos = $session['TrnasAutoForm'];

        $articulosAgregados = array();

        foreach ($datos as $itemDatos) {
            array_push($articulosAgregados, $itemDatos['CodVariante']);
        }
        echo json_encode($articulosAgregados);
    }

    public function actionAjaxCantidadDisponible() {


        if ($_POST['lote']) {


             $lote = $_POST['lote'];
             $variante = $_POST['variante'];
             $asesor = $_POST['asesor'];
              
            $disponibles = "";

            $cantidad = Consultas::model()->getCantidadDisponible($lote, $asesor, $variante);
            // $cantidad = Consultas::model()->getCantidadDisponible($lote,$variante);


            $disponibles.='<input type="text" readonly="readonly" value="' . $cantidad['Disponible'] . '" id="dis" class="form-control">                  
                ';


            echo $disponibles;
        }
    }

    public function actiontabla() {


        echo $this->renderPartial('_view', array(), true);
    }

    public function actionAjaxConsultarTransferenciaAutoventa() {

        if ($_POST) {

            $session = new CHttpSession;
            $session->open();
            $datos = $session['TrnasAutoForm'];


            $variante = $_POST['variante'];
            $lote = $_POST['lote'];

            $arrayDatos = array();
            foreach ($datos as $itemDatos) {
                if ($itemDatos['CodVariante'] == $variante && $itemDatos['Lote'] == $lote) {
                    $arrayDatos = $itemDatos;
                }
            }
//            echo'<pre>';
//            print_r($arrayDatos);

            echo $this->renderPartial('_datalleProducto', array(
                'arrayDatos' => $arrayDatos,
                    ), true);
        }
    }

    public function actionAjaxActualizarTransferenciaAutoventa() {

        if ($_POST) {

            $session = new CHttpSession;
            $session->open();
            $datos = $session['TrnasAutoForm'];

            $variante = $_POST['codvariante'];
            $lote = $_POST['lote'];
            $cantidad = $_POST['cantidad'];


            $arrayDatos = array();
            $busqueda = false;
            $position = '';
            foreach ($datos as $clave => $itemDatos) {

                if ($itemDatos['CodVariante'] == $variante && $itemDatos['Lote'] == $lote) {
                    $arrayDatos = $itemDatos;
                    $position = $clave;
                    $busqueda = true;
                }
            }

            if ($busqueda) {


                $datos[$position]['Cantidad'] = $cantidad;
            }

            $session['TrnasAutoForm'] = $datos;
            echo $this->renderPartial('_view', array(), true);
        }
    }

    public function actionAjaxLotesDisponibles() {

        if ($_POST) {

            $session = new CHttpSession;
            $session->open();
            $datos = $session['TrnasAutoForm'];

            $variante = $_POST['variante'];
            $lote = $_POST['lote'];


            $busqueda = false;
            foreach ($datos as $itemDatos) {
                if ($itemDatos['CodVariante'] == $variante && $itemDatos['Lote'] == $lote) {
                    $busqueda = true;
                }
            }
            if ($busqueda) {

                echo 1;
            } else {

                echo 0;
            }
        }
    }

    public function actionGenerarPdf($id) {


        if ($id) {

            $mPDF1 = Yii::app()->ePdf->mpdf();
            $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');

            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.min.css');
            $mPDF1->WriteHTML($stylesheet, 1);

            $transferenciaAutoventa = ModelTransferenciaAutoventa::model()->getTransferenciaAutoventa($id);

            $mPDF1->WriteHTML($this->renderPartial('_generarPdf', array(
                        'transferenciaAutoventa' => $transferenciaAutoventa
                            ), true));
            $mPDF1->Output();
        }
    }

    public function actionAjaxGenrarUbiacion() {


        if ($_POST) {

            $zona = $_POST['zona'];

            $input = "";

            $DestinoUbicacion = Consultas::model()->getCodUbicacionaTransferir($zona);

            foreach ($DestinoUbicacion as $ItemUbicacion) {

                $input.='
                      <input type="hidden" name="CodUbicacionaTransferir"  class="form-control"  id="CodUbicacion" value="' . $ItemUbicacion . '"/>
                     ';
            }

            echo $input;
        }
    }
    
    
    public function actionAjaxGenrarCupo() {


        if ($_POST) {

            $zona = $_POST['zona'];

            $CupoLimite = Consultas::model()->getCupoLimite($zona);
            $PedidoZonaVenta = Consultas::model()->getPedidoZonaVentas($zona);
            
            
            $datosZona = array(
              'CupoLimite'=>$CupoLimite['CupoLimiteAutoventa'],
              'TotalPedidos'=>$PedidoZonaVenta['Pedidos']  
            );
            
            echo json_encode($datosZona);
        }
    }
    
    
    
 
}
