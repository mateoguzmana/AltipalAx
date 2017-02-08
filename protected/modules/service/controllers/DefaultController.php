<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
            
         $mPDF1 = Yii::app()->ePdf->mpdf();
 
        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');
 
        # render (full page)
        //$mPDF1->WriteHTML($this->render('index', array(), true));
 
        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);
 
        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial('index', array(), true)); 
        # Renders image
        $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' )); 
        # Outputs ready PDF
        $mPDF1->Output('pdfRecibos/recibo.pdf','F');        
        //$mPDF1->Output();
        
        
        $htmlBody="<h3>Mensaje de prueba</h3>";
        
        
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer;
        
         //$mail = new PHPMailer;

        
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Host = "m1.redsegura.net";
            $mail->Port = 25;
            $mail->Username = 'ggarcia@activity.com.co';
            $mail->Password = 'activity6';



            $mail->From = 'desarrollo6activity@gmail.com';
            $mail->FromName = 'Activity soporte';
            $mail->addAddress('desarrollo6activity@gmail.com', 'Yoerni');   
            $mail->WordWrap = 50;           
            $mail->isHTML(true);            
            $mail->Subject = 'Copia recibo de caja';
            $mail->Body = utf8_decode($htmlBody);
            $mail->AltBody = 'Copia recibo de caja';
            
            $mail->AddAttachment("pdfRecibos/recibo.pdf");      // attachment
            
            //$mail->CharSet = 'UTF-8';
            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                echo "Message sent!";
                }
            //$mail->Send();
        
            
	}
}