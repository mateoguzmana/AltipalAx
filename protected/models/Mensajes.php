<?php

/**
 * This is the model class for table "mensajes".
 *
 * The followings are the available columns in table 'mensajes':
 * @property integer $IdMensaje
 * @property string $IdDestinatario
 * @property string $IdRemitente
 * @property string $FechaMensaje
 * @property string $HoraMensaje
 * @property string $Mensaje
 * @property integer $Estado
 * @property string $CodAsesor
 *
 * The followings are the available model relations:
 * @property Estadomensaje $estado
 */
class Mensajes extends AgenciaActiveRecord {

    public $NombreZonadeVentas;
    public $Estadomensaje;
    public $remitente;
    public $nombre;
    public $NombreZonadeVentas2;
    public $Nombres;
    public $agenciaConexion = "002";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mensajes';
    }

    public function getDbConnection() {
        //return self::setConexion();
        return self::setConexion($this->agenciaConexion);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Estado, CodAsesor', 'required'),
            array('Estado', 'numerical', 'integerOnly' => true),
            array('IdDestinatario, IdRemitente, CodAsesor', 'length', 'max' => 16),
            array('Mensaje', 'length', 'max' => 600),
            array('FechaMensaje, HoraMensaje', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('IdMensaje, IdDestinatario, IdRemitente, FechaMensaje, HoraMensaje, Mensaje, Estado, CodAsesor', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'estado' => array(self::BELONGS_TO, 'Estadomensaje', 'Estado'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'IdMensaje' => 'Id Mensaje',
            'IdDestinatario' => 'Id Destinatario',
            'IdRemitente' => 'Id Remitente',
            'FechaMensaje' => 'Fecha Mensaje',
            'HoraMensaje' => 'Hora Mensaje',
            'Mensaje' => 'Mensaje',
            'Estado' => 'Estado',
            'NombreZonadeVentas' => 'Destinatario',
            'CodAsesor' => 'Cod Asesor',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('IdMensaje', $this->IdMensaje);
        $criteria->compare('IdDestinatario', $this->IdDestinatario, true);
        $criteria->compare('IdRemitente', $this->IdRemitente, true);
        $criteria->compare('FechaMensaje', $this->FechaMensaje, true);
        $criteria->compare('HoraMensaje', $this->HoraMensaje, true);
        $criteria->compare('Mensaje', $this->Mensaje, true);
        $criteria->compare('Estado', $this->Estado);
        $criteria->compare('CodAsesor', $this->CodAsesor, true);
        $criteria->compare('zvn.NombreZonadeVentas', $this->NombreZonadeVentas, true);
        $criteria->compare('Concat(IFNULL(ad.Nombres,""),IFNULL(ac.nombre,""),IFNULL(zv.NombreZonadeVentas,""))', $this->remitente, true);

        //$criteria->compare('remitente',$this->remitente,false);


        /* $criteria->alias='m';
          $criteria->select = 'm.IdDestinatario,m.IdRemitente,m.FechaMensaje,m.HoraMensaje,m.Mensaje,m.Estado,t.NombreZonadeVentas,ac.nombre,zv.NombreZonadeVentas as NombreZonadeVentas2 ,ad.Nombres,Concat(IFNULL(ad.Nombres,""),IFNULL(ac.nombre,""),IFNULL(zv.NombreZonadeVentas,"")) as remitente';
          $criteria->join = 'join zonaventas t on m.IdDestinatario = t.CodZonaVentas';
          $criteria->join .= ' left join asesorescomerciales ac on ac.cedula = m.IdRemitente';
          $criteria->join .= ' left join zonaventas zv on m.IdRemitente = zv.CodZonaVentas';
          $criteria->join .= ' left join administrador ad on m.IdRemitente = ad.cedula'; */


        $criteria->select = 't.IdDestinatario,t.IdRemitente,t.FechaMensaje,t.HoraMensaje,t.Mensaje,t.Estado,zvn.NombreZonadeVentas,ac.nombre,zv.NombreZonadeVentas as NombreZonadeVentas2 ,ad.Nombres,Concat(IFNULL(ad.Nombres,""),IFNULL(ac.nombre,""),IFNULL(zv.NombreZonadeVentas,"")) as remitente';
        $criteria->join = 'join zonaventas zvn on t.IdDestinatario = zvn.CodZonaVentas';
        $criteria->join .= ' left join asesorescomerciales ac on ac.cedula = t.IdRemitente';
        $criteria->join .= ' left join zonaventas zv on t.IdRemitente = zv.CodZonaVentas';
        $criteria->join .= ' left join administrador ad on t.IdRemitente = ad.cedula';


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Mensajes the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function consulta() {
        $sql = "SELECT * FROM zonaventas z,mensajes m WHERE z.CodZonaVentas = m.IdDestinatario";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $admin = $command->queryAll();
        return $admin;
    }

    public function getSupervisores() {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `jerarquiacomercial` where NombreCargo like '%JEFE DE VENTAS%'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getAgencia() {

        $connection = Yii::app()->db;
        $sql = "SELECT Nombre,CodAgencia 
        FROM  `agencia`";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getAsesoresSupervisor($supervisor) {

        $connection = Yii::app()->db;
        $sql = "SELECT jerar.*,ag.CodAgencia as Agencia FROM `jerarquiacomercial` jerar INNER JOIN agencia ag ON jerar.NombreSucursal=ag.Nombre where jerar.NombreJefe like '%$supervisor%' AND jerar.NombreCargo LIKE '%ASESOR COMERCIAL%'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function InsertMensajes($mensaje, $zonaventa, $agencia, $supervisor) {

        try {

            $connection = new Multiple();
            $sql = "INSERT INTO `mensajes`(`IdDestinatario`, `IdRemitente`, `FechaMensaje`, `HoraMensaje`, `Mensaje`, `Estado`, `CodAsesor`) VALUES ('$zonaventa','$supervisor',CURDATE(),CURTIME(),'$mensaje','0','0')";
            $dataReader = $connection->queryAgencia($agencia, $sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    public function getMesajesAgencia($fechaini,$fechafin,$agencia){
      
         try {

            $connection = new Multiple();
            $sql = "SELECT  m.*,z.NombreZonadeVentas FROM `mensajes`m INNER JOIN zonaventas z ON m.IdDestinatario=z.CodZonaVentas WHERE m.FechaMensaje between '$fechaini' AND '$fechafin'";
            $dataReader = $connection->consultaAgencia($agencia, $sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
        
    }
    
    
     public function getAsesoresTodos() {

        $connection = Yii::app()->db;
        $sql = "SELECT jerar.*,ag.CodAgencia as Agencia FROM `jerarquiacomercial` jerar INNER JOIN agencia ag ON jerar.NombreSucursal=ag.Nombre where jerar.NombreCargo LIKE '%ASESOR COMERCIAL%'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }
   
    

}
