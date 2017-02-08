<?php

class NotasCreditoController extends Controller {

    public function filters() {
        return array('accessControl'); // perform access control for CRUD operations
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated users to access all actions
                'users' => array('@'),
            ),
            array('deny'),
        );
    }

    public function actionIndex($cliente, $zonaVentas) {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/notasCredito/notascredito.js', CClientScript::POS_END
        );

        $session = new CHttpSession;
        $session->open();


        $clien = Notascredito::model()->getClientesNotaCredito($cliente);

        $zonaVenta = Notascredito::model()->getZonaNotaCredito($zonaVentas);

        $asesor = Notascredito::model()->getAsesorNotaCredito($zonaVentas);


        $this->render('index', array(
            'clien' => $clien,
            'zonaVenta' => $zonaVenta,
            'zona' => $zonaVentas,
            'cli' => $cliente,
            'asesor' => $asesor,
            'CodigoCanal' => $session['canalEmpleado'],
            'Responsable' => $session['Responsable'],
        ));
    }

    public function actionConsceptos() {
        $idConceptosNota = $_POST['Interfaz'];
        echo $idConceptosNota;

        $data = Conceptosnotacredito::model()->findAll(array("condition" => "Interfaz = $idConceptosNota"));

        $data = CHtml::listData($data, 'CodigoConceptoNotaCredito', 'NombreConceptoNotaCredito');
        echo "<option value=''>Seleccione un concepto</option>";
        foreach ($data as $value => $concepto_name)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($concepto_name), true);
    }

    public function actionFabricantes() {
        $idFactura = $_POST['NumeroFactura'];
        echo $idFactura;
        $data = Consultas::model()->getFabricantes($idFactura);

        $data = CHtml::listData($data, 'CuentaProveedor', 'NombreCuentaProveedor');
        echo "<option value=''>Seleccione un fabricante</option>";
        foreach ($data as $value => $fabricante_name)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($fabricante_name), true);
    }

    public function actionAjaxGenerarDetalle() {

        if ($_POST) {

            $factura = $_POST['fac'];
            $fabricante = $_POST['fabricante'];

            if ($fabricante == "") {

                $detalle = "";

                $detalle.="<div class='table-responsive'>
            <table class='table table-striped mb30'>
            <thead>
            <tr>
            
            <th>Código Artículo</th>
            <th>Nombre Artículo</th>
            <th>Proveedor</th>
            <th>Cantidad</th>
            <th>Valor</th>
            

         

          </tr>
           </thead>
              <tbody>";

                $deta = Notascredito::model()->getDetalleFactura($factura);

                foreach ($deta as $itemdetalle) {
                    
                 if($itemdetalle['NombreArticulo'] == NULL){
                     
                     $NombreArticulo = 'N/A';
                     
                 }else{
                     
                     $NombreArticulo = $itemdetalle['NombreArticulo'];
                 }
                 
                 if($itemdetalle['NombreCuentaProveedor'] == NULL){
                     
                     $NombreProveedor = '';
                 }else{
                     
                     $NombreProveedor = $itemdetalle['NombreCuentaProveedor'];
                 }
                 
                 $valor = ceil($itemdetalle['ValorNetoArticulo']);
                    $detalle.="<tr>
                <td>" . $itemdetalle['CodigoVariante'] . "</td>
                <td>" . $NombreArticulo . "</td>
                <td>" . $NombreProveedor . "</td>
                <td>" . $itemdetalle['CantidadFacturada'] . "</td>
                <td nowrap='nowrap'>$ " . number_format($valor, '2', ',', '.') . "</td>
                
            </tr>";
                }
                $detalle.="</tbody></table></div>";

                echo $detalle;
            } else {



                $detalle = "";

                $detalle.="<div class='table-responsive'>
            <table class='table table-striped mb30'>
            <thead>
            <tr>
            
            <th>Código Artículo</th>
            <th>Nombre Artículo</th>
            <th>Proveedor</th>
            <th>Cantidad</th>
            <th>Valor</th>
            
         

          </tr>
           </thead>
              <tbody>";

                $deta = Notascredito::model()->getDetalleFacturaFabricante($factura, $fabricante);


                foreach ($deta as $itemdetalle) {
                    
                 if($itemdetalle['NombreArticulo'] == NULL){
                     
                     $NombreArticulo = 'N/A';
                     
                 }else{
                     
                     $NombreArticulo = $itemdetalle['NombreArticulo'];
                 }
                 
                 if($itemdetalle['NombreCuentaProveedor'] == NULL){
                     
                     $NombreProveedor = '';
                 }else{
                     
                     $NombreProveedor = $itemdetalle['NombreCuentaProveedor'];
                 }   
                    

                    $detalle.="<tr>
                <td>" . $itemdetalle['CodigoVariante'] . "</td>
                <td>" . $NombreArticulo . "</td>
                <td>" . $NombreProveedor . "</td>
                <td>" . $itemdetalle['CantidadFacturada'] . "</td>
                <td>$ " . number_format($itemdetalle['ValorNetoArticulo'], '2', ',', '.') . "</td>
                
            </tr>";
                }
                $detalle.="</tbody></table></div>";

                echo $detalle;
            }
        }
    }

    public function actionAjaxGuardar() {


        if ($_POST) {


            $valor = $_POST['valor'];
            $obser = $_POST['obser'];
            $conceptos = $_POST['conceptos'];
            $factura = $_POST['factura'];
            $fabricante = $_POST['Fabricante'];
            $codzona = $_POST['codzona'];
            $cuentacliene = $_POST['cliente'];
            $responsable = $_POST['responsable'];
            $asesor = $_POST['asesor'];
            $canal = $_POST['canal'];
            $reponsablecanal = $_POST['responsablecanal'];
            $codagencia = $_POST['codagencia'];

            $nombre = $_POST["fot"];
            $nombre2 = $_POST["fot1"];
            $nombre3 = $_POST["fot3"];
            
            $codDimencionConcepto = Notascredito::model()->getDimencionesConceptos($conceptos);        
            
            $codDimencion =  $codDimencionConcepto[0]['CodigoDimension'];
            
            $src = $carpeta . $nombre;

            move_uploaded_file($ruta_provisional, $src);



            if ($responsable == 1) {

                $detallesumaaltipal = Notascredito::model()->getSumaDetalleAltipal($factura);

                $detallesumaaltipal['valordetalle'];


                $valornotasAltipal = Notascredito::model()->getSumaNotasCreditosAltipal($factura);

                $valornotasAltipal['ValorNotasaltipal'];

                $valoravalidar = $detallesumaaltipal['valordetalle'] - $valornotasAltipal['ValorNotasaltipal'];

                $valoravalidar;

                if ($valor > $valoravalidar) {

                    echo 'El valor ingresado es superior al valor del saldo de la factura por lo tanto este valor no es permitido,el saldo dispoble es de:  ' . number_format($valoravalidar, '2', ',', '.') . '';
                } else {


                 $id = Notascredito::model()->InsertNotasCredito($codzona, $asesor, $cuentacliene, $responsable, $conceptos, $fabricante, $factura, $valor, $obser, $canal, $reponsablecanal,$codDimencion);
                 //Notascredito::model()->InsertServiceNotasCredito($id, $codagencia);
                 if($nombre !=""){               
                    Notascredito::model()->InsertImagenesNotasCredito($id, $nombre, $codzona, $cuentacliene, $factura);
                 }  
                    
                    echo $id;
                   
                }
                
                $administracionConcpetosNotasCreditoAltipal = Notascredito::model()->getAdministradoresConfiguradosConceptosNotasCredito($conceptos);
                $codAgencia = Yii::app()->user->_Agencia;
                $Agencia = Consultas::model()->getAgencia($codAgencia);
                $nombreAgencia = $Agencia['Nombre'];    
                
                foreach ($administracionConcpetosNotasCreditoAltipal as $admin){
                
               
                $nombres = $admin['Nombres'];
                $apellidos = $admin['Apellidos'];
                $email = $admin['Email'];
                
                if (!empty($email)) {
                    $body = '<div align="center">
                        <div>
                                <div>
                                    <h3 style="alignment-adjust: central"><b> APROBACI&Oacute;N DE DOCUMENTOS </b></h4>
                                </div>
                        </div>
                        <div>
                            <div>
                                <h3><i>Nota Crédito Pendiente Por Aprobaci&oacute;n</i></h4>
                            </div>
                            <div>
                                <div >
                                    <div >
                                        <div >  
                                            <h4><i>Sr(angel) ' . $nombres . '   ' . $apellidos . '  se registro una nota crédito en la agencia de ' . $nombreAgencia . ', el cual se encuentra pendiente para su aprobaci&oacute;n.</i></h4>   
                                        </div>         
                                        <div>  
                                            <h4><i>Recuerde ingresar con su respectivo usuario y clave a la plataforma: <a href="http://altipal.datosmovil.info/altipalAx/" target="_blank">Altipal Ax 2015</a>
                                                                para la oportuna aprobaci&oacute;n del documento.</i></h4>
                                        </div>       
                                    </div>
                                    <br>
                                    <div >
                                        <div >
                                            <h5><i>Este correo electr&oacute;nico y cualquier anexo o respuesta relacionada puede contener datos e informaci&oacute;n confidenciales y estar legalmente protegido. En caso de que lo haya recibido por error, por favor hacer caso omiso a este e-mail, no lea, copie, imprima o reenv&iacute;e este mensaje o cualquier anexo, o divulgue su(s) contenido(s) a terceros, y b&oacute;rrelo inmediatamente de su sistema. Los mensajes electr&oacute;nicos no son seguros y, por lo tanto, no nos responsabilizaremos por cualquier consecuencia relacionada al uso de este mensaje (inclusive da&ntilde;os causados por cualquier virus). Gracias.</i></h5>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        </div>
                        </div>';

                    $this->enviarCorreo($email, $body);
                    
                 } 
                
                    
                }
                
                
            } elseif ($responsable == 2) {
                //aqui sumo todos lo valoresnetosarticulo
                $detallesumaaltipal = Notascredito::model()->getSumaDetalleAltipal($factura);
                //sumo las notas creditos del proveedor
                $sumanotascreditosproveedor = Notascredito::model()->getSumaNotasCretidtoProveedor($fabricante, $factura);
                //sumo valoresnotas donde fabricante es igual a vacio
                $sumaproveedorbyaltipal = Notascredito::model()->getSumaNotasCretidtoProveedorbyAltipal($factura);

                $sumadetalleproveedor = Notascredito::model()->getSumaDetalleProveedor($fabricante, $factura);


                if ($sumanotascreditosproveedor['ValorNotasProveedor'] == "") {


                    $sumanotascreditosproveedor = 0;
                }


                //echo $detallesumaaltipal['valordetalle'];  echo $sumaproveedorbyaltipal['ValorNotasProveedorByAltipal'];
                if ($sumanotascreditosproveedor == 0) {


                    $total1 = $detallesumaaltipal['valordetalle'] - $sumanotascreditosproveedor - $sumaproveedorbyaltipal['ValorNotasProveedorByAltipal'];
                } else {

                    $total1 = $detallesumaaltipal['valordetalle'] - $sumanotascreditosproveedor['ValorNotasProveedor'] - $sumaproveedorbyaltipal['ValorNotasProveedorByAltipal'];
                }



                if ($total1 > 0) {

                    $total2 = $sumadetalleproveedor['detalleproveedro'] - $sumanotascreditosproveedor['ValorNotasProveedor'];
                }



                if ($valor > $total2) {

                    echo "El valor ingresado es superior al valor del saldo de la factura por lo tanto este valor no es permitido,el saldo disponible es: " . number_format($total2, '2', ',', '.') . " ";
                } else {

                    $id = Notascredito::model()->InsertNotasCredito($codzona, $asesor, $cuentacliene, $responsable, $conceptos, $fabricante, $factura, $valor, $obser, $canal, $reponsablecanal,$codDimencion);
                    //Notascredito::model()->InsertServiceNotasCredito($id, $codagencia);
                    if($nombre !=""){ 
                    Notascredito::model()->InsertImagenesNotasCredito($id, $nombre, $codzona, $cuentacliene, $factura);
                    }
                    echo $id;
                  
                }
                
                $administracionConcpetosNotasCreditoProveedor = Notascredito::model()->getAdministradoresConfiguradosConceptosNotasCredito($conceptos);
                $codAgencia = Yii::app()->user->_Agencia;
                $Agencia = Consultas::model()->getAgencia($codAgencia);
                $nombreAgencia = $Agencia['Nombre'];    
                
                foreach ($administracionConcpetosNotasCreditoProveedor as $admin){
                
               
                $nombres = $admin['Nombres'];
                $apellidos = $admin['Apellidos'];
                $email = $admin['Email'];
                
                if (!empty($email)) {
                    $body = '<div align="center">
                        <div>
                                <div>
                                    <h3 style="alignment-adjust: central"><b> APROBACI&Oacute;N DE DOCUMENTOS </b></h4>
                                </div>
                        </div>
                        <div>
                            <div>
                                <h3><i>Nota Crédito Pendiente Por Aprobaci&oacute;n</i></h4>
                            </div>
                            <div>
                                <div >
                                    <div >
                                        <div >  
                                            <h4><i>Sr(angel) ' . $nombres . '   ' . $apellidos . '  se registro una nota credito en la agencia de ' . $nombreAgencia . ', el cual se encuentra pendiente para su aprobaci&oacute;n.</i></h4>   
                                        </div>         
                                        <div>  
                                            <h4><i>Recuerde ingresar con su respectivo usuario y clave a la plataforma: <a href="http://altipal.datosmovil.info/altipalAx/" target="_blank">Altipal Ax 2015</a>
                                                                para la oportuna aprobaci&oacute;n del documento.</i></h4>
                                        </div>       
                                    </div>
                                    <br>
                                    <div >
                                        <div >
                                            <h5><i>Este correo electr&oacute;nico y cualquier anexo o respuesta relacionada puede contener datos e informaci&oacute;n confidenciales y estar legalmente protegido. En caso de que lo haya recibido por error, por favor hacer caso omiso a este e-mail, no lea, copie, imprima o reenv&iacute;e este mensaje o cualquier anexo, o divulgue su(s) contenido(s) a terceros, y b&oacute;rrelo inmediatamente de su sistema. Los mensajes electr&oacute;nicos no son seguros y, por lo tanto, no nos responsabilizaremos por cualquier consecuencia relacionada al uso de este mensaje (inclusive da&ntilde;os causados por cualquier virus). Gracias.</i></h5>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        </div>
                        </div>';

                    $this->enviarCorreo($email, $body);
                    
                 } 
                
                    
                }
                
                
            }
            
              //$this->NotasCreditoXML($codzona);
        }

        if ($_FILES) {
            
             if($_FILES["foto"] != ""){

            $file = $_FILES["foto"];
            $nombre = $file["name"];
            $tipo = $file["type"];
            $ruta_provisional = $file["tmp_name"];
            $size = $file["size"];
            $dimensiones = getimagesize($ruta_provisional);
            $width = $dimensiones[0];
            $height = $dimensiones[1];
            $carpeta = "imagenes/";
          
             }
            $id = $_POST['id'];


            if ($_FILES["foto1"] != "") {

                //$id = Yii::app()->db->getLastInsertID('notascredito');

                $file2 = $_FILES["foto1"];
                $nombre2 = $file2["name"];
                $tipo2 = $file2["type"];
                $ruta_provisional2 = $file2["tmp_name"];
                $size2 = $file2["size"];
                $dimensiones2 = getimagesize($ruta_provisional2);
                $width = $dimensiones[0];
                $height = $dimensiones[1];
                $carpeta2 = "imagenes/";




                Notascredito::model()->InsertImagenesNotasCredito($id, $nombre2, $codzona, $cuentacliene, $factura);
            }

            if ($_FILES["foto2"] != "") {

                //$id = Yii::app()->db->getLastInsertID('notascredito');

                $file3 = $_FILES["foto2"];
                $nombre3 = $file3["name"];
                $tipo3 = $file3["type"];
                $ruta_provisional3 = $file3["tmp_name"];
                $size3 = $file3["size"];
                $dimensiones3 = getimagesize($ruta_provisional3);
                $width = $dimensiones[0];
                $height = $dimensiones[1];
                $carpeta3 = "imagenes/";


                Notascredito::model()->InsertImagenesNotasCredito($id, $nombre3, $codzona, $cuentacliene, $factura);
            }



            $src = $carpeta . $nombre;

            move_uploaded_file($ruta_provisional, $src);
            $src = $carpeta2 . $nombre2;
            move_uploaded_file($ruta_provisional2, $src);

            $src = $carpeta3 . $nombre3;
            move_uploaded_file($ruta_provisional3, $src);
        }
    }

   /* private function NotasCreditoXML($codzona) {

        $InfoXMl = Notascredito::model()->getNotasCreditos($codzona);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXMl as $itemInfo) {

            $xml .= '<Panel>';
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<Date>' . $itemInfo['Fecha'] . '</Date>';
            
                 $xml .= '<Detail>';
            $xml .= '<NoteDate>' . $itemInfo['Fecha'] . '</NoteDate>';
            $xml .= '<ConceptCode>' . $itemInfo['Concepto'] . '</ConceptCode>';
            $xml .= '<CustAccount>' . $itemInfo['CuentaCliente'] . '</CustAccount>';
            $xml .= '<InvoiceId>' . $itemInfo['Factura'] . '</InvoiceId>';
            $xml .= '<Description>Descuentos Condicionados ' . $itemInfo['Factura'] . '</Description>';
            $xml .= '<NoteValue>' . $itemInfo['Valor'] . '</NoteValue>';
                  $xml .= '</Detail>';
            $xml .= '</Header>';
      
            $xml .= '</Panel>';
        }
       
        echo $xml;
        exit();
        
    }*/

    public function actionAjaxValorADigita() {


        if ($_POST) {


            $factura = $_POST['fac'];

            $valorAdigitar = Notascredito::model()->getValorADigita($factura);

            echo number_format($valorAdigitar['valorfactura'],'2',',','.');
        }
    }

    public function actionAjaxValorADigitarProveedor() {


        if ($_POST) {


            $factura = $_POST['fac'];
            $fabricante = $_POST['fabricante'];

            $sumanotascreditosproveedor = Notascredito::model()->getSumaNotasCretidtoProveedor($fabricante, $factura);

            $sumadetalleproveedor = Notascredito::model()->getSumaDetalleProveedor($fabricante, $factura);

            $total2 = $sumadetalleproveedor['detalleproveedro'] - $sumanotascreditosproveedor['ValorNotasProveedor'];

            $valorAdigitar = Notascredito::model()->getValorADigita($factura);

            if ($total2 > $valorAdigitar['valorfactura']) {

                echo ceil($valorAdigitar['valorfactura']);
            } else {

                echo ceil($total2);
            }
        }
    }
    
    
    public function enviarCorreo($email,$body){
        
         Yii::import('application.extensions.phpmailer.JPhpMailer');
           $mail = new JPhpMailer;
           $mail->isSMTP();
             
            
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Host = "m1.redsegura.net";
            $mail->Port = 25;
            $mail->Username = 'soporte@activity.com.co';
            $mail->Password = 'tech0304junio';

            $mail->From = 'soporte@activity.com.co';
            $mail->FromName = 'Activity soporte';
            $mail->addAddress($email, 'ALTIPAL S.A');   
            $mail->WordWrap = 50;           
            $mail->isHTML(true);            
            $mail->Subject = 'Correo Administrativo';
            $mail->Body = utf8_decode($body);
            $mail->AltBody = 'Correo Administrativo';
             
            
            if(!$mail->Send()) {
                echo "Mailer Error: ";
                } else {
                 echo "OK";
                }
        
        
    }

}
