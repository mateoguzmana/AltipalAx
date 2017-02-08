<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $id;
    private $nombre;
    /**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    public function authenticate()
    {
        $users = Administrador::model()->findByAttributes(array('Usuario'=>$this->username));
        
       
        
        if(count($users)<=0){
            //getAsesorComercial($codZonaVentas, $clave)
           
            $users=  Administrador::model()->getAsesorComercial($this->username, $this->password);
            
         
            
            if($users){
                
                $this->id= $users['Id'];
                $this->setState('_nombres', $users['Nombre']);
                $this->setState('_cedula', $users['Cedula']);
                $this->setState('_apellidos', '');
                $this->setState('_idPerfil', $users['IdPerfil']);
                $this->setState('_Id', $users['Id']);
                $this->setState('_usuario', $users['Usuario']);
                
                
                $this->setState('_zonaVentas', $users['CodZonaVentas']);                
                $this->setState('_codAsesor', $users['CodAsesor']);
                $this->setState('_FechaRetiro', $users['FechaRetiro']);
                $this->setState('_Agencia', $users['Agencia']);
                
                $this->errorCode=  self::ERROR_NONE;
                
                
                
                
            }else{
                if(count($users)<=0){
                    $this->errorCode=  self::ERROR_USERNAME_INVALID;
                  }else if($this->password !== $users['Clave']){
                    $this->errorCode=  self::ERROR_PASSWORD_INVALID;
                    
                }
            }
            
            return $this->errorCode==self::ERROR_NONE;
            
        }else{
            
        if($users==null){
                $this->errorCode=  self::ERROR_USERNAME_INVALID;
            }else if($this->password !== $users->Clave){
                $this->errorCode=  self::ERROR_PASSWORD_INVALID;
            }else{
                
                
                
                $this->id= $users->Id;
                $this->setState('_nombres', $users->Nombres);
                $this->setState('_cedula', $users->Cedula);
                $this->setState('_apellidos', $users->Apellidos);
                $this->setState('_idPerfil', $users->IdPerfil);
                $this->setState('_tipoUsuario', $users->IdTipoUsuario);
                
                $this->setState('_Id', $users->Id);
                $this->setState('_usuario', $users->Usuario);
                $this->setState('_FechaRetiro', '0000-00-00');
                $this->setState('_zonaVentas','');
                $this->setState('_codAsesor','');
                $this->setState('_Agencia','');

                $this->errorCode=  self::ERROR_NONE;
            }
            return $this->errorCode==self::ERROR_NONE;
        }
    }
}