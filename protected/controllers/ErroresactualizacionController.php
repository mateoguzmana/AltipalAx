<?php

class ErroresactualizacionController extends Controller {

    public function actionVerlog() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/errorlog/errorlog.js', CClientScript::POS_END
        );
        $errores = Erroresactualizacion::model()->getlogErrores();
        $this->render('index', array(
            'errores' => $errores
        ));
    }

    public function actionAjaxVerlog() {
        if (isset($_POST)) {
            $ini = $_POST['ini'];
            $fin = $_POST['fin'];
            $errores = Erroresactualizacion::model()->getlogErroresfecha($ini, $fin);
            $tabla = "";
            $tabla .='
			 <table class="table table-bordered" id="tbllogerror">
                        <thead>
                        <tr style="background-color: #8DB4E2;">
                        <th>Mensaje Activity</th>
			<th>MensajeServicio</th>
			<th>Fecha</th>
			<th>Hora</th>
                        <th>ServicioSRF</th>
			<th>Tablas a actualizar</th>
                        <th>Parametros</th>
                        <th>Agencia</th>
                        </tr>        
                        </thead>  
			<tbody>';
            foreach ($errores as $item) {
                $tabla .='<tr>
                            <td>' . $item['MensajeActivity'] . '</td>
                            <td>' . $item['MensajeServicio'] . '</td>
                            <td>' . $item['Fecha'] . '</td>
                            <td>' . $item['Hora'] . '</td>
                            <td>' . $item['ServicioSRF'] . '</td>
                            <td>' . $item['TablasActualizar'] . '</td>
                            <td>' . $item['Parametros'] . '</td>
                            <td>' . $item['Agencia'] . '</td>             
                            </tr>';
            }
            $tabla .='</tbody>
                        </table>';

            echo $tabla;
        }
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      } */
}
