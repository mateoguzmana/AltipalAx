<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class WebMobileController extends Controller {

    public function actionEnviarCopiaRecibo($zonaVentas = '', $cuentaCliente = '', $provisional = '', $emailCliente = '', $agencia = '') {

        if ($_POST) {
            $zonaVentas = trim($_POST['zonaVentas']);
            $cuentaCliente = trim($_POST['cuentaCliente']);
            $provisional = trim($_POST['provisional']);
            $emailCliente = trim($_POST['emailCliente']);
            $agencia = trim($_POST['agencia']);
        } else {
            $zonaVentas = trim($zonaVentas);
            $cuentaCliente = trim($cuentaCliente);
            $provisional = trim($provisional);
            $emailCliente = trim($emailCliente);
            $agencia = trim($agencia);
        }

        $datosRecibos = array(
            'zonaVentas' => $zonaVentas,
            'cuentaCliente' => $cuentaCliente,
            'provisional' => $provisional,
            'agencia' => $agencia
        );

        $zonaVentas = $datosRecibos['zonaVentas'];
        $cuentaCliente = trim($datosRecibos['cuentaCliente']);
        $provisional = $datosRecibos['provisional'];
        $agencia = $datosRecibos['agencia'];

        $datosZonaVentas = WebMobile::model()->getDatosZonaVentas($zonaVentas, $agencia);
        $datosCliente = WebMobile::model()->getDatosCliente($cuentaCliente, $agencia);

        //print_r($datosCliente);

        if ($zonaVentas && $cuentaCliente && $provisional) {


            $mPDF1 = Yii::app()->ePdf->mpdf();
            $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.min.css');
            $mPDF1->WriteHTML($stylesheet, 1);

            $mPDF1->WriteHTML($this->renderPartial('index', array(
                        'datosZonaVentas' => $datosZonaVentas,
                        'datosCliente' => $datosCliente,
                        'zonaVentas' => $zonaVentas,
                        'cuentaCliente' => $cuentaCliente,
                        'provisional' => $provisional
                            ), true));

            $ruta = 'pdfRecibos/' . $zonaVentas . '_' . $cuentaCliente . '_' . $provisional . '.pdf';

            $mPDF1->Output($ruta);

            $htmlBody = "<h3>Copia recibo de caja</h3>";


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
            $mail->addAddress($emailCliente, 'ALTIPAL S.A');
            $mail->WordWrap = 50;
            $mail->isHTML(true);
            $mail->Subject = 'Copia recibo de caja';
            $mail->Body = utf8_decode($htmlBody);
            $mail->AltBody = 'Copia recibo de caja';
            $mail->AddAttachment($ruta);      // attachment


            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                unlink($ruta);
                echo "OK";
            }
        }
    }

    public function actionEnviarFactura($zonaVentas = '', $cuentaCliente = '', $factura = '', $emailCliente = '', $agencia = '') {

        if ($_POST) {
            $zonaVentas = trim($_POST['zonaVentas']);
            $cuentaCliente = trim($_POST['cuentaCliente']);
            $factura = trim($_POST['factura']);
            $emailCliente = trim($_POST['emailCliente']);
            $agencia = trim($_POST['agencia']);
        } else {
            $zonaVentas = trim($zonaVentas);
            $cuentaCliente = trim($cuentaCliente);
            $factura = trim($factura);
            $emailCliente = trim($emailCliente);
            $agencia = trim($agencia);
        }

        $datosRecibos = array(
            'zonaVentas' => $zonaVentas,
            'cuentaCliente' => $cuentaCliente,
            'factura' => $factura,
            'agencia' => $agencia
        );

        $zonaVentas = $datosRecibos['zonaVentas'];
        $cuentaCliente = trim($datosRecibos['cuentaCliente']);

        $datosZonaVentas = WebMobile::model()->getDatosZonaVentas($zonaVentas, $agencia);
        $datosCliente = WebMobile::model()->getDatosCliente($cuentaCliente, $agencia);
        $idPedidosFactura = WebMobile::model()->getIdPedidoFactura($factura, $agencia);
        $datosPedidos = WebMobile::model()->getPedidosFactura($idPedidosFactura[0]['IdPedido'], $agencia);

        if ($zonaVentas && $cuentaCliente && $factura && $agencia) {

            $mPDF1 = Yii::app()->ePdf->mpdf();
            $mPDF1 = Yii::app()->ePdf->mpdf('', array(120, 350));

            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.min.css');
            $mPDF1->WriteHTML($stylesheet, 1);

            $mPDF1->WriteHTML($this->renderPartial('indexAu', array(
                        'datosZonaVentas' => $datosZonaVentas,
                        'datosCliente' => $datosCliente,
                        'zonaVentas' => $zonaVentas,
                        'cuentaCliente' => $cuentaCliente,
                        'factura' => $factura,
                        'agencia' => $agencia,
                        'datosPedidos' => $datosPedidos
                            ), true));

            $ruta = 'pdfRecibos/' . $zonaVentas . '_' . $cuentaCliente . '_' . $factura . '.pdf';

            $mPDF1->Output($ruta);

            $htmlBody = "<h3>Copia Factura</h3>";

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
            $mail->addAddress($emailCliente, 'ALTIPAL S.A');
            $mail->WordWrap = 50;
            $mail->isHTML(true);
            $mail->Subject = 'Copia Factura';
            $mail->Body = utf8_decode($htmlBody);
            $mail->Subject = 'Copia Factura';
            $mail->AddAttachment($ruta);      // attachment


            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                unlink($ruta);
                echo "OK";
            }
        }
    }

}
