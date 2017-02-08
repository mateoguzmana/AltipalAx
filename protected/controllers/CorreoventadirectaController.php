<?php

class CorreoventadirectaController extends Controller {

    public function actionIndex() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/correoventadirecta/correoventadirecta.js', CClientScript::POS_END
        );
        $Agencias = CorreoVentaDirecta::model()->getAgencia();
        $proveedores = CorreoVentaDirecta::model()->getSelectProveedores();
        $this->render('index', array('Agencias' => $Agencias, 'proveedores' => $proveedores));
    }

    public function actionAjaxCargarInformacionCorreo() {
        $correos = CorreoVentaDirecta::model()->getCorreosVentaDirecta();
        $arrayCorreos = array();
        foreach ($correos as $itemCorreo) {
            $boton = '<input type="button" class="btn btn-danger eliminarcorreo"  value="X"  data-id="' . $itemCorreo['Id'] . '">';
            $json = array(
                'Nombres' => $itemCorreo['Nombres'],
                'Apellidos' => $itemCorreo['Apellidos'],
                'CorreoElectronico' => $itemCorreo['CorreoElectronico'],
                //'CodigoCuentaProveedor' => $itemCorreo['CodigoCuentaProveedor'],
                //'NombreCuentaProveedor' => $itemCorreo['NombreCuentaProveedor'],
                'NombreAgencia' => $itemCorreo['NombreAgencia'],
                'Boton' => $boton
            );
            array_push($arrayCorreos, $json);
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($arrayCorreos),
            "iTotalDisplayRecords" => count($arrayCorreos),
            "aaData" => $arrayCorreos);
        echo json_encode($results);
    }

    public function actionAjaxCargarProveedores() {
        $proveedores = CorreoVentaDirecta::model()->geProveedores();
        $arrayProveedores = array();
        foreach ($proveedores as $itemProveedor) {
            $boton = '<input type="button" class="btn btn-danger eliminarproveedor"  value="X"  data-id="' . $itemProveedor['Id'] . '">';
            $json = array(
                'CuentaProveedor' => $itemProveedor['CodProveedor'],
                'NombreProveedor' => $itemProveedor['NombreCuentaProveedor'],
                'NombreAgencia' => $itemProveedor['NombreAgencia'],
                'Boton' => $boton
            );
            array_push($arrayProveedores, $json);
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($arrayProveedores),
            "iTotalDisplayRecords" => count($arrayProveedores),
            "aaData" => $arrayProveedores);
        echo json_encode($results);
    }

    public function actionAjaxGuardarCorreo() {
        if ($_POST) {
            $Nombre = $_POST['Nombre'];
            $Apellido = $_POST['Apellido'];
            $Correo = $_POST['correo'];
            $agencia = $_POST['agencia'];
            // $proveedores = $_POST['proveedores'];
            // foreach ($proveedores as $item){
            CorreoVentaDirecta::model()->getProveedoresInsert($Nombre, $Apellido, $Correo, $agencia);
            // }
        }
    }

    public function actionAjaxGuardarProveedor() {
        if ($_POST) {
            $codProveedor = $_POST['codProveedor'];
            $codAgencia = $_POST['codAgencia'];
            // $proveedores = $_POST['proveedores'];
            // foreach ($proveedores as $item){
            CorreoVentaDirecta::model()->setGuardarProveedores($codProveedor, $codAgencia);
            // }
        }
    }

    public function actionAjaxEliminarCorreo() {
        if ($_POST) {
            $id = $_POST['id'];
            CorreoVentaDirecta::model()->eliminarCorreo($id);
        }
    }

    public function actionAjaxEliminarProveedor() {
        if ($_POST) {
            $id = $_POST['id'];
            CorreoVentaDirecta::model()->eliminarProveedor($id);
        }
    }

}
