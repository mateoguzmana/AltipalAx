<?php

class PedidoPreventaController extends Controller {

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

    public function actionIndex() {
        if ($_POST) {
            print_r($_POST);
            if ($_POST['codigoAsesor'] && $_POST['nombreAsesor']) {
                echo $_POST['codigoAsesor'];
                echo $_POST['nombreAsesor'];
                echo $_POST['zonaVentas'];
                exit();
                //$frecuenciaVisita=  Consultas::model()->getFrecuenciaSemana();
                //$asesoresComerciales=Consultas::model()->getAsesoresComercialesZonaVentas();
                //$this->render('index', array('asesoresComerciales'=>$asesoresComerciales, 'rutas'=>TRUE, 'frecuenciaVisita'=>$frecuenciaVisita));
            }
        } else {
            $frecuenciaVisita = Consultas::model()->getFrecuenciaSemana();
            $asesoresComerciales = Consultas::model()->getAsesoresComercialesZonaVentas();
            //$this->render('index', array('asesoresComerciales'=>$asesoresComerciales, 'rutas'=>FALSE));
            $this->render('index', array('asesoresComerciales' => $asesoresComerciales, 'rutas' => TRUE, 'frecuenciaVisita' => $frecuenciaVisita));
        }
    }

    public function actionAjaxCompletarFormAsesor() {
        if ($_POST) {
            if ($_POST['codigoAsesor']) {
                $codigoAsesor = $_POST['codigoAsesor'];
                $consultaAsesor = Consultas::model()->getNombreAsesor($codigoAsesor);
                $resultado = array(
                    'codigoAsesor' => '',
                    'nombreAsesor' => $consultaAsesor['Nombre'],
                );
                echo json_encode($resultado);
            }
            if ($_POST['nombreAsesor']) {
                $nombreAsesor = $_POST['nombreAsesor'];
                $consultaAsesor = Consultas::model()->getCodigoAsesor($nombreAsesor);
                $resultado = array(
                    'codigoAsesor' => $consultaAsesor['CodAsesor'],
                    'nombreAsesor' => '',
                );
                echo json_encode($resultado);
            }
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
      }
     */
}
