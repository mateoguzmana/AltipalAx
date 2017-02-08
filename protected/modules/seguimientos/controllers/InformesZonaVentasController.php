<?php

class InformesZonaVentasController extends Controller
{
    
    private $modulo="seguimientos";
    
    
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
          //  'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {       
        
        $cedula =  Yii::app()->user->_cedula;
        if (!$cedula) {
            $this->redirect('/');
        }         
        $Criteria = new CDbCriteria();
        $Criteria->condition = "Cedula = $cedula";
        
        $idPerfil = Yii::app()->user->_idPerfil;
        
        $controlador = Yii::app()->controller->getId(); 
        
        $PerfilAcciones = Consultas::model()->getPerfilAcciones($idPerfil, $controlador);        
        
                
         Yii::import('application.extensions.function.Action');         
         $estedAction=new Action();
         
         try {    
           
              $actionAjax = $estedAction->getActions(ucfirst($controlador).'Controller', $this->modulo);
             
         } catch (Exception $exc) {
             echo $exc->getTraceAsString();
         }

        $acciones = array();
        foreach ($PerfilAcciones as $itemAccion) {
            array_push($acciones, $itemAccion['Descripcion']);
        }

        foreach ($actionAjax as $item){
            $dato= strtolower ('ajax'.$item);
            array_push($acciones, $dato);
        }
        
        /*validacion para no mostrar botones*/
        $arrayAction = Listalink::model()->findPerfil(ucfirst($controlador),$idPerfil);
        $arrayDiferentes= $estedAction->diffActions(ucfirst($controlador).'Controller',$this->modulo,$arrayAction);
        
        $session=new CHttpSession;
        $session->open();
        $session['diferencia']=$arrayDiferentes;  
  
        
        
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
    
    
    ////////////////  MENU /////////////
    
	public function actionMenu($clear="")
	{
            
                 Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/seguimientos/informezonaventas/Menu.js', CClientScript::POS_END
        );
             
                 
            $session = new CHttpSession;
            $session->open();
            
            if($clear == '1'){
             
            unset($session['FormZonaVentas']);
                
            }
          
            if( $session['FormZonaVentas']){
                //unset($session['FormZonaVentas']);
                $this->render('IcoMenu',array(
                
                'zonaventas'=>$session['FormZonaVentas']
              
            ));
                  
            }  elseif ($_POST) {
              
             $session['FormZonaVentas'] = $_POST['CodZonaVentas'];
             
            
            $this->render('IcoMenu',array(
                
                'zonaventas'=>$_POST['CodZonaVentas'],
                  
            ));
            
            
          }else{
          
               
           $this->render('Form');
           
          }
            
		
	}
        
        
     ///////////////////// SITIOS Y ALAMECEN ////////////////////////   
        
        public  function actionSitiosAlmacen($zonaventas){
            
              Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/seguimientos/informezonaventas/sitiosAlmacen.js', CClientScript::POS_END
        );
            
            $session = new CHttpSession;
            $session->open();
          
             
            $this->render('SitiosAlmacen', array(
                
               'zonaventas'=>$zonaventas
                
            ));
            
        }  
        

        //////////////////// PORTAFOLIO ///////////////////////  
         public  function actionPortafolio($zonaventas){
             
               Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/seguimientos/informezonaventas/Portafolio.js', CClientScript::POS_END
        );
            
            $this->render('Portafolio',array(
                
                'zonaventas'=>$zonaventas
                
            ));
            
        }
        
        
        ////////////////preventa///////////////
        
        public function actionSaldosPreventa($sitio,$almacen){
            
                Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/seguimientos/informezonaventas/Preventa.js', CClientScript::POS_END
        );
            
            $this->render('Preventa',array(
                
                'sitio'=>$sitio,
                'almacen'=>$almacen    
                
            ));  
            
        }        
        
        
            ////////////////Autoventa///////////////
        
        public function actionSaldosAutoventa($sitio,$almacen){
            
                Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/seguimientos/informezonaventas/Autoventa.js', CClientScript::POS_END
        );
            
            $this->render('Autoventa',array(
                
                'sitio'=>$sitio,
                'almacen'=>$almacen    
                
            ));  
            
        }        
          
        
        //////////carga de sitios con ajax preventa ////////
        
        
        public  function actionAjaxCargarSitisoAlmacen(){
            
            
            if($_POST){
                
            
           
                $zona = $_POST['zonaventas'];
                
                $sitiosVentas =  InformeZonaVentas::model()->getsitiosalmacenbyzona($zona);
                
                $select="";
                
                $select.='
                     <select name="sitio" class="form-control" required id="select-sitioalmacen">
                     <option value="">Seleccione un sitio</option>
                ';
                
                 foreach ($sitiosVentas as $itemSitio){ 
                     
                     
                     $select.='
                            
                      <option data-sitio='.$itemSitio['CodigoSitio'].'  data-almacen='.$itemSitio['CodigoAlmacen'].'>'.$itemSitio['NombreSitio'].'-- '.$itemSitio['NombreAlmacen'].'</option>
                           
                     ';
                     
                 }
                
                 $select.='
                         </select>
                         ';
                 
                 echo $select;
            }
             
        }        
        
        
        ///////////carga de sitios con ajax autoventa //////////
        
         public  function actionAjaxCargarSitisoAlmacenAutoventa(){
            
            
            if($_POST){
                
                
                $zona = $_POST['zonaventas'];
                
                $sitiosVentas =  InformeZonaVentas::model()->getsitiosalmacenbyzona($zona);
                
                $select="";
                
                $select.='
                     <select name="sitio" class="form-control" required id="select-sitioalmacenAutoventa">
                     <option value="">Seleccione un sitio</option>
                ';
                
                 foreach ($sitiosVentas as $itemSitio){ 
                     
                     
                     $select.='
                            
                      <option data-sitio='.$itemSitio['CodigoSitio'].'  data-almacen='.$itemSitio['CodigoAlmacen'].'>'.$itemSitio['NombreSitio'].'-- '.$itemSitio['NombreAlmacen'].'</option>
                           
                     ';
                     
                 }
                
                 $select.='
                         </select>
                         ';
                 
                 echo $select;
            }
             
        }
        
        
         public function actionAjaxBorrarSession(){
             
            $session = new CHttpSession;
            $session->open();
            unset($session['FormZonaVentas']);
             
         }
       

}