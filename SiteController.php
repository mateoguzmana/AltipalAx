<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
            
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}        
        
       

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
             echo 'Inicio';
             exit();
                       
             $session=new CHttpSession;
            $session->open();
            
               Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/site/login.js',
                CClientScript::POS_END
                );
		
		$this->layout='login';
                
                
                
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
                
                 
                
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
                    
                       
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
                        if($model->validate() && $model->login()){
                            
                            if(Yii::app()->user->_cedula){
                                //echo Yii::app()->user->_cedula;
                                //exit();
                                $validarIdentificacion=  Consultas::model()->getValidarIdentificacion(Yii::app()->user->_cedula);
                                if($validarIdentificacion){                                    
                                     $session['canalEmpleado']= $validarIdentificacion['CodigoCanal'] ;                                    
                                }
                            }
                            
                            if(isset (Yii::app()->user->_FechaRetiro)){
                                if(Yii::app()->user->_FechaRetiro > "0000-00-00"){

                                    Yii::app()->user->setFlash('formResponsable', "1");                                
                                    $this->render('login',array('model'=>$model));  
                                }   
                            }else{
                              
                                $this->redirect(array('site/inicio')); 
                            }
                            
                        }else{
                            $this->render('login',array('model'=>$model));  
                        }
				
                }else{		
                    Yii::app()->user->logout();
                    $this->render('login',array('model'=>$model));
                }   
	}
        
        public function actionInicio(){
            $this->render('index');
        }

        /**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
                $this->layout='login';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(array('site/inicio'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('/'));
	}
        
        
        public function actionAjaxValidarIdentificacion(){
            
            $session=new CHttpSession;
            $session->open();
            
            if( $session['Idenficacion']){
                unset( $session['Idenficacion']);
            }
            
            $txtIdentificacion=$_POST['txtIdentificacion'];            
            $validarIdentificacion=  Consultas::model()->getValidarIdentificacion($txtIdentificacion);
            
            if($validarIdentificacion){
                $session['Responsable']=$validarIdentificacion['NumeroIdentidad'];
                echo '1';
            }else{
                echo '0';
            }
            
        }
}