<?php

/**
 * This is the model class for table "clientenuevo".
 *
 * The followings are the available columns in table 'clientenuevo':
 * @property integer $Id
 * @property string $CodZonaVentas
 * @property string $CodAsesor
 * @property string $CuentaCliente
 * @property string $Identificacion
 * @property string $DigitoVerificacion
 * @property string $CodTipoDocumento
 * @property string $Nombre
 * @property string $RazonSocial
 * @property string $Establecimiento
 * @property string $CodigoCiuu
 * @property string $PrimerNombre
 * @property string $SegundoNombre
 * @property string $PrimerApellido
 * @property string $SegundoApellido
 * @property string $Direccion
 * @property string $CodBarrio
 * @property string $OtroBarrio
 * @property string $Telefono
 * @property string $Telefono1
 * @property string $TelefonoMovil
 * @property string $Email
 * @property string $CodCadenadeEmpresa
 * @property string $NumeroVisita
 * @property string $Posicion
 * @property string $Latitud
 * @property string $Longitud
 * @property string $ZonaLogistica
 * @property string $CodigoPostal
 * @property string $DireccionEstandar
 * @property string $FechaRegistro
 * @property string $HoraRegistro
 * @property integer $Estado
 * @property integer $Generado
 * @property integer $Enviado
 * @property string $ArchivoXml
 * @property string $IdentificadorEnvio
 * @property string $CodigoCanal
 * @property string $NombreCanal
 * @property string $Responsable
 * @property string $Imei
 * @property string $CodZonaVentasProceso
 */
class Clientenuevo extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'clientenuevo';
    }

    public function getDbConnection() {
        return self::setConexion();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Identificacion,CodTipoDocumento,CodigoCiuu,Direccion,CodBarrio,NumeroVisita,FechaRegistro,HoraRegistro,CodigoCanal', 'required'),
            array('Estado,Generado,Enviado', 'numerical', 'integerOnly' => true),
            array('CodZonaVentas,Identificacion,Telefono1,ZonaLogistica,CodigoPostal,CodigoCanal,Responsable,CodZonaVentasProceso', 'length', 'max' => 25),
            array('CodAsesor,CodTipoDocumento,CodBarrio,CodCadenadeEmpresa', 'length', 'max' => 15),
            array('CuentaCliente,Establecimiento,CodigoCiuu,PrimerNombre,SegundoNombre,PrimerApellido,SegundoApellido,OtroBarrio,Telefono,TelefonoMovil,ArchivoXml,IdentificadorEnvio,Imei', 'length', 'max' => 250),
            array('DigitoVerificacion', 'length', 'max' => 3),
            array('Nombre,RazonSocial,NombreCanal', 'length', 'max' => 250),
            array('Direccion,DireccionEstandar', 'length', 'max' => 180),
            array('Email', 'length', 'max' => 80),
            array('NumeroVisita', 'length', 'max' => 5),
            array('Latitud,Longitud', 'length', 'max' => 45),
            array('Posicion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id,CodZonaVentas,CodAsesor,CuentaCliente,Identificacion,DigitoVerificacion,CodTipoDocumento,Nombre,RazonSocial,Establecimiento,CodigoCiuu,PrimerNombre,SegundoNombre,PrimerApellido,SegundoApellido,Direccion,CodBarrio,OtroBarrio,Telefono,Telefono1,TelefonoMovil,Email,CodCadenadeEmpresa,NumeroVisita,Posicion,Latitud,Longitud,ZonaLogistica,CodigoPostal,DireccionEstandar,FechaRegistro,HoraRegistro,Estado,Generado,Enviado,ArchivoXml,IdentificadorEnvio,CodigoCanal,NombreCanal,Responsable,Imei,CodZonaVentasProceso', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'CodZonaVentas' => 'Cod Zona Ventas',
            'CodAsesor' => 'Cod Asesor',
            'CuentaCliente' => 'Cuenta Cliente',
            'Identificacion' => 'Identificacion',
            'DigitoVerificacion' => 'Digito Verificacion',
            'CodTipoDocumento' => 'Cod Tipo Documento',
            'Nombre' => 'Nombre',
            'RazonSocial' => 'Razon Social',
            'Establecimiento' => 'Establecimiento',
            'CodigoCiuu' => 'Codigo Ciuu',
            'PrimerNombre' => 'Primer Nombre',
            'SegundoNombre' => 'Segundo Nombre',
            'PrimerApellido' => 'Primer Apellido',
            'SegundoApellido' => 'Segundo Apellido',
            'Direccion' => 'Direccion',
            'CodBarrio' => 'Cod Barrio',
            'OtroBarrio' => 'Otro Barrio',
            'Telefono' => 'Telefono',
            'Telefono1' => 'Telefono1',
            'TelefonoMovil' => 'Telefono Movil',
            'Email' => 'Email',
            'CodCadenadeEmpresa' => 'Cod Cadenade Empresa',
            'NumeroVisita' => 'Numero Visita',
            'Posicion' => 'Posicion',
            'Latitud' => 'Latitud',
            'Longitud' => 'Longitud',
            'ZonaLogistica' => 'Zona Logistica',
            'CodigoPostal' => 'Codigo Postal',
            'DireccionEstandar' => 'Direccion Estandar',
            'FechaRegistro' => 'Fecha Registro',
            'HoraRegistro' => 'Hora Registro',
            'Estado' => 'Estado',
            'Generado' => 'Generado',
            'Enviado' => 'Enviado',
            'ArchivoXml' => 'Archivo Xml',
            'IdentificadorEnvio' => 'Identificador Envio',
            'CodigoCanal' => 'Codigo Canal',
            'NombreCanal' => 'Nombre Canal',
            'Responsable' => 'Responsable',
            'Imei' => 'Imei',
            'CodZonaVentasProceso' => 'Cod Zona Ventas Proceso',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView,CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('Id', $this->Id);
        $criteria->compare('CodZonaVentas', $this->CodZonaVentas, true);
        $criteria->compare('CodAsesor', $this->CodAsesor, true);
        $criteria->compare('CuentaCliente', $this->CuentaCliente, true);
        $criteria->compare('Identificacion', $this->Identificacion, true);
        $criteria->compare('DigitoVerificacion', $this->DigitoVerificacion, true);
        $criteria->compare('CodTipoDocumento', $this->CodTipoDocumento, true);
        $criteria->compare('Nombre', $this->Nombre, true);
        $criteria->compare('RazonSocial', $this->RazonSocial, true);
        $criteria->compare('Establecimiento', $this->Establecimiento, true);
        $criteria->compare('CodigoCiuu', $this->CodigoCiuu, true);
        $criteria->compare('PrimerNombre', $this->PrimerNombre, true);
        $criteria->compare('SegundoNombre', $this->SegundoNombre, true);
        $criteria->compare('PrimerApellido', $this->PrimerApellido, true);
        $criteria->compare('SegundoApellido', $this->SegundoApellido, true);
        $criteria->compare('Direccion', $this->Direccion, true);
        $criteria->compare('CodBarrio', $this->CodBarrio, true);
        $criteria->compare('OtroBarrio', $this->OtroBarrio, true);
        $criteria->compare('Telefono', $this->Telefono, true);
        $criteria->compare('Telefono1', $this->Telefono1, true);
        $criteria->compare('TelefonoMovil', $this->TelefonoMovil, true);
        $criteria->compare('Email', $this->Email, true);
        $criteria->compare('CodCadenadeEmpresa', $this->CodCadenadeEmpresa, true);
        $criteria->compare('NumeroVisita', $this->NumeroVisita, true);
        $criteria->compare('Posicion', $this->Posicion, true);
        $criteria->compare('Latitud', $this->Latitud, true);
        $criteria->compare('Longitud', $this->Longitud, true);
        $criteria->compare('ZonaLogistica', $this->ZonaLogistica, true);
        $criteria->compare('CodigoPostal', $this->CodigoPostal, true);
        $criteria->compare('DireccionEstandar', $this->DireccionEstandar, true);
        $criteria->compare('FechaRegistro', $this->FechaRegistro, true);
        $criteria->compare('HoraRegistro', $this->HoraRegistro, true);
        $criteria->compare('Estado', $this->Estado);
        $criteria->compare('Generado', $this->Generado);
        $criteria->compare('Enviado', $this->Enviado);
        $criteria->compare('ArchivoXml', $this->ArchivoXml, true);
        $criteria->compare('IdentificadorEnvio', $this->IdentificadorEnvio, true);
        $criteria->compare('CodigoCanal', $this->CodigoCanal, true);
        $criteria->compare('NombreCanal', $this->NombreCanal, true);
        $criteria->compare('Responsable', $this->Responsable, true);
        $criteria->compare('Imei', $this->Imei, true);
        $criteria->compare('CodZonaVentasProceso', $this->CodZonaVentasProceso, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Clientenuevo the static model class
     */
    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getClientesNuevosAdd($zona) {
        $sql = "SELECT * FROM `clientenuevo` where Estado='' AND CodZonaVentas='$zona'";
        $connection = Multiple::getConexionZonaVentas($zona);
        return $connection->createCommand($sql)->queryAll();
    }

    public function getUpdateClienteNuevo($id) {
        $sql = "UPDATE `consignacionesvendedor` SET `ArchivoXml`='Archivoxml',`Estado`='1' WHERE `IdConsignacion`='$id'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getCodHomologacionAdd($CodTipoDocumento) {
        $sql = "SELECT CodigoTipoRegistro,CodigoTipoContribuyente FROM homologaciontiposdocumento WHERE CodigoTipoDocumento='$CodTipoDocumento'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function UpdateclienesNuvosTerminarRuta($zona, $agencia) {
        $sql = "UPDATE `clientenuevo` SET IdentificadorEnvio='1' where CodZonaVentas='$zona' AND FechaRegistro=CURDATE() AND IdentificadorEnvio='0'";
        $consulta = new Multiple();
        return $consulta->queryAgencia($agencia, $sql);
    }

    /////////METODOS PARA VERIFICAR CLIENTES NUEVOS /////////

    public function getEliminarClienteVacio() {
        $sql = "DELETE FROM clienteverificado WHERE `Identificador`=';'";
        return Yii::app()->db->createCommand($sql)->query();
    }

    public function getMaxClienteNuevo($Identificacion) {
        $sql = "SELECT MAX(IdClienteVerificado) AS id FROM `clienteverificado` WHERE `Identificador`='$Identificacion'";
        $dataReader = Yii::app()->db->createCommand($sql)->queryRow();
        return $dataReader['id'];
    }

    public function getDeleteClienteVerificadoZonaVentas($clientenuevomax) {
        $sql = "DELETE FROM clienteverificadozonasventas WHERE `IdClienteVerificado`='$clientenuevomax'";
        return Yii::app()->db->createCommand($sql)->query();
    }

    public function getEliminarCliente($documento) {
        $sql = "DELETE FROM `clienteverificado` WHERE `Identificador`='$documento'";
        return Yii::app()->db->createCommand($sql)->query();
    }

    public function getInsertClienteVerificado($Identificador, $CodigoTipoDocumento) {
        $sql = "INSERT INTO `clienteverificado`(`Identificador`,`CodigoTipoDocumento`,`Estado`,`FechaRegistro`,`HoraRegistro`) VALUES('$Identificador','$CodigoTipoDocumento','0',CURDATE(),CURTIME())";
        return Yii::app()->db->createCommand($sql)->query();
    }

    public function getClienteVerificado($Identificador) {
        $sql = "SELECT * FROM `clienteverificado` WHERE `Identificador`='$Identificador' ORDER BY `IdClienteVerificado` DESC LIMIT 1 ";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getZovantasVerificadas($cuentacliente) {
        $sql = "SELECT cl.IdClienteVerificado,cl.CodigoZonaVentas,cl.CedulaAsesorComercial,cl.NombreAsesorComercial,cl.CodigoGrupoVentas,g.NombreGrupoVentas,cl.CupoTotal FROM `clienteverificadozonasventas` AS cl LEFT JOIN gruposventas AS g ON cl.CodigoGrupoVentas=g.CodigoGrupoVentas WHERE `IdClienteVerificado`='$cuentacliente' GROUP BY cl.IdClienteVerificado,cl.CodigoZonaVentas";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getTipoDocumento($CodTipoDoc) {
        $sql = "SELECT * FROM `tipodocumento` WHERE Codigo='$CodTipoDoc'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getCodCiiu($codciiu) {
        $sql = "SELECT * FROM `ciiu` where CodigoCIIU='$codciiu'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getLocalizacion($codBarrio) {
        $sql = "SELECT * FROM `Localizacion` where CodigoBarrio='$codBarrio'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getCodGrupoVentas($zona) {
        $sql = "SELECT CodigoGrupoVentas FROM `zonaventas` WHERE CodZonaVentas='$zona'";
        $connection = Multiple::getConexionZonaVentas($zona);
        return $connection->createCommand($sql)->queryAll();
    }

    public function getVisita($frecuencia, $diaruta) {
        $sql = "SELECT NumeroVisita,CodFrecuencia,R1,R2,R3,R4 FROM frecuenciavisita WHERE CodFrecuencia='$frecuencia' AND (r1='$diaruta' OR r2='$diaruta' OR r3='$diaruta' OR r4='$diaruta');";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

//--------------------------------------------------------------------------------------------------------------------------------------------------
    public function getClienteVerificadoVariasVeces($Identificador) {
        $sql = "SELECT * FROM `clienteverificado` WHERE `Identificador`='$Identificador'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

//--------------------------------------------------------------------------------------------------------------------------------------------------
    public function getDatosClientes($Identificador, $cuentacliente) {
        $sql = "SELECT * FROM `clienteverificado` WHERE `Identificador`='$Identificador' AND CuentaCliente='$cuentacliente'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

}
