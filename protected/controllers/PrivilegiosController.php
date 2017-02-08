<?php

class PrivilegiosController extends Controller {

    public $modulo = "";

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

    public function actionMenuPrivilegios() {
        $this->render('menuPrivilegios');
    }

    public function actionPerfil() {
        if (!empty($_POST['perfil'])) {
            foreach ($_POST['perfil'] as $item) {
                $nombre = $item;
            }
            $datosArray = array(
                'Descripcion' => $nombre,
            );
            $model = new Perfil;
            $model->setAttributes($datosArray);
            $model->save();
        }

        if (!empty($_POST['PerfilUsuario'])) {
            $totalLink = count($_POST['PerfilUsuario']);
            $idPerfil = $_POST['PerfilUsuario'][0];
            Consultas::model()->deleteAccionesPerfil($idPerfil);
            for ($i = 0; $i < $totalLink; $i++) {
                $prefil = $_POST['PerfilUsuario'][$i];
                $menu = $_POST['MenuLista'][$i];
                $link = $_POST['LinkLista'][$i];
                if (!empty($_POST['LinkListaDatos'][$link])) {
                    foreach ($_POST['LinkListaDatos'][$link] as $itemAcciones) {
                        Consultas::model()->InsertAccionesPerfil($prefil, $menu, $link, $itemAcciones);
                    }
                }
            }
            $perfiles = Perfil::model()->findAll();
            $this->render('perfil', array('perfiles' => $perfiles, 'idPerfil' => $idPerfil));
            exit();
        }
        $perfiles = Perfil::model()->findAll();
        $this->render('perfil', array('perfiles' => $perfiles));
    }

    public function actionAjaxConfiguracionPerfil() {
        $idPerfil = $_POST['idPerfil'];
        $perfilConfiguracion = Consultas::model()->getPerfilId($idPerfil);
        $accionesRegistradas = Consultas::model()->getLinkControladores();
        $accionesController = array();
        foreach ($accionesRegistradas as $item) {
            $controlador = $item['Controlador'];
            $acciones = $this->getActions($controlador . 'Controller');
            $modulos = Consultas::model()->getLinkModulos();
            if (!$acciones) {
                foreach ($modulos as $itemModulos) {
                    $moduloConsulta = strtolower($itemModulos['Descripcion']);
                    $acciones = $this->getActions($controlador . 'Controller', $moduloConsulta);
                    if ($acciones) {
                        break;
                    }
                }
            }
            array_push($accionesController, $acciones);
        }
        echo $this->renderPartial('_checkPerfil', array(
            'perfilConfiguracion' => $perfilConfiguracion,
            'accionesController' => $accionesController,
            'accionesRegistradas' => $accionesRegistradas,
            'idPerfil' => $idPerfil
                ), true);
    }

    private function getActions($controller, $module = null) {
        if ($module != null) {
            $path = join(DIRECTORY_SEPARATOR, array(Yii::app()->modulePath, $module, 'controllers'));
            //$this->setModuleIncludePaths($module);
        } else {
            $path = 'protected' . DIRECTORY_SEPARATOR . 'controllers';
        }
        if (!is_file($path . DIRECTORY_SEPARATOR . $controller . '.php')) {
            //throw new Exception('El archivo no se encuentra en el directorio ' . $path . DIRECTORY_SEPARATOR . $controller . '.php');
            return false;
            Yii:app()->end();
        }
        $actions = array();
        $file = fopen($path . DIRECTORY_SEPARATOR . $controller . '.php', 'r');
        $lineNumber = 0;
        while (feof($file) === false) {
            ++$lineNumber;
            $line = fgets($file);
            preg_match('/public[ \t]+function[ \t]+action([A-Z]{1}[a-zA-Z0-9]+)[ \t]*\(/', $line, $matches);
            if ($matches !== array()) {
                $name = $matches[1];
                $actions[] = $matches[1];
            }
        }
        return $actions;
    }

    public function actionAsignarPerfil() {
        $model = Administrador::model()->findAll();
        $perfiles = Perfil::model()->findAll();
        $this->render('asignarPerfil', array('model' => $model, 'perfiles' => $perfiles));
    }

    public function actionActualizarPerfil() {
        $perfil = $_POST['perfil'];
        $cedula = $_POST['cedula'];
        Consultas::model()->updatePerfil($cedula, $perfil);
        //echo $perfil;
    }

    public function actionEliminarPerfil() {
        $idPerfil = $_POST['idPerfil'];
        if (!Consultas::model()->eliminarPerfil($idPerfil)) {
            echo 'No se puede eliminar el perfil';
        } else {
            echo '1';
        }
    }

}
