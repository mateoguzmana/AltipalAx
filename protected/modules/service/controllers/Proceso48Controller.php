<?php

class Proceso48Controller extends Controller {

    public function actionProceso48() {


        $AdministradoresCartera = Procesos::model()->AdministradoresCartera();

        foreach ($AdministradoresCartera as $itemAdmin) {


            $notasCredito = Procesos::model()->NotasCreditosSinAprobar48($itemAdmin['Cedula']);
            
            $descuentos = Procesos::model()->DescuentosSinAprobar48($itemAdmin['Cedula']);

            echo '<pre>';
            print_r($notasCredito);
            

            //$dia = date('Y-m-d');
            $dia = '2015-07-09';
            $diaheidy = $this->nameDate($dia);

            if ($diaheidy == 1) {
               
                
            } else {
                
                $fecha_actual = date('Y-m-d H:i:s');
                
                ///notas Credito

                foreach ($notasCredito as $iTemNotas) {

                    $fechaNota = $iTemNotas['Fecha'];
                    $horaNota = $iTemNotas['Hora'];
                    $fecha_com = $fechaNota . " " . $horaNota;
                    
                    

                    if (($diaheidy == 6) || ($diaheidy == 7)) {
                        
                        $nuevafecha = strtotime('+52 hours', strtotime($fecha_com));
                        $nuevafecha = date('Y-m-d H:i:s', $nuevafecha);

                        if ($diaheidy == 7) {
                            $nuevafecha = strtotime('+16 hours', strtotime($nuevafecha));
                            $nuevafecha = date('Y-m-d H:i:s', $nuevafecha);
                        }
                    }else{
                        
                        
                        $nuevafecha = strtotime ('+48 hours' , strtotime ($fecha_com));
		        $nuevafecha = date ( 'Y-m-d H:i:s' , $nuevafecha );
                        
                    }
                    
                    $contador_festivo=0;
                    $FestivosFechas = Procesos::model()->FestivosTimeAaout($fecha_com,$nuevafecha);
                    
                    foreach ($FestivosFechas as $itemFestivos){
                        
                        $itemFestivos['Fechas']=$contador_festivo+1;
                    }
                    
                    $nuevafecha2 = strtotime ('+'.$contador_festivo.' day', strtotime ($nuevafecha));
	            $nuevafecha2 = date ( 'Y-m-d H:i:s' , $nuevafecha2 );
                    
                    
                    if($nuevafecha2<=$fecha_actual){
                        
                        
                     /// se envia correo notificando que la nota credito ya paso a cartera   
                     $UpdateNotaCredito = Procesos::model()->UpdateNotaCredito($iTemNotas['IdNotaCredito'],$iTemNotas['CodAgencia']);
                     
                        
                        
                    if (!empty($itemAdmin['Email'])) {
                    $body = '<div align="center">
                        <div>
                                <div>
                                    <h3 style="alignment-adjust: central"><b> APROBACI&Oacute;N DE DOCUMENTOS NOTAS CREDITO </b></h4>
                                </div>
                        </div>
                        <div>
                            <div>
                                <h3><i>Notas Credito</i></h4>
                            </div>
                            <div>
                                <div >
                                    <div >
                                        <div >  
                                            <h4><i>Sr(a) ' . $itemAdmin['Nombres'] . '   ' . $itemAdmin['Apellidos'] . '  tiene una nota credito de la agencia ' .$iTemNotas['CodAgencia'].  ' la cual se encuentra pendiente para su aprobaci&oacute;n..</i></h4>   
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

                    $this->enviarCorreo($itemAdmin['Email'], $body);
                    
                    echo 'OK';
                }
                        
                    }
                    
                    
                }
                
                
                //Descuentos
                
                 foreach ($descuentos as $iTemDescuento) {

                    $fechaDescuento = $iTemDescuento['FechaPedido'];
                    $horaDescuento = $iTemDescuento['HoraEnviado'];
                    $fecha_Desc = $fechaDescuento . " " . $horaDescuento;
                    
                   // echo $fecha_Desc.'<br>';
                   // echo '<pre>';
                   //print_r($descuentos);
                   

                    if (($diaheidy == 6) || ($diaheidy == 7)) {
                        
                        
                        $nuevafechaDes = strtotime('+52 hours', strtotime($fecha_Desc));
                        $nuevafechaDes = date('Y-m-d H:i:s', $nuevafechaDes);

                        if ($diaheidy == 7) {
                            $nuevafechaDes = strtotime('+16 hours', strtotime($nuevafechaDes));
                            $nuevafechaDes = date('Y-m-d H:i:s', $nuevafechaDes);
                        }
                    }else{
                        
                        $nuevafechaDes = strtotime ('+48 hours' , strtotime ($fecha_Desc));
		        $nuevafechaDes = date ( 'Y-m-d H:i:s' , $nuevafechaDes );
                        
                    }
                    
                    $contador_festivo=0;
                    $FestivosFechasDesc = Procesos::model()->FestivosTimeAaout($fecha_Desc,$nuevafechaDes);
                    
                    foreach ($FestivosFechasDesc as $itemFestivosDesc){
                        
                        $itemFestivosDesc['Fechas']=$contador_festivo+1;
                    }
                    
                    $nuevafechaDesc2 = strtotime ('+'.$contador_festivo.' day', strtotime ($nuevafechaDes));
	            $nuevafechaDesc2 = date ( 'Y-m-d H:i:s' , $nuevafechaDesc2 );
                    
                   // echo $nuevafechaDesc2.'<='.$fecha_actual.'<br><br>';
                    
                    if($nuevafechaDesc2<=$fecha_actual){
                        
                      
                     /// se envia correo notificando que la nota credito ya paso a cartera   
                     $UpdateDescuento = Procesos::model()->UpdatePedidoDescuento($iTemDescuento['IdPedido'],$iTemDescuento['CodAgencia']);
                     
                        
                        
                    if (!empty($itemAdmin['Email'])) {
                    $body = '<div align="center">
                        <div>
                                <div>
                                    <h3 style="alignment-adjust: central"><b> APROBACI&Oacute;N DE DOCUMENTOS DESCUENTOS </b></h4>
                                </div>
                        </div>
                        <div>
                            <div>
                                <h3><i>Descuentos Especiales</i></h4>
                            </div>
                            <div>
                                <div >
                                    <div >
                                        <div >  
                                            <h4><i>Sr(a) ' . $itemAdmin['Nombres'] . '   ' . $itemAdmin['Apellidos'] . '  tiene un descuento de la agencia ' .$iTemDescuento['CodAgencia'].  ' el cual se encuentra pendiente para su aprobaci&oacute;n..</i></h4>   
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

                    $this->enviarCorreo($itemAdmin['Email'], $body);
                    
                    echo 'OK DESCUENTO';
                }
                        
                    }
                    
                    
                }
                
                
            }
        }
        
    }

    function nameDate($fecha) {//formato: 00/00/0000 .... 0000-00-00
        $fecha = empty($fecha) ? date('d/m/Y') : $fecha;
        $dias = array('1', '2', '3', '4', '5', '6', '7');
        $dd = explode('-', $fecha);
        $ts = mktime(0, 0, 0, $dd[1], $dd[2], $dd[0]);
        return $dias[date('w', $ts)];
    }
    
    
    public function enviarCorreo($email, $body) {

        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer;
        $mail->isSMTP();


        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "m1.redsegura.net";
        $mail->Port = 25;
        $mail->Username = 'soporte@activity.com.co';
        $mail->Password = 'tech0102junio';

        $mail->From = 'soporte@activity.com.co';
        $mail->FromName = 'Activity soporte';
        $mail->addAddress($email, 'ALTIPAL S.A');
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = 'Correo Administrativo';
        $mail->Body = utf8_decode($body);
        $mail->AltBody = 'Correo Administrativo';


        if (!$mail->Send()) {
            echo "Mailer Error: ";
        } else {
            echo "OK";
        }
    }

}
