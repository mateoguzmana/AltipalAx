<?php

class AdministracionFocalizadosController extends Controller {

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

    /*
     * se cargar el menu de adminisracion focalizadps
     */

    public function actionMenuFocalizados() {


        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/focalizados/focalizados.js', CClientScript::POS_END
        );


        $this->render('menuFocalizados');
    }

    public function actionSemanas() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/focalizados/semanas.js', CClientScript::POS_END
        );


        $this->render('semanas');
    }

    public function actionActividadFocalizados() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/focalizados/actividades.js', CClientScript::POS_END
        );
        
        $cedula = Yii::app()->getUser()->getState('_cedula');
        $Agencias = Focalizados::model()->getAgencias($cedula);


        $this->render('actividades',array('Agencias'=>$Agencias));
    }

    public function actionAjaxCargarInformacionSemana() {

        $ano = $_GET['ano'];
        $mes = $_GET['mes'];

        $semanas = Focalizados::model()->getSemanas($ano, $mes);
        $arraySemanas = array();

        foreach ($semanas as $itemSemana) {

            $boton = '<input type="button" class="btn btn-danger eliminarsemana"  value="X"  data-id="' . $itemSemana['Id'] .'"  data-fechafin=" '. $itemSemana['FechaFinal'].' "  data-fechaini="'.$itemSemana['FechaInicial'].'">';

            $json = array(
                'ano' => $itemSemana['Ano'],
                'mes' => $itemSemana['Mes'],
                'semana' => $itemSemana['Semana'],
                'fechainicial' => $itemSemana['FechaInicial'],
                'fechafinal' => $itemSemana['FechaFinal'],
                'hora' => $itemSemana['Hora'],
                'fecha' => $itemSemana['Fecha'],
                'usuario' => $itemSemana['IdUsuario'],
                'Boton' => $boton
            );

            array_push($arraySemanas, $json);
        }


        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($arraySemanas),
            "iTotalDisplayRecords" => count($arraySemanas),
            "aaData" => $arraySemanas);


        echo json_encode($results);
    }

    public function actionAjaxGuardarSemanas() {

        $fechaini = $_POST['fechaini'];
        $fechafin = $_POST['fechafin'];
        $semana = $_POST['semana'];
        $usuario = Yii::app()->user->_cedula;

        $FchaIni = explode('-', $fechaini);
        $Fchafin = explode('-', $fechafin);

        $mes = intval($FchaIni[1]);
        $ano = $FchaIni[0];


        $CountSemanas = Focalizados::model()->getSemanasMes($mes);
        $SemanaregistradaMes = Focalizados::model()->getSemanaYaResgistrada($ano,$mes,$semana);
        $FechasExitentes  = Focalizados::model()->getFechasExistentes($fechaini,$fechafin);

        if ($CountSemanas['semanasingresadas'] >= 5) {
            echo '1';
            return;
        }
        
        if($FchaIni[1] != $Fchafin[1] || $Fchafin[1] != $FchaIni[1] ){
             echo '2';
            return;
        }
        
        if($SemanaregistradaMes['semanayaregistrada'] > 0){
            echo '3';
            return; 
         }
         
        $fhini = str_replace('-','',$fechaini);
        $fhfin = str_replace('-','',$fechafin);
        $TotalDiasFecha =   $fhfin - $fhini;
        
        if($TotalDiasFecha == 1 || $TotalDiasFecha == 15){
            echo '4';
            return; 
        }
        
        if($FechasExitentes['FechasExistentes'] > 0){
            echo '5';
            return;
        }
        
        $InsertFocalizados = Focalizados::model()->InsertSemanas($ano,$mes,$semana,$fechaini,$fechafin,$usuario);
    }
    
    
    public function actionAjaxEliminarSemana(){
        
       $id =  $_POST['id'];
       $fechfin = $_POST['fechafin'];
       $fechaini = $_POST['fechaini'];
     
       $f_1 = explode("-",$fechaini);
       $f_2 = explode("-",$fechfin);
       
       $dateIni = date_create($f_1[0].'-'.$f_1[1].'-'.$f_1[2]);
       $fechaInicial = date_format($dateIni, 'Y-m-d');
       
       $datefin = date_create($f_2[0].'-'.$f_2[1].'-'.$f_2[2]);
       $fechaFinal = date_format($datefin, 'Y-m-d');
     
       
       if($fechaFinal < date('Y-m-d')){
           echo '1';
           return;
        }else  if($fechaInicial <= date('Y-m-d') && $fechaFinal >= date('Y-m-d')){
           echo '2';
           return;
        }
       
       Focalizados::model()->getDeleteSemana($id);
       
    }
    
    /*
     * se crea la funcion para cargar la zona de ventas que se encuentan en la agencia selecionada
     * @parameters
     * @_POST  codigo agencia
     */

    public function actionAjaxZonaVentasAgencia() {


        if ($_POST) {

            $CodAgencia = $_POST['agencia'];

            $zonaVentas = Consultas::model()->getZonaVentasxAgencia($CodAgencia);

            $option = "";

            $option.=' <select id="selectchosezonaventas2" name="ZoanVentas" class="form-control chosen-select"> <option value="0">Seleccione una zona ventas</option>';
            foreach ($zonaVentas as $itemZonaVentas) {

                $option.='
                     
                     <option  value="' . $itemZonaVentas['CodZonaVentas'] . '">' . $itemZonaVentas['CodZonaVentas'] . '-' . $itemZonaVentas['NombreZonadeVentas'] . '</option>
                      ';
            }

            $option.='</select>';

            echo $option;
        }
    }
    
    
    public function actionAjaxClientesZonaVentas(){
        
        if($_POST){
            
            $CodZonaVentas = $_POST['zona'];
            $CodAgencia = $_POST['agencia'];
            
           $Clientes = Focalizados::model()->getClientesZona($CodAgencia,$CodZonaVentas);
           
           $option="";
           $option.=' <select id="selectchoseclientes2" name="Clientes" class="form-control chosen-select"> <option value="0">Seleccione un cliente</option>';
           foreach ($Clientes as $itemcliente){
               
                  $option.='
                     
                     <option  value="' . $itemcliente['CuentaCliente'] . '">' . $itemcliente['CuentaCliente'] . '-' . $itemcliente['NombreCliente'] . '</option>
                      ';
               
           }
             $option.='</select>'; 
             
             echo $option; 
            
        }
        
    }
    
    
    public function actionAjaxGuardarActividad(){
        
        
        if($_POST){
            
            $agencia = $_POST['agencia'];
            $zonas = $_POST['zonas'];
            $cliente = $_POST['clientes'];
            $fechaini = $_POST['fechaini'];
            $fechafin= $_POST['fechafin'];
            $descripcion= $_POST['descripcion'];
            $inversion = $_POST['inversionactividad'];
           
            
            Focalizados::model()->InsertEjecucionActividad($agencia,$zonas,$cliente,$fechaini,$fechafin,$descripcion,$inversion);
            
        }
        
    }
    
    
    public function actionAjaxCargarInformacionActividad(){
        
        $zona = $_GET['zona'];
        $agencia = $_GET['agencia'];
        $cuentacliente = $_GET['cuentacliente'];
        
    
        $ActividadesZona = Focalizados::model()->getActividades($zona,$agencia,$cuentacliente);
        $arrayActizona = array();
        
        foreach ($ActividadesZona as $itemActizona){
            
            if($itemActizona['Ejecucion'] == 0){
                
                $ejecutado = 'No';
            }else{
                
                $ejecutado = 'Si';
            }
            
            
            $json = array(
                'zona'=>$itemActizona['CodZonaVentas'],
                'cuentacliente'=>$itemActizona['CuentaCliente'],
                'fechaini'=>$itemActizona['Fechainicio'],
                'fechafin'=>$itemActizona['Fechafin'],
                'descripcion'=>$itemActizona['Descripcion'],
                'inversion'=>$itemActizona['Inversion'],
                'ejecutado'=>$ejecutado
                
            );
            
         array_push($arrayActizona, $json);
        }


        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($arrayActizona),
            "iTotalDisplayRecords" => count($arrayActizona),
            "aaData" => $arrayActizona);
         
       echo json_encode($results);
        
    }

}
