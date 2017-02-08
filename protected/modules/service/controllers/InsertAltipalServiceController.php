<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class InsertAltipalServiceController extends Controller {

    public function actions() {
        return array(
            'Insert' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /**
     * @param string $cadena extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function setSaldoInventarioPreventa($cadena) {
        ServiceAltipal::model()->insertDatos($cadena);
        return "1";
    }

    /**
     * @param string $agencia 
     * @return string
     * @soap
     */
    public function setQueryAgencia001($agencia) {
        $agencia = ServiceAltipal::model()->insertDatos001($agencia);
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencias>';
        foreach ($agencia as $item) {
            $cadena.='<agenciasItem>';
            $cadena.='<codZonaItem>';
            $cadena.=$item["CodZonaVentas"];
            $cadena.='</codZonaItem>';
            $cadena.='<codAgenciasItem>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</codAgenciasItem>';
            $cadena.='</agenciasItem>';
        }
        $cadena.='</agencias>';
        return $cadena;
    }

    /**
     * @param string $agencia
     * @param string $estado	 
     * @return string
     * @soap
     */
    public function setQueryAgencia001EstadosFaltantes($agencia, $estado) {
        if ($estado == '1') {
            $agencia = ServiceAltipal::model()->ZonasFaltantesPaqueteMasivoZonas($agencia);
        }
        if ($estado == '2') {
            $agencia = ServiceAltipal::model()->ZonasFaltantesCupoCredito($agencia);
        }
        if ($estado == '3') {
            $agencia = ServiceAltipal::model()->ZonasFaltantesFacturasSaldo($agencia);
        }
        if ($estado == '4') {
            $agencia = ServiceAltipal::model()->ZonasFaltantesFacturasTransacciones($agencia);
        }
        if ($estado == '5') {
            $agencia = ServiceAltipal::model()->ZonasFaltantesPendientesFacturar($agencia);
        }
        if ($estado == '6') {
            $agencia = ServiceAltipal::model()->ZonasFaltantesPresupuestoVentas($agencia);
        }
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencias>';
        foreach ($agencia as $item) {
            $cadena.='<agenciasItem>';
            $cadena.='<codZonaItem>';
            $cadena.=$item["CodZonaVentas"];
            $cadena.='</codZonaItem>';
            $cadena.='<codAgenciasItem>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</codAgenciasItem>';
            $cadena.='</agenciasItem>';
        }
        $cadena.='</agencias>';
        return $cadena;
    }

    /**
     * @return string
     * @soap
     */
    public function setQueryZonasFaltantesCupos() {
        $agencia = ServiceAltipal::model()->insertDatosZonasFaltantesCupos();
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencias>';
        foreach ($agencia as $item) {
            $cadena.='<agenciasItem>';
            $cadena.='<codZonaItem>';
            $cadena.=$item["CodZonaVentas"];
            $cadena.='</codZonaItem>';
            $cadena.='<codAgenciasItem>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</codAgenciasItem>';
            $cadena.='</agenciasItem>';
        }
        $cadena.='</agencias>';
        return $cadena;
    }

    /**
     * @return string
     * @soap
     */
    public function setQueryZonasFaltantesFacturas() {
        $agencia = ServiceAltipal::model()->insertDatosZonasFaltantesFacturas();
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencias>';
        foreach ($agencia as $item) {
            $cadena.='<agenciasItem>';
            $cadena.='<codZonaItem>';
            $cadena.=$item["CodZonaVentas"];
            $cadena.='</codZonaItem>';
            $cadena.='<codAgenciasItem>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</codAgenciasItem>';
            $cadena.='</agenciasItem>';
        }
        $cadena.='</agencias>';
        return $cadena;
    }

    /**
     * @return string
     * @soap
     */
    public function setQueryZonasFaltantesPresupuesto() {
        $agencia = ServiceAltipal::model()->insertDatosZonasFaltantesPresupuesto();
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencias>';
        foreach ($agencia as $item) {
            $cadena.='<agenciasItem>';
            $cadena.='<codZonaItem>';
            $cadena.=$item["CodZonaVentas"];
            $cadena.='</codZonaItem>';
            $cadena.='<codAgenciasItem>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</codAgenciasItem>';
            $cadena.='</agenciasItem>';
        }
        $cadena.='</agencias>';
        return $cadena;
    }

    /**
     * @return string
     * @soap
     */
    public function setQueryZonasFaltantesPendientesFacturar() {
        $agencia = ServiceAltipal::model()->insertDatosZonasFaltantesPendientesFacturar();
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencias>';
        foreach ($agencia as $item) {
            $cadena.='<agenciasItem>';
            $cadena.='<codZonaItem>';
            $cadena.=$item["CodZonaVentas"];
            $cadena.='</codZonaItem>';
            $cadena.='<codAgenciasItem>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</codAgenciasItem>';
            $cadena.='</agenciasItem>';
        }
        $cadena.='</agencias>';
        return $cadena;
    }

    /**
     * @return string
     * @soap
     */
    public function setQueryZonasFaltantesFacturasTransacciones() {
        $agencia = ServiceAltipal::model()->insertDatosZonasFaltantesFacturasTransacciones();
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencias>';
        foreach ($agencia as $item) {
            $cadena.='<agenciasItem>';
            $cadena.='<codZonaItem>';
            $cadena.=$item["CodZonaVentas"];
            $cadena.='</codZonaItem>';
            $cadena.='<codAgenciasItem>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</codAgenciasItem>';
            $cadena.='</agenciasItem>';
        }
        $cadena.='</agencias>';
        return $cadena;
    }

    /**
     * @return string
     * @soap
     */
    public function setQueryZonasFaltantes() {
        $agencia = ServiceAltipal::model()->insertDatosZonasFaltantes();
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencias>';
        foreach ($agencia as $item) {
            $cadena.='<agenciasItem>';
            $cadena.='<codZonaItem>';
            $cadena.=$item["CodZonaVentas"];
            $cadena.='</codZonaItem>';
            $cadena.='<codAgenciasItem>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</codAgenciasItem>';
            $cadena.='</agenciasItem>';
        }
        $cadena.='</agencias>';
        return $cadena;
    }

    /**
     * @return string El mensaje del servicio
     * @soap
     */
    public function getGruposAgencia() {
        $consulta = ServiceAltipal::model()->consultaGruposAgencia();
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<grupoAgencia>';
        foreach ($consulta as $item) {
            $cadena.='<grupoAgenciaItem>';
            $cadena.='<grupo>';
            $cadena.=$item['CodigoGrupoVentas'];
            $cadena.='</grupo>';
            $cadena.='<agencia>';
            $cadena.=$item['CodAgencia'];
            $cadena.='</agencia>';
            $cadena.='</grupoAgenciaItem>';
        }
        $cadena.='</grupoAgencia>';
        return $cadena;
    }

    /**
     * @param string $cadena extructura
     * @param string $agencia extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function setQueryAgenciaUnique($cadena, $agencia) {
        ServiceAltipal::model()->insertDatosAgencia($cadena, $agencia);
        return "1";
    }

    /**
     * @param string $cadena extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function setQueryAgenciaGlobal($cadena) {
        ServiceAltipal::model()->insertDatosGlobal($cadena);
        return "1";
    }

    /**
     * @param string $fechaInicial extructura
     * @param string $fechaFinal extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function getEnviarCorreos($fechaInicial, $fechaFinal) {
        $cont = 0;
        $txt1 = "";
        $txt2 = "";
        $consultaEstado = $fechaInicial == $fechaFinal ? "Igual" : "Mayor";
        $MensajeCorreo = ServiceAltipal::model()->getMensajeCorreo($consultaEstado);
        foreach ($MensajeCorreo as $row) {
            $cont++;
            $txt1 = $txt1 . $cont . "-)" . $row['ServicioSRF'] . " Mensaje Servicio: " . $row['MensajeServicio'] . " Fecha: " . $row['Fecha'] . " Hora: " . $row['Hora'] . " Agencia: " . $row['Agencia'] . " Parametro: " . $row['Parametros'] . ".<br><br>";
        }
        $MensajeCorreoZonas = ServiceAltipal::model()->getMensajeCorreoZonas();
        foreach ($MensajeCorreoZonas as $row1) {
            $cont++;
            if ($row1['ServicioSRF'] == "Facturas Transacciones") {
                $columna = "EstadoActualizacionFacturasTransacciones";
                $zona = $row1['Parametros'];
                $VerificacionProceso = ServiceAltipal::model()->getMensajeCorreoVerificacionProcesoIndividual($columna, $zona);
                foreach ($VerificacionProceso as $row5) {
                    $EstadoActualizacion = $row5['EstadoActualizacionFacturasTransacciones'];
                }
                if ($EstadoActualizacion == '0') {
                    $txt2 = $txt2 . $cont . "-)" . $row1['ServicioSRF'] . " Mensaje Servicio: " . $row1['MensajeServicio'] . " Fecha: " . $row1['Fecha'] . " Hora: " . $row1['Hora'] . " Agencia: " . $row1['Agencia'] . " Parametro: " . $row1['Parametros'] . ".<br><br>";
                }
            } elseif ($row1['ServicioSRF'] == "Pendientes por Facturar") {
                $columna = "EstadoActualizacionPendientesFacturar";
                $zona = $row1['Parametros'];
                $VerificacionProceso = ServiceAltipal::model()->getMensajeCorreoVerificacionProcesoIndividual($columna, $zona);
                foreach ($VerificacionProceso as $row5) {
                    $EstadoActualizacion = $row5['EstadoActualizacionPendientesFacturar'];
                }
                if ($EstadoActualizacion == '0') {
                    $txt2 = $txt2 . $cont . "-)" . $row1['ServicioSRF'] . " Mensaje Servicio: " . $row1['MensajeServicio'] . " Fecha: " . $row1['Fecha'] . " Hora: " . $row1['Hora'] . " Agencia: " . $row1['Agencia'] . " Parametro: " . $row1['Parametros'] . ".<br><br>";
                }
            } elseif ($row1['ServicioSRF'] == "Presupuesto de Ventas") {
                $columna = "EstadoActualizacionPresupuesto";
                $zona = $row1['Parametros'];
                $VerificacionProceso = ServiceAltipal::model()->getMensajeCorreoVerificacionProcesoIndividual($columna, $zona);
                foreach ($VerificacionProceso as $row5) {
                    $EstadoActualizacion = $row5['EstadoActualizacionPresupuesto'];
                }
                if ($EstadoActualizacion == '0') {
                    $txt2 = $txt2 . $cont . "-)" . $row1['ServicioSRF'] . " Mensaje Servicio: " . $row1['MensajeServicio'] . " Fecha: " . $row1['Fecha'] . " Hora: " . $row1['Hora'] . " Agencia: " . $row1['Agencia'] . " Parametro: " . $row1['Parametros'] . ".<br><br>";
                }
            }
        }
        if (count($MensajeCorreo) > 0) {
            $Correos = ServiceAltipal::model()->getCorreosProceso();
            foreach ($Correos as $datos) {
                $to = $datos['Correo'];
                $subject = "Status Procesos Altipal";
                $txt = "Buenas Tardes Sr(a) " . $datos['Usuario'] . " el dia de hoy se genero problemas en los siguientes servicios: <br><br>";
                $txt = $txt . $txt1 . $txt2;
                $txt = utf8_decode($txt);
                Yii::import('application.extensions.phpmailer.JPhpMailer');
                $mail = new JPhpMailer;
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Host = "m1.redsegura.net";
                $mail->Port = 25;
                $mail->Username = 'soporte@activity.com.co';
                $mail->Password = 'tech0304junio';
                $mail->From = 'soporte@activity.com.co';
                $mail->FromName = 'Activity soporte';
                $mail->addAddress($to, $datos['Usuario']);
                $mail->WordWrap = 50;
                $mail->isHTML(true);
                $mail->Subject = 'Errores Procesos Altipal';
                $mail->Body = utf8_decode($txt);
                $mail->AltBody = 'Errores Procesos Altipal';
                $mail->Send();
                /*$headers = "From: activity@activity.com.co";
                  if (mail($to, $subject, $txt, $headers)) {
                  } else {
                  return "Error al enviar el correo";
                  } */
            }
        }
        return "OK";
    }

    /*
     * @param string $fechaInicial extructura
     * @param string $fechaFinal extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function getEnviarCorreosActivity($fechaInicial, $fechaFinal) {
        $cont = 0;
        $txt1 = "";
        $consultaEstado = $fechaInicial == $fechaFinal ? "Igual" : "Mayor";
        $MensajeCorreo = ServiceAltipal::model()->getMensajeCorreoActivity($consultaEstado);
        foreach ($MensajeCorreo as $row) {
            $cont++;
            $txt1 = $txt1 . $cont . "-)" . $row['ServicioSRF'] . " Mensaje Activity: " . $row['MensajeActivity'] . " Mensaje Servicio: " . $row['MensajeServicio'] . " Fecha: " . $row['Fecha'] . " Hora: " . $row['Hora'] . " Agencia: " . $row['Agencia'] . " Parametro: " . $row['Parametros'] . ".<br><br>";
        }
        if (count($MensajeCorreo) > 0) {
            $Correos = ServiceAltipal::model()->getCorreosProcesoActivity();
            foreach ($Correos as $datos) {
                $to = $datos['Correo'];
                $subject = "Errores Procesos Activity";
                $txt = "Buenas Tardes Sr(a) " . $datos['Usuario'] . " el dia de hoy se genero problemas en los siguientes servicios: <br><br>";
                $txt = $txt . $txt1;
                $txt = utf8_decode($txt);
                Yii::import('application.extensions.phpmailer.JPhpMailer');
                $mail = new JPhpMailer;
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Host = "m1.redsegura.net";
                $mail->Port = 25;
                $mail->Username = 'soporte@activity.com.co';
                $mail->Password = 'tech0304junio';
                $mail->From = 'soporte@activity.com.co';
                $mail->FromName = 'Activity soporte';
                $mail->addAddress($to, $datos['Usuario']);
                $mail->WordWrap = 50;
                $mail->isHTML(true);
                $mail->Subject = 'Errores Procesos Activity (Altipal)';
                $mail->Body = utf8_decode($txt);
                $mail->AltBody = 'Errores Procesos Activity (Altipal)';
                $mail->Send();
                /*$headers = "From: activity@activity.com.co";
                  if (mail($to, $subject, $txt, $headers)) {
                  } else {
                  return "Error al enviar el correo";
                  } */
            }
        }
        return "OK";
    }

    /**
     * @param string $fechaInicial extructura
     * @param string $fechaFinal extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function getEnviarCorreosResumenProceso($fechaInicial, $fechaFinal) {
        try {
            $MensajeCorreo = ServiceAltipal::model()->getMensajeCorreoResumenProceso();
            if (count($MensajeCorreo) > 0) {
                $Correos = ServiceAltipal::model()->getCorreosProcesoResumenProceso();
                foreach ($Correos as $datos) {
                    $to = $datos['Correo'];
                    $subject = "Resumen Proceso Altipal";
                    $txt = "Buenas tardes Sr(a) " . $datos['Usuario'] . " a continuacion se envia resumen con la duracion de cada uno de los procesos ejecutados durante el proceso nocturno: <br>" . "<br>";
                    $cont = 0;
                    $identificadorproceso = 0;
                    while ($identificadorproceso <= 20) {
                        switch ($identificadorproceso) {
                            case 0:
                                $nombreproceso = "DURACION PROCESO";
                                break;
                            case 1:
                                $nombreproceso = "ZONA VENTAS ACTIVAS";
                                break;
                            case 2:
                                $nombreproceso = "PAQUETE MASIVO ZONAS";
                                break;
                            case 3:
                                $nombreproceso = "ZONAS INACTIVAS";
                                break;
                            case 4:
                                $nombreproceso = "PAQUETE MASIVO ARTICULOS";
                                break;
                            case 5:
                                $nombreproceso = "PAQUETE MASIVO FINANCIERO";
                                break;
                            case 6:
                                $nombreproceso = "PAQUETE LOCALIZACION";
                                break;
                            case 7:
                                $nombreproceso = "PAQUETE MASIVO MOTIVOS";
                                break;
                            case 8:
                                $nombreproceso = "ACUERDOS PRECIO VENTA";
                                break;
                            case 9:
                                $nombreproceso = "ACUERDOS COMERCIALES DESCUENTO LINEA";
                                break;
                            case 10:
                                $nombreproceso = "ACUERDOS COMERCIALES DESCUENTO MULTILINEA";
                                break;
                            case 11:
                                $nombreproceso = "PORTAFOLIO";
                                break;
                            case 12:
                                $nombreproceso = "SALDO INVENTARIO PREVENTA";
                                break;
                            case 13:
                                $nombreproceso = "SALDO INVENTARIO AUTOVENTA";
                                break;
                            case 14:
                                $nombreproceso = "VARIANTES INACTIVAS";
                                break;
                            case 15:
                                $nombreproceso = "CUPO CREDITO";
                                break;
                            case 16:
                                $nombreproceso = "FACTURAS SALDO";
                                break;
                            case 17:
                                $nombreproceso = "FACTURAS TRANSACCIONES";
                                break;
                            case 18:
                                $nombreproceso = "PENDIENTES POR FACTURAR";
                                break;
                            case 19:
                                $nombreproceso = "PRESUPUESTO DE VENTAS";
                                break;
                            case 20:
                                $nombreproceso = "MERCADERISTAS";
                                break;
                        }
                        $contadorduracion = 0;
                        $consultaEstado = "";
                        $contarPociciones;
                        $consultaEstado = $fechaInicial == $fechaFinal ? "Igual" : "Mayor";
                        if ($consultaEstado == "Mayor") {
                            $DuracionProceso = ServiceAltipal::model()->getMensajeCorreoResumenProcesoIndividual($identificadorproceso);
                        } else {
                            $DuracionProceso = ServiceAltipal::model()->getMensajeCorreoResumenProcesoIndividualError($identificadorproceso);
                        }
                        foreach ($DuracionProceso as $row) {
                            if ($contadorduracion == 0) {
                                $fechacomienzaproceso = $row['Fecha'];
                                $horacomienzaproceso = $row['Hora'];
                                $contadorduracion++;
                            } else {
                                $fechaterminaproceso = $row['Fecha'];
                                $horaterminaproceso = $row['Hora'];
                                $status = $row['Status'];
                                $nombreServer = $row['NombreServidor'];
                                $duracion = (date("H:i:s", strtotime("00:00:00") + strtotime($horaterminaproceso) - strtotime($horacomienzaproceso)));
                                //$txt = $txt.$nombreproceso." ".$horacomienzaproceso." - ".$horaterminaproceso." : ".$duracion.".<br><br>"; 
                                if ($status == "Termina Incompleto") {
                                    $txt = $txt . "<b>" . $nombreproceso . "</b> " . $duracion . " " . "<br>" . "Hora Inicio: " . $horacomienzaproceso . " Hora Fin: " . $horaterminaproceso . "<br>" . "Fecha Actualizacion: " . $fechacomienzaproceso . " " . $horacomienzaproceso . "<br>" . "Nombre del Servidor: " . $nombreServer . "<br> <font color='red'>" . $status . "</font>" . "<br>" . "----------------------------------------------------<br><br>";
                                } else {
                                    $txt = $txt . "<b>" . $nombreproceso . "</b>" . " " . $duracion . " " . "<br>" . "Hora Inicio: " . $horacomienzaproceso . " Hora Fin: " . $horaterminaproceso . "<br>" . "Fecha Actualizacion: " . $fechacomienzaproceso . " " . $horacomienzaproceso . "<br>" . "Nombre del Servidor: " . $nombreServer . "<br>" . "----------------------------------------------------<br><br>";
                                }
                                $contadorduracion = 0;
                            }
                            $contarPociciones++;
                        }
                        $identificadorproceso++;
                    }
                    if ($contarPociciones > 0) {
                        $txt = utf8_decode($txt);
                        Yii::import('application.extensions.phpmailer.JPhpMailer');
                        $mail = new JPhpMailer;
                        $mail->IsSMTP();
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = "tls";
                        $mail->Host = "m1.redsegura.net";
                        $mail->Port = 25;
                        $mail->Username = 'soporte@activity.com.co';
                        $mail->Password = 'tech0304junio';
                        $mail->From = 'soporte@activity.com.co';
                        $mail->FromName = 'Activity soporte';
                        $mail->addAddress($to, $datos['Usuario']);
                        $mail->WordWrap = 50;
                        $mail->isHTML(true);
                        $mail->Subject = 'Resumen Procesos Altipal';
                        $mail->Body = utf8_decode($txt);
                        $mail->AltBody = 'Resumen Procesos Altipal';
                        $mail->Send();
                        $manejador = fopen("LogCorreos/" . $to . 'CorreoErrores.txt', 'a+');
                        fputs($manejador, utf8_decode($txt) . "\n");
                        fclose($manejador);
                    }
                    /* $headers = "From: activity@activity.com.co";
                      if (mail($to, $subject, $txt, $headers)) {
                      } else {
                      return "Error al enviar el correo";
                      } */
                }
            }
            return "OK";
        } catch (Exeption $e) {
            return $e;
        }
    }

    /**
     * @param string $cadena extructura
     * @param string $status extructura
     * @param string $identificadorproceso extructura
     * @param string $identificadorestado extructura 
     * @return string El mensaje del servicio
     * @soap
     */
    public function getEnviarCorreosPorProceso($cadena, $status, $identificadorproceso, $identificadorestado) {
        ServiceAltipal::model()->insertProcesosIndividuales($cadena, $status, $identificadorproceso, $identificadorestado);
        return "OK";
    }

    /**
     * @param string $cadena extructura
     * @param string $status extructura
     * @param string $identificadorproceso extructura
     * @param string $identificadorestado extructura
     * @param string $nameServe extructura 
     * @return string El mensaje del servicio
     * @soap
     */
    public function getEnviarCorreosPorProcesoServer($cadena, $status, $identificadorproceso, $identificadorestado, $nameServe) {
        ServiceAltipal::model()->insertProcesosIndividuales2($cadena, $status, $identificadorproceso, $identificadorestado, $nameServe);
        return "OK";
    }

    /**
     * @param string $cadena extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function getAgenciasSitiosGlobales() {
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencias>';
        $agencia = ServiceAltipal::model()->getAgenciasSitiosGlobales();
        foreach ($agencia as $item) {
            $cadena.='<agenciasItem>';
            $cadena.='<codZonaItem>';
            $cadena.=$item["CodZonaVentas"];
            $cadena.='</codZonaItem>';
            $cadena.='<codAgenciasItem>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</codAgenciasItem>';
            $cadena.='</agenciasItem>';
        }
        $cadena.='</agencias>';
        return $cadena;
    }

    /**
     * @return string El mensaje del servicio
     * @soap
     */
    public function setQueryAgenciaTotal() {
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencias>';
        $agencia = ServiceAltipal::model()->AgenciaGlobal();
        foreach ($agencia as $item) {
            $cadena.='<agenciasItem>';
            $cadena.='<codAgenciasItem>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</codAgenciasItem>';
            $cadena.='</agenciasItem>';
        }
        $cadena.='</agencias>';
        return $cadena;
    }

    /**
     * @param string $cadena extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function setQuerySitio($agencia) {
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<sitios>';
        $agencia = ServiceAltipal::model()->GetSitios($agencia);
        foreach ($agencia as $item) {
            $cadena.='<sitiosItem>';
            $cadena.='<codSitiosItem>';
            $cadena.=$item["CodSitio"];
            $cadena.='</codSitiosItem>';
            $cadena.='</sitiosItem>';
        }
        $cadena.='</sitios>';
        return $cadena;
    }

    /**
     * @param string $cadena extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function setQueryAgenciaAll($cadena) {
        set_time_limit(-1);
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        ServiceAltipal::model()->insertDatosAll($cadena);
        return "1";
    }

    /**
     * @param string $cadena extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function setQueryAgenciaAllGlobal($cadena) {
        set_time_limit(-1);
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        ServiceAltipal::model()->insertDatosAllGlobal($cadena);
        return "1";
    }

    /**
     * @param string $cadena extructura 
     * @param string $agencia extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function setQueryAgencia($cadena, $agencia) {
        $manejador = fopen($agencia . 'zonasFinanciaras.txt', 'a+');
        fputs($manejador, $cadena . "\n" . $agencia . "\n");
        fclose($manejador);
        ServiceAltipal::model()->insertDatosAgencia($cadena, $agencia);
        return "1";
    }

    /**
     * @param string $cadena extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function setAcuerdosComerciales($cadena) {
        ServiceAltipal::model()->insertDatos($cadena);
        return "1";
    }

    /**
     * @param string $zonaVenta extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function getAgenciaZona($zonaVenta) {
        return ServiceAltipal::model()->getAgenciaZona($zonaVenta);
        //return $respuesta;
    }

    /**
     * @param string $zonaVenta extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function getCodigoAsesorZona($zonaVenta) {
        return ServiceAltipal::model()->getCodigoAsesorZona($zonaVenta);
        //return $respuesta;
    }

    /**
     * @return string El mensaje del servicio
     * @soap
     */
    public function getUltimaVersion() {
        return ServiceAltipal::model()->getUltimaVersion();
        //return $respuesta;
    }

    /**
     * @param string $codigoasesor extructura 
     * @param string $agencia extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function getVersionActualZona($codigoasesor, $agencia) {
        return ServiceAltipal::model()->getVersionActualZona($codigoasesor, $agencia);
        //return $respuesta;
    }

    /**
     * @param string $cadena extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function setInsertGlobal($cadena) {
        ServiceAltipal::model()->setAgenciaInsert($cadena);
        return "1";
    }

    /**
     * @param string $cadena extructura
     * @return string El mensaje del servicio
     * @soap
     */
    public function getAgenciasGlobales() {
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<agencia>';
        $agencia = ServiceAltipal::model()->getAgenciasGlobales();
        foreach ($agencia as $item) {
            $cadena.='<agenciaItem>';
            $cadena.='<agenciaDato>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</agenciaDato>';
            $cadena.='</agenciaItem>';
        }
        $cadena.='</agencia>';
        return $cadena;
    }

    /**
     * @return string El mensaje del servicio
     * @soap
     */
    public function getSitios() {
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<sitios>';
        $agencia = ServiceAltipal::model()->getSitiosGlobales();
        foreach ($agencia as $item) {
            $cadena.='<sitiosItem>';
            $cadena.='<sitio>';
            $cadena.=$item["CodZonaVentas"];
            $cadena.='</sitio>';
            $cadena.='<agencia>';
            $cadena.=$item["CodAgencia"];
            $cadena.='</agencia>';
            $cadena.='<nombreAgencia>';
            $cadena.=$item["NombreAgencia"];
            $cadena.='</nombreAgencia>';
            $cadena.='</sitiosItem>';
        }
        $cadena.='</sitios>';
        return $cadena;
    }

    /**
     * @param string $agencia 
     * @return string El mensaje del servicio
     * @soap
     */
    public function getGruposAgenciaSitios($agencia) {
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<grupoAgencia>';
        $consulta = ServiceAltipal::model()->getGruposVentas2($agencia);
        foreach ($consulta as $item) {
            $cadena.='<grupoAgenciaItem>';
            $cadena.='<grupo>';
            $cadena.=$item['CodigoGrupoVentas'];
            $cadena.='</grupo>';
            $cadena.='<agencia>';
            $cadena.=$item['CodAgencia'];
            $cadena.='</agencia>';
            $cadena.='</grupoAgenciaItem>';
        }
        $cadena.='</grupoAgencia>';
        return $cadena;
    }

    /**
     * @return string El mensaje del servicio
     * @soap
     */
    public function getGruposGlobal() {
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<grupoAgencia>';
        $consulta = ServiceAltipal::model()->getGruposGlobales();
        foreach ($consulta as $item) {
            $cadena.='<grupoAgenciaItem>';
            $cadena.='<grupo>';
            $cadena.=$item['CodigoGrupoVentas'];
            $cadena.='</grupo>';
            $cadena.='</grupoAgenciaItem>';
        }
        $cadena.='</grupoAgencia>';
        return $cadena;
    }

    /**
     * @return string El mensaje del servicio
     * @soap
     */
    public function getGruposGlobalFaltante() {
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<grupoAgencia>';
        $consulta = ServiceAltipal::model()->getGruposGlobalesFaltantes();
        foreach ($consulta as $item) {
            $cadena.='<grupoAgenciaItem>';
            $cadena.='<grupo>';
            $cadena.=$item['CodigoGrupoVentas'];
            $cadena.='</grupo>';
            $cadena.='</grupoAgenciaItem>';
        }
        $cadena.='</grupoAgencia>';
        return $cadena;
    }

    /**
     * @param string $cadena 
     * @return string El mensaje del servicio
     * @soap
     */
    public function getZonaVentasGlobales() {
        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<Zona>';
        $zonaVentasGloables = ServiceAltipal::model()->getZonaVentasGlo();
        foreach ($zonaVentasGloables as $item) {
            $cadena.='<ZonaVentasItem>';
            $cadena.='<zonaventas>';
            $cadena.=$item['CodZonaVentas'];
            $cadena.='</zonaventas>';
            $cadena.='</ZonaVentasItem>';
        }
        $cadena.='</Zona>';
        return $cadena;
    }

    /**
     * @param string $cadena extructura 
     * @return string El mensaje del servicio
     * @soap
     */
    public function InsertPresupuestos($cadena) {
        $objPresu = json_decode($cadena, true);
        if ($objPresu['SaleZone']['Code'] != "" && $objPresu['SaleZone']['Code'] != null) {
            $CodZonaVentas1 = $objPresu['SaleZone']['Code'];
            $Agencia1 = $objPresu['SaleZone']['AgencyId'];
            $NombreAgencia1 = $objPresu['SaleZone']['AgencyName'];
            $ano1 = $objPresu['SaleZone']['Year'];
            $Mes1 = $objPresu['SaleZone']['Month'];
            $DiasHabiles1 = $objPresu['SaleZone']['BusinessDays'];
            $DiasTranscurridos1 = $objPresu['SaleZone']['ElapsedDays'];
            $sql = "INSERT INTO `presupuestos`(`CodZonaVentas`, `Agencia`, `NombreAgencia`, `Año`, `Mes`, `DiasHabiles`, `DiasTranscurridos`) VALUES ('$CodZonaVentas1','$Agencia1','$NombreAgencia1','$ano1','$Mes1','$DiasHabiles1','$DiasTranscurridos1')";
            ServiceAltipal::model()->insertDatosAll($sql);
            $cadenaid = "SELECT MAX(Id) as IdPresupuesto FROM `presupuestos`";
            $IdPre = ServiceAltipal::model()->SelectQueryRow($cadenaid);
            $idPresupuesto = $IdPre['IdPresupuesto'];
            $contarInsertarProfundidad = 0;
            $contarInsertarDimenciones = 0;
            $contarInsertarFabricante = 0;
            $sqlInsertProfundidad = "INSERT INTO `presupuestoprofundidad`(`IdPresupuesto`, `Presupuestado`, `Tipo`, `CodDimension`, `NombreDimension`, `Ejecutado`, `PorcentajeCumplimiento`, `Indicador`) VALUES";
            $sqlInsertDimenciones = "INSERT INTO `presupuestodimensiones`(`IdPresupuesto`, `NombreDimension`, `Presupuestado`, `Ejecutado`, `PorcentajeCumplimiento`) VALUES";
            $sqlInsertFabricante = "INSERT INTO `presupuestofabricante`(`IdPresupuesto`, `CodigoFabricante`, `NombreFabricante`, `Pesos`, `Devoluciones`, `CuotaPesos`, `Cumplimiento`) VALUES";
            foreach ($objPresu as $key => $valor) {
                if (is_array($valor)) {
                    foreach ($valor as $keyProfundida => $keyProfundidaValor) {
                        if ($keyProfundida == 'Depth' && is_array($keyProfundidaValor)) {
                            foreach ($keyProfundidaValor as $keyProf => $keyProfValor) {
                                $Presupuestado = $keyProfValor['Budgeted'];
                                $Tipo = $keyProfValor['BudgetedType'];
                                $CodDimension = $keyProfValor['DimensionId'];
                                $NombreDimension = $keyProfValor['DimensionName'];
                                $NombreDimension = str_replace("'", "", $NombreDimension);
                                $NombreDimension = str_replace("&", "", $NombreDimension);
                                $Ejecutado = $keyProfValor['Executed'];
                                $PorcentajeCumplimiento = $keyProfValor['Fulfillment'];
                                $Indicador = $keyProfValor['Indicator'];
                                $Indicador = str_replace("'", "", $Indicador);
                                $Indicador = str_replace("&", "", $Indicador);
                                $sqlInsertProfundidad = $sqlInsertProfundidad . "('$idPresupuesto','$Presupuestado','$Tipo','$CodDimension','$NombreDimension','$Ejecutado','$PorcentajeCumplimiento','$Indicador'),";
                                $contarInsertarProfundidad++;
                            }
                        } else if ($keyProfundida == 'Dimensions' && is_array($keyProfundidaValor)) {
                            foreach ($keyProfundidaValor as $keyDimensiones => $keyDimensionesValor) {
                                $PresupuestadoDimensiones = $keyDimensionesValor['Budgeted'];
                                $NombreDimensiones = $keyDimensionesValor['DimensionName'];
                                $NombreDimensiones = str_replace("'", " ", $NombreDimensiones);
                                $NombreDimensiones = str_replace("&", "y", $NombreDimensiones);
                                $EjecutadoDimensiones = $keyDimensionesValor['Executed'];
                                $PorcentajeCumplimientoDimensiones = $keyDimensionesValor['Fulfillment'];
                                $sqlInsertDimenciones = $sqlInsertDimenciones . "('$idPresupuesto','$NombreDimensiones','$PresupuestadoDimensiones','$EjecutadoDimensiones','$PorcentajeCumplimientoDimensiones'),";
                                $contarInsertarDimenciones++;
                            }
                        } else if ($keyProfundida == 'Manufacturers' && is_array($keyProfundidaValor)) {
                            foreach ($keyProfundidaValor as $keyManofactura => $keyManofacturaValor) {
                                $CodigoFabricante = $keyManofacturaValor['ManufacturerId'];
                                $NombreFabricante = $keyManofacturaValor['ManufacturerName'];
                                $NombreFabricante = str_replace("'", " ", $NombreFabricante);
                                $NombreFabricante = str_replace("&", "y", $NombreFabricante);
                                $Devoluciones = $keyManofacturaValor['ReturnsSales'];
                                $CuotaPesos = $keyManofacturaValor['Cuote'];
                                $Cumplimiento = $keyManofacturaValor['Fulfillment'];
                                $Pesos = $keyManofacturaValor['Amount'];
                                $sqlInsertFabricante = $sqlInsertFabricante . "('$idPresupuesto','$CodigoFabricante','$NombreFabricante','$Pesos','$Devoluciones','$CuotaPesos','$Cumplimiento'),";
                                $contarInsertarFabricante++;
                            }
                        }
                    }
                }
            }
            if ($contarInsertarProfundidad > 0) {
                $sqlInsertProfundidad = substr($sqlInsertProfundidad, 0, -1);
                $sqlInsertProfundidad .= ";";
                ServiceAltipal::model()->insertDatosAll($sqlInsertProfundidad);
            }
            if ($contarInsertarDimenciones > 0) {
                $sqlInsertDimenciones = substr($sqlInsertDimenciones, 0, -1);
                $sqlInsertDimenciones .= ";";
                ServiceAltipal::model()->insertDatosAll($sqlInsertDimenciones);
            }
            if ($contarInsertarProfundidad > 0) {
                $sqlInsertFabricante = substr($sqlInsertFabricante, 0, -1);
                $sqlInsertFabricante .= ";";
                ServiceAltipal::model()->insertDatosAll($sqlInsertFabricante);
            }
            return 'OK';
        } else {
            return "la zona de ventas no posee informacion";
        }
    }

    /**
     * @param string $cadena extructura 
     * @return string El mensaje del servicio
     * @soap
     */
    public function InsertMallaActivacion($cadena) {
        $objMallaActivacion = json_decode($cadena, true);
        foreach ($objMallaActivacion as $itemObjetoMallaActivacion) {
            foreach ($itemObjetoMallaActivacion as $SaleZone => $datos) {
                if ($SaleZone == 'BusinessDays') {
                    $DiasHabilesMallaActivacion = $datos;
                }
                if ($SaleZone == 'ElapsedDays') {
                    $DiasTranscurridosMallaActivacion = $datos;
                }
                if ($SaleZone == 'Month') {
                    $MesMallaActivacion = $datos;
                }
                if ($SaleZone == 'Year') {
                    $AnoMallaActivacion = $datos;
                }
                if ($SaleZone == 'AgencyId') {
                    $CodAgenciaMallaActivacion = $datos;
                }
                if ($SaleZone == 'AgencyName') {
                    $NomAgenciaMallaActivacion = $datos;
                }
                if ($SaleZone == 'Code') {
                    $zonaVenntasMallaActivacion = $datos;
                }
                /* if ($SaleZone == 'ActivationMeshDetails') {
                  for ($i = 0; $i < count($datos); $i++) {

                  $TipoMallaAct = $datos[$i]['Attribute'];
                  $PresupuestadoMallaAct = $datos[$i]['Budgeted'];
                  $CuentaCliente = $datos[$i]['ClientId'];
                  $NombreCliente = $datos[$i]['ClientName'];
                  $EjecutadoMallaAct = $datos[$i]['Executed'];
                  $CumplimientMallaAct = $datos[$i]['Fulfillment'];
                  }
                  } */
            }
        }
        if ($MesMallaActivacion != "" && $AnoMallaActivacion != "") {
            $sqlInsertMallaAct = "INSERT INTO `mallaactivacion`(`DiasHabiles`, `DiasTranscurridos`, `Mes`, `Año`, `CodAgencia`, `NombreAgencia`, `CodZonaVentas`) VALUES ('$DiasHabilesMallaActivacion','$DiasTranscurridosMallaActivacion','$MesMallaActivacion','$AnoMallaActivacion','$CodAgenciaMallaActivacion','$NomAgenciaMallaActivacion','$zonaVenntasMallaActivacion')";
            ServiceAltipal::model()->insertDatosAll($sqlInsertMallaAct);
            $Mallaid = "SELECT MAX(Id) as IdMallaActivacion FROM `mallaactivacion`";
            $IdMallaAct = ServiceAltipal::model()->SelectQueryRow($Mallaid);
            $idMallaActivacion = $IdMallaAct['IdMallaActivacion'];
            $contarMallaDetalles = 0;
            $sqlInsertMallaActDetalle = "INSERT INTO `mallaactivaciondetalle`(`IdMallaActivacion`, `Tipo`, `Presupuestado`, `CuentaCliente`, `NombreCliente`, `Ejecutado`, `Cumplimiento`) VALUES";
            foreach ($objMallaActivacion as $itemObjetoMallaActivacion) {
                foreach ($itemObjetoMallaActivacion as $SaleZone => $datos) {
                    if ($SaleZone == 'ActivationMeshDetails') {
                        for ($i = 0; $i < count($datos); $i++) {
                            $TipoMallaAct = $datos[$i]['Attribute'];
                            $PresupuestadoMallaAct = $datos[$i]['Budgeted'];
                            $CuentaCliente = $datos[$i]['ClientId'];
                            $NombreCliente = $datos[$i]['ClientName'];
                            $EjecutadoMallaAct = $datos[$i]['Executed'];
                            $CumplimientMallaAct = $datos[$i]['Fulfillment'];
                            $contarMallaDetalles++;
                            $sqlInsertMallaActDetalle = $sqlInsertMallaActDetalle . "('$idMallaActivacion','$TipoMallaAct','$PresupuestadoMallaAct','$CuentaCliente','$NombreCliente','$EjecutadoMallaAct','$CumplimientMallaAct'),";
                        }
                    }
                }
            }
            if ($contarMallaDetalles > 0) {
                $sqlInsertMallaActDetalle = substr($sqlInsertMallaActDetalle, 0, -1);
                $sqlInsertMallaActDetalle .= ";";
                ServiceAltipal::model()->insertDatosAll($sqlInsertMallaActDetalle);
            }
            return $sqlInsertMallaActDetalle;
        } else {
            return 'La zona de ventas no tiene informacion';
        }
    }

    /**
     * @param string $cadena extructura 
     * @return string El mensaje del servicio
     * @soap
     */
    public function InsertCumplimientoGeneral($cadena) {
        $objJson = utf8_encode($cadena);
        $objCumplimiento = json_decode($objJson, true);
        foreach ($objCumplimiento as $key => $valor) {
            if (!is_array($valor)) {
                
            } else {
                foreach ($valor as $keyDimens => $keyDimensValor) {
                    if (!is_array($keyDimensValor)) {
                        $encabezado['diasHabiles'] = $valor['BusinessDays'];
                        $encabezado['diasTrans'] = $valor['ElapsedDays'];
                        $encabezado['mes'] = $valor['Month'];
                        $encabezado['ano'] = $valor['Year'];
                    } else {
                        foreach ($keyDimensValor as $keyDimensDetalle => $keyDimensValorDetalle) {
                            $agenciaEncabezado[$keyDimensDetalle]['codAgencia'] = $keyDimensValorDetalle['AgencyId'];
                            $agenciaEncabezado[$keyDimensDetalle]['NombreAgencia'] = utf8_decode($keyDimensValorDetalle['AgencyName']);
                            foreach ($keyDimensValorDetalle['Dimensions'] as $keyDetalle => $keyDetalleValor) {
                                $agencia[$keyDimensDetalle][$keyDetalle]['PresupuestadoCumplimiento'] = $keyDetalleValor['Budgeted'];
                                $agencia[$keyDimensDetalle][$keyDetalle]['NombreDimensionCumplimiento'] = $keyDetalleValor['DimensionName'];
                                $agencia[$keyDimensDetalle][$keyDetalle]['EjecutadoCumplimiento'] = $keyDetalleValor['Executed'];
                                $agencia[$keyDimensDetalle][$keyDetalle]['CumplimientoCumplimiento'] = $keyDetalleValor['Fulfillment'];
                            }
                        }
                    }
                }
            }
        }
        foreach ($agenciaEncabezado as $arrayresult) {
            $newEncabezado[] = array_merge($arrayresult, $encabezado);
        }
        for ($i = 0; $i < count($newEncabezado); $i++) {
            $modelEncabezado = new Cumplimientoagencia;
            $modelEncabezado->DiasHabiles = $newEncabezado[$i]['diasHabiles'];
            $modelEncabezado->DiasTranscurridos = $newEncabezado[$i]['diasTrans'];
            $modelEncabezado->Mes = $newEncabezado[$i]['mes'];
            $modelEncabezado->Año = $newEncabezado[$i]['ano'];
            $modelEncabezado->CodAgencia = $newEncabezado[$i]['codAgencia'];
            $modelEncabezado->NombreAgencia = $newEncabezado[$i]['NombreAgencia'];
            $modelEncabezado->save();
            foreach ($agencia[$i] as $toInsertDetallekey => $toInsertDetalleVal) {
                for ($p = 0; $p < count($toInsertDetalleVal); $p++) {
                    $modeloDetalle = new Cumplimientoagenciadetalle;
                    $modeloDetalle->IdCumplimientoAgencia = $modelEncabezado->Id;
                    $modeloDetalle->Presupuestado = $agencia[$i][$p]['PresupuestadoCumplimiento'];
                    $modeloDetalle->NombreDimension = $agencia[$i][$p]['NombreDimensionCumplimiento'];
                    $modeloDetalle->Ejecutado = $agencia[$i][$p]['EjecutadoCumplimiento'];
                    $modeloDetalle->Cumplimiento = $agencia[$i][$p]['CumplimientoCumplimiento'];
                    $modeloDetalle->save();
                }
                $modeloDetalle->unsetAttributes();
                $modelEncabezado->unsetAttributes();
            }
        }
//return 'OK';
    }

    /**
     * @param string $cadena  extructura   
     * @return string  El mensaje del servicio
     * @soap
     */
    public function LimpiarTablas() {
        $presupuestodimensiones = "TRUNCATE TABLE presupuestodimensiones";
        ServiceAltipal::model()->insertDatosAll($presupuestodimensiones);
        $presupuestofabricante = "TRUNCATE TABLE presupuestofabricante";
        ServiceAltipal::model()->insertDatosAll($presupuestofabricante);
        $presupuestoprofundidad = "TRUNCATE TABLE presupuestoprofundidad";
        ServiceAltipal::model()->insertDatosAll($presupuestoprofundidad);
        $presupuesto = "TRUNCATE TABLE presupuestos";
        ServiceAltipal::model()->insertDatosAll($presupuesto);
        $MallaActivacionDetalle = "TRUNCATE TABLE mallaactivaciondetalle";
        ServiceAltipal::model()->insertDatosAll($MallaActivacionDetalle);
        $MallaActivacion = "TRUNCATE TABLE mallaactivacion";
        ServiceAltipal::model()->insertDatosAll($MallaActivacion);
        $CumplimientoagenciaDetalle = "TRUNCATE TABLE cumplimientoagenciadetalle";
        ServiceAltipal::model()->insertDatosGlobal($CumplimientoagenciaDetalle);
        $Cumplimientoagencia = "TRUNCATE TABLE cumplimientoagencia";
        ServiceAltipal::model()->insertDatosGlobal($Cumplimientoagencia);
        return 'OK';
    }

    /**
     * @param string $cadena  extructura   
     * @return string  El mensaje del servicio
     * @soap
     */
    public function InicioActualizacion() {
        $Mensajes = "INICIO PROCESO ACTUALIZACIÓN DE INFORMACIÓN MALLA ACTIVACION";
        $Fecha = date('Y-m-d');
        $Hora = date('H:m:s');
        $ServiciAltipal = 'Malla Activacion';
        $Tablas = 'presupuestos,malla activacion,cumplimiento';
        $parametros = 'presupuestos: COdZonaVentas,  malla activacion: COdZonaVentas, cumplimiento:  sin parametro';
        $agencia = 'Todas';
        $sql = "INSERT INTO `erroresactualizacion`(`MensajeActivity`, `MensajeServicio`, `Fecha`, `Hora`, `ServicioSRF`, `TablasActualizar`, `Parametros`, `Agencia`) VALUES ('$Mensajes','$Mensajes','$Fecha','$Hora','$ServiciAltipal','$Tablas','$parametros','$agencia')";
        ServiceAltipal::model()->insertDatosGlobal($sql);
        return 'Iniciando Proceso de Actualizacion Malla Activacion';
    }

    /**
     * @param string $cadena  extructura   
     * @return string  El mensaje del servicio
     * @soap
     */
    public function FinActualizacion() {
        $Mensajes = "FINALIZA PROCESO ACTUALIZACIÓN DE INFORMACIÓN MALLA ACTIVACION";
        $Fecha = date('Y-m-d');
        $Hora = date('H:m:s');
        $ServiciAltipal = 'Malla Activacion';
        $Tablas = 'presupuestos,malla activacion,cumplimiento';
        $parametros = 'presupuestos: COdZonaVentas,  malla activacion: COdZonaVentas, cumplimiento:  sin parametro';
        $agencia = 'Todas';
        $sql = "INSERT INTO `erroresactualizacion`(`MensajeActivity`, `MensajeServicio`, `Fecha`, `Hora`, `ServicioSRF`, `TablasActualizar`, `Parametros`, `Agencia`) VALUES ('$Mensajes','$Mensajes','$Fecha','$Hora','$ServiciAltipal','$Tablas','$parametros','$agencia')";
        ServiceAltipal::model()->insertDatosGlobal($sql);
        return 'Finalizo Proceso de Actualizacion Malla Activacion';
    }

    /**
     * @return string
     * @soap   
     */
    public function selectProcessingMethods() {
        return json_encode(ServiceAltipal::model()->getProcessingMethods());
        //return json_encode($response);
    }

}
