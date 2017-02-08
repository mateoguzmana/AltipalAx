<?php

class CorreoPedidosClientenuevoController extends Controller {

    public function actionIndex() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/correopedidoclientenuevo/correopedidoclientenuevo.js', CClientScript::POS_END
        );
        $pedidoMaximo = CorreoPedidosClientenuevo::model()->gePedidoMaximo();
        $Agencias = CorreoVentaDirecta::model()->getAgencia();
        $this->render('index', array('Agencias' => $Agencias, 'pedidoMaximo' => $pedidoMaximo));
    }

    public function actionAjaxCargarInformacionCorreo() {
        $correos = CorreoPedidosClientenuevo::model()->getCorreosPedidosClientenuevo();
        $arrayCorreos = array();
        $estadoCorreo = "INACTIVO";
        foreach ($correos as $itemCorreo) {
            $boton = '<input type="button" class="btn btn-danger eliminarcorreo"  value="X"  data-id="' . $itemCorreo['Id'] . '">';
            $botonEditar = '<input type="button" class="btn btn editarcorreo"  value="EDITAR"  data-id="' . $itemCorreo['Id'] . '">';
            $estadoCorreo = $itemCorreo['Estado'] == "1" ? "ACTIVO" : "INACTIVO";
            $json = array(
                'Nombres' => $itemCorreo['Nombre'],
                'Apellidos' => $itemCorreo['Apellidos'],
                'CorreoElectronico' => $itemCorreo['CorreoElectronico'],
                'EstadoCorreo' => $estadoCorreo,
                // 'NombreCuentaProveedor' => $itemCorreo['NombreCuentaProveedor'],
                'NombreAgencia' => $itemCorreo['NombreAgencia'],
                'Boton' => $boton,
                'BotonEditar' => $botonEditar
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

    /* public function actionAjaxCargarPedidoMaximo() {
      $pedidoMaximo = CorreoPedidosClientenuevo::model()->gePedidoMaximo();
      $arraypedidoMaximo = array();
      foreach ($pedidoMaximo as $itempedidoMaximo) {
      $botonEditar = '<input type="button" class="btn btn editarpedidomaximo"  value="EDITAR"  data-id="' . $itempedidoMaximo['Id'] . '">';
      $json = array(
      'Valor' => $itempedidoMaximo['Valor'],
      'FechaRegistro' => $itempedidoMaximo['Fecha'] . " " . $itempedidoMaximo['Hora'],
      'BotonEditar' => $botonEditar
      );
      array_push($arraypedidoMaximo, $json);
      }
      $results = array(
      "sEcho" => 1,
      "iTotalRecords" => count($arraypedidoMaximo),
      "iTotalDisplayRecords" => count($arraypedidoMaximo),
      "aaData" => $arraypedidoMaximo);
      echo json_encode($results);
      } */

    public function actionAjaxGuardarCorreo() {

        if ($_POST) {
            $Nombre = $_POST['Nombre'];
            $Apellido = $_POST['Apellido'];
            $Correo = $_POST['correo'];
            $agencia = $_POST['agencia'];
            CorreoPedidosClientenuevo::model()->getCorreoInfoInsert($Nombre, $Apellido, $Correo, $agencia);
        }
    }

    public function actionAjaxEliminarCorreo() {
        if ($_POST) {
            $id = $_POST['id'];
            CorreoPedidosClientenuevo::model()->eliminarCorreo($id);
        }
    }

    public function actionAjaxEditarCorreAlert() {
        if ($_POST) {
            $id = $_POST['id'];
            $infoRegistro = CorreoPedidosClientenuevo::model()->consultarRegistro($id);
            $Agencias = CorreoVentaDirecta::model()->getAgencia();
            $Nombre = $infoRegistro['Nombre'];
            $Apellido = $infoRegistro['Apellidos'];
            $Correo = $infoRegistro['CorreoElectronico'];
            $agencia = $infoRegistro['CodAgencia'];
            $estado = $infoRegistro['Estado'];
            echo $this->renderPartial('_editarcorreo', array('Nombre' => $Nombre, 'Apellido' => $Apellido, 'Correo' => $Correo, 'agencia' => $agencia, 'id' => $id, 'Agencias' => $Agencias, 'estado' => $estado));
        }
    }

    public function actionAjaxEditarValorAlert() {
        /* if ($_POST) {
          $id = $_POST['id']; */
        $infoRegistro = CorreoPedidosClientenuevo::model()->consultarRegistroValor();
        $valorPedidoMinimo = $infoRegistro['Valor'];
        $id = $infoRegistro['Id'];
        echo $this->renderPartial('_editarPedidoMinimo', array('valorPedidoMinimo' => $valorPedidoMinimo, 'id' => $id));
        // }
    }

    public function actionAjaxGuardarCorreoEditado() {
        if ($_POST) {
            $Nombre = $_POST['Nombre'];
            $Apellido = $_POST['Apellido'];
            $Correo = $_POST['correo'];
            $agencia = $_POST['agencia'];
            $estado = $_POST['estado'];
            $id = $_POST['id'];
            CorreoPedidosClientenuevo::model()->getCorreoInfoUpdate($Nombre, $Apellido, $Correo, $agencia, $estado, $id);
        }
    }

    public function actionAjaxGuardarValorEditado() {
        $usuario = Yii::app()->user->_cedula;
        if ($_POST) {
            $valor = $_POST['valor'];
            $id = $_POST['id'];
            CorreoPedidosClientenuevo::model()->getValorInfoUpdate($usuario, $valor, $id);
        }
    }

}
