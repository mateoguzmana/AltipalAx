<?php

class AdministarUsuariosController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='main_yii';

    /**
     * @return array action filters
     */
    /* public function filters()
      {
      return array(
      'accessControl', // perform access control for CRUD operations
      'postOnly + delete', // we only allow deletion via POST request
      );
      } */

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    /* public function accessRules()
      {
      return array(
      array('allow',  // allow all users to perform 'index' and 'view' actions
      'actions'=>array('index','view'),
      'users'=>array('*'),
      ),
      array('allow', // allow authenticated user to perform 'create' and 'update' actions
      'actions'=>array('create','update'),
      'users'=>array('@'),
      ),
      array('allow', // allow admin user to perform 'admin' and 'delete' actions
      'actions'=>array('admin','delete'),
      'users'=>array('admin'),
      ),
      array('deny',  // deny all users
      'users'=>array('*'),
      ),
      );
      } */

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionAjaxGetAgenciasGruposUsuario() {
        $agencias = AdministarUsuarios::model()->getAgencias();
        echo $this->renderPartial('_agenciaGruposUsuario', array('agencias' => $agencias));
    }

    public function actionAjaxGetConceptosNotasCredito() {

        $Id = $_POST['TipoUsuario'];

        $conceptosnotascreditos = AdministarUsuarios::model()->getConceptosNotasCredito($Id);
        echo $this->renderPartial('_conceptosNotasCredito', array('conceptosnotascreditos' => $conceptosnotascreditos));
    }

    public function actionAjaxGetPerfilAprobacionDoc() {
        $proveedores = AdministarUsuarios::model()->getProveedores();
        $perfilaprobacion = AdministarUsuarios::model()->getPerfilAprobacion();
        $envio = AdministarUsuarios::model()->getEstadoCorreo();
        echo $this->renderPartial('_informacionPerfilAprobacion', array('proveedores' => $proveedores, 'perfilaprobacion' => $perfilaprobacion, 'envio' => $envio));
    }

    public function actionAjaxResetAgenciaGrupoUsuario() {

        $session = new CHttpSession;
        $session->open();
        unset($session['AgenciaGrupoUsuario']);
    }

    public function actionAjaxResetConceptosNotasCredito() {

        $session = new CHttpSession;
        $session->open();
        unset($session['ConceptosNotasCredito']);
    }

    public function actionAjaxResetPerfilAprobacionDoc() {

        $session = new CHttpSession;
        $session->open();
        unset($session['PerfilAprobacionDoc']);
    }

    public function actionAjaxSetAgenciaGrupoUsuario() {

        $session = new CHttpSession;
        $session->open();

        if ($session['AgenciaGrupoUsuario']) {
            $datos = $session['AgenciaGrupoUsuario'];
        } else {
            $datos = array();
        }

        $arrayAgency = $_POST['arrayAgency'];
        //$grupoVentas = $_POST['grupoVentas'];
        /*$arrayItem = array(
            'agencia' => $agencia,
            'grupoVentas' => $grupoVentas,
        );

        array_push($datos, $arrayItem);*/
        
        $datos = $arrayAgency;
        echo '<pre>';
        print_r($datos);
        echo '</pre>';


        $session['AgenciaGrupoUsuario'] = $datos;
    }

    public function actionAjaxSetConceptosNotasCreditos() {

        $session = new CHttpSession;
        $session->open();

        if ($session['ConceptosNotasCredito']) {
            $datos = $session['ConceptosNotasCredito'];
        } else {
            $datos = array();
        }

        $conceptosnotascreditos = $_POST['conceptosnotascreditos'];

        $arrayItem = array(
            'conceptosnotascreditos' => $conceptosnotascreditos,
        );

        array_push($datos, $arrayItem);

        echo '<pre>';
        print_r($datos);
        echo '</pre>';


        $session['ConceptosNotasCredito'] = $datos;
    }

    public function actionAjaxSetPerfilAprobacionDoc() {

        $session = new CHttpSession;
        $session->open();

        if ($session['PerfilAprobacionDoc']) {
            $datos = $session['PerfilAprobacionDoc'];
        } else {
            $datos = array();
        }


        $proveedores = $_POST['proveedores'];
        $perfilaprobaciondoc = $_POST['perfilaprobaciondoc'];
        $envio = $_POST['envio'];

        $arrayItem = array(
            'proveedores' => $proveedores,
            'perfilaprobaciondoc' => $perfilaprobaciondoc,
            'envio' => $envio
        );

        array_push($datos, $arrayItem);

        echo '<pre>';
        print_r($datos);
        echo '</pre>';


        $session['PerfilAprobacionDoc'] = $datos;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->layout = 'main_yii';

        $session = new CHttpSession;
        $session->open();

        if ($session['AgenciaGrupoUsuario']) {
            $datos = $session['AgenciaGrupoUsuario'];
        } else {
            $datos = array();
        }

        if ($session['ConceptosNotasCredito']) {

            $datosNotas = $session['ConceptosNotasCredito'];
        } else {
            $datosNotas = array();
        }


        if ($session['PerfilAprobacionDoc']) {
            $datosPerfilAprobacion = $session['PerfilAprobacionDoc'];
        } else {
            $datosPerfilAprobacion = array();
        }


        $model = new Administrador;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/administarUsuarios/update_create.js', CClientScript::POS_END
        );


        if (isset($_POST['Administrador'])) {
            $model->attributes = $_POST['Administrador'];
            if ($model->validate()) {
                $model->save();
                $idGordo = $model->Id;



                foreach ($datos as $item) {
                    $arrayConfigAdmin = array(
                        'IdAdministrador' => $idGordo,
                        'CodAgencia' => $item['agencia'],
                        'CodigoGrupoVentas' => $item['grupoVentas']
                    );

                    $modeloConfigAdministracion = new Configuracionadministrador();
                    $modeloConfigAdministracion->attributes = $arrayConfigAdmin;
                    if ($modeloConfigAdministracion->validate()) {
                        $modeloConfigAdministracion->save();
                    }
                }


                foreach ($datosNotas as $itemnotas) {
                    $arrayConfigNotas = array(
                        'IdAdministrador' => $idGordo,
                        'CodigoConceptoNotasCredito' => $itemnotas['conceptosnotascreditos'],
                    );

                    $modeloConfigNotas = new Configuracionconceptosnotascredito();
                    $modeloConfigNotas->attributes = $arrayConfigNotas;
                    if ($modeloConfigNotas->validate()) {
                        $modeloConfigNotas->save();
                    }
                }

                foreach ($datosPerfilAprobacion as $itemperfilaproba) {
                    $arrayConfigPerfilAproba = array(
                        'IdAdministrador' => $idGordo,
                        'IdPerfilAprobacion' => $itemperfilaproba['perfilaprobaciondoc'],
                        'CodigoProveedor' => $itemperfilaproba['proveedores'],
                        'EnvioCorreo' => $itemperfilaproba['envio'],
                    );
                    $modeloConfigPerfilAproba = new Configuracionaprobaciondocumentos();
                    $modeloConfigPerfilAproba->attributes = $arrayConfigPerfilAproba;
                    if ($modeloConfigPerfilAproba->validate()) {
                        $modeloConfigPerfilAproba->save();
                    }
                }

                $this->redirect(array('ListarUsuarios'));
            } else {

                print_r($model->getErrors());
                exit();
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $idPerfilUpdate = $model['IdPerfil'];

        $session = new CHttpSession;
        $session->open();


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        $verificacionconfig = AdministarUsuarios::model()->getVerificarConfiguracion($idPerfilUpdate);


        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/administarUsuarios/update_create.js', CClientScript::POS_END
        );



        $sql = Configuracionadministrador::model()->findAll(array("condition" => "IdAdministrador =  $id", "order" => "IdAdministrador"));
        $sqlnotas = Configuracionconceptosnotascredito::model()->findAll(array("condition" => "IdAdministrador =  $id", "order" => "IdAdministrador"));
        $sqlPerfilAprobaion = Configuracionaprobaciondocumentos::model()->findAll(array("condition" => "IdAdministrador =  $id", "order" => "IdAdministrador"));



        $datos = array();
        $datosNotas = array();
        $datosPerfilAproba = array();

        foreach ($sql as $itemsql) {

            $agencia = $itemsql['CodAgencia'];
            $grupoventas = $itemsql['CodigoGrupoVentas'];

            $itemAgenciaGrupo = array(
                'agencia' => $agencia,
                'grupoVentas' => $grupoventas,
            );

            array_push($datos, $itemAgenciaGrupo);
        }


        foreach ($sqlnotas as $itemsqlnotas) {

            $conceptosnotascreditos = $itemsqlnotas['CodigoConceptoNotasCredito'];

            $itemConceptoNota = array(
                'conceptosnotascreditos' => $conceptosnotascreditos,
            );


            array_push($datosNotas, $itemConceptoNota);
        }


        foreach ($sqlPerfilAprobaion as $itemsqlperfilaproba) {


            $proveedores = $itemsqlperfilaproba['CodigoProveedor'];
            $perfilAprobacionDoc = $itemsqlperfilaproba['IdPerfilAprobacion'];
            $envio = $itemsqlperfilaproba['EnvioCorreo'];

            $itemPerfilAprobacionDocu = array(
                'proveedores' => $proveedores,
                'perfilaprobaciondoc' => $perfilAprobacionDoc,
                'envio' => $envio
            );

            //echo '<pre>';
            //print_r($itemPerfilAprobacionDocu);
            // exit();


            array_push($datosPerfilAproba, $itemPerfilAprobacionDocu);
        }


        if (isset($_POST['Administrador'])) {


            $arrayAdmin = $_POST['Administrador'];
            $ConceptosNot = $session['ConceptosNotasCredito'];

            if ($arrayAdmin['IdTipoUsuario'] == '1' && $ConceptosNot[0]['conceptosnotascreditos'] == '019') {
                unset($session['ConceptosNotasCredito']);
            }

            $model->attributes = $_POST['Administrador'];

            if ($model->validate()) {
                $model->save();
                if ($session['AgenciaGrupoUsuario']) {
                    $datosUpdate = $session['AgenciaGrupoUsuario'];
                } else {
                    $datosUpdate = array();
                }

                if ($session['ConceptosNotasCredito']) {
                    $datosNotasUpdate = $session['ConceptosNotasCredito'];
                } else {
                    $datosNotasUpdate = array();
                }

                if ($session['PerfilAprobacionDoc']) {
                    $datosPerfilAprobacionUpdate = $session['PerfilAprobacionDoc'];
                } else {
                    $datosPerfilAprobacionUpdate = array();
                }

                AdministarUsuarios::model()->getEliminarConfiguracion($id);

               /* echo '<pre>';
                print_r($datosUpdate);*/
                // exit();


                foreach ($datosUpdate as $item) {

                    $arrayConfigAdminUpdate = array(
                        'IdAdministrador' => $model->Id,
                        'CodAgencia' => $item['agencia'],
                        'CodigoGrupoVentas' => $item['grupoVentas']
                    );

                    $modeloConfigAdminUpdate = new Configuracionadministrador();
                    $modeloConfigAdminUpdate->attributes = $arrayConfigAdminUpdate;
                    if ($modeloConfigAdminUpdate->validate()) {
                        $modeloConfigAdminUpdate->save();
                    }
                }


                AdministarUsuarios::model()->getEliminarConfiguracionConceptosNotasCredito($id);


                foreach ($datosNotasUpdate as $itemnotas) {

                    $arrayConfigNotasUpdate = array(
                        'IdAdministrador' => $model->Id,
                        'CodigoConceptoNotasCredito' => $itemnotas['conceptosnotascreditos'],
                    );

                    $modeloConfigNotasUpdate = new Configuracionconceptosnotascredito();
                    $modeloConfigNotasUpdate->attributes = $arrayConfigNotasUpdate;
                    if ($modeloConfigNotasUpdate->validate()) {
                        $modeloConfigNotasUpdate->save();
                    }
                }

                AdministarUsuarios::model()->getEliminarConfiguracionAprobacionDocmuentos($id);


                foreach ($datosPerfilAprobacionUpdate as $itemperfilaproba) {

                    $arrayConfigPerfilAprobaUpdate = array(
                        'IdAdministrador' => $model->Id,
                        'IdPerfilAprobacion' => $itemperfilaproba['perfilaprobaciondoc'],
                        'EnvioCorreo' => $itemperfilaproba['envio'],
                        'CodigoProveedor' => $itemperfilaproba['proveedores'],
                    );

                    $modeloConfigPerfilAprobaUpdate = new Configuracionaprobaciondocumentos();
                    $modeloConfigPerfilAprobaUpdate->attributes = $arrayConfigPerfilAprobaUpdate;
                    echo $modeloConfigPerfilAprobaUpdate->validate();
                    if ($modeloConfigPerfilAprobaUpdate->validate()) {
                        $modeloConfigPerfilAprobaUpdate->save();
                    }
                }



                $this->redirect(array('ListarUsuarios'));
            } else {

                print_r($model->getErrors());
                exit();
            }
        }

        $this->render('update', array(
            'model' => $model,
            'datos' => $datos,
            'datosNotas' => $datosNotas,
            'datosPerfilAproba' => $datosPerfilAproba,
            'verificacionconfig' => $verificacionconfig
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        AdministarUsuarios::model()->getEliminarConfiguracion($id);
        AdministarUsuarios::model()->getEliminarConfiguracionAprobacionDocmuentos($id);
        AdministarUsuarios::model()->getEliminarConfiguracionConceptosNotasCredito($id);


        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Administrador');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionListarUsuarios() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/administarUsuarios/update_create.js', CClientScript::POS_END
        );

        $this->layout = 'main_yii';
        $model = new Administrador('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Administrador']))
            $model->attributes = $_GET['Administrador'];

        $this->render('ListarUsuarios', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Administrador the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Administrador::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Administrador $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'administrador-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxBuscarConfiguracionPrivilegio() {

        if ($_POST) {

            $id = $_POST['idperfil'];

            $verificar = AdministarUsuarios::model()->getVerificarConfiguracion($id);

            foreach ($verificar as $item) {

                $item['perimisoparaconceptos'];
            }

            echo $item['perimisoparaconceptos'];
        }
    }

}
