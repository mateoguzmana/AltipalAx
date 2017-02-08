<?php

/**
 * This is the model class for table "notascredito".
 *
 * The followings are the available columns in table 'notascredito':
 * @property integer $IdNotaCredito
 * @property string $CodAsesor
 * @property string $CodZonaVentas
 * @property string $CuentaCliente
 * @property integer $ResponsableNota
 * @property string $Concepto
 * @property string $Fabricante
 * @property string $Factura
 * @property double $Valor
 * @property string $Observacion
 * @property string $Fecha
 * @property string $Hora
 * @property integer $Autoriza
 * @property string $QuienAutoriza
 * @property integer $EstadoCorreo
 * @property string $FechaAutorizacion
 * @property string $HoraAutorizacion
 * @property string $ArchivoXml
 * @property string $ObservacionCartera
 * @property integer $Estado
 * @property string $Comentario
 * @property integer $IdDinamica
 * @property double $ValorDinamica
 * @property integer $Web
 * @property string $CodigoCanal
 * @property string $Responsable
 * @property integer $ExtraRuta
 * @property string $Ruta
 * @property string $Imei
 */
class Notascredito extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notascredito';
	}
        
         public function getDbConnection()
        {
           return self::setConexion();
        }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CodAsesor, CodZonaVentas, CuentaCliente, ResponsableNota, Concepto, Fabricante, Factura, Valor, Observacion, Fecha, Hora, QuienAutoriza, EstadoCorreo, FechaAutorizacion, HoraAutorizacion, ArchivoXml, ObservacionCartera,Comentario, IdDinamica, ValorDinamica, CodigoCanal, ExtraRuta, Ruta, Imei', 'required'),
			array('ResponsableNota, Autoriza, EstadoCorreo, Estado, IdDinamica, Web, ExtraRuta', 'numerical', 'integerOnly'=>true),
			array('Valor, ValorDinamica', 'numerical'),
			array('CodAsesor', 'length', 'max'=>16),
			array('CodZonaVentas, CuentaCliente, Concepto, Fabricante, Factura, Observacion, QuienAutoriza, ArchivoXml', 'length', 'max'=>100),
			array('ObservacionCartera', 'length', 'max'=>250),
			array('Comentario', 'length', 'max'=>200),
			array('CodigoCanal, Responsable', 'length', 'max'=>25),
			array('Ruta', 'length', 'max'=>3),
			array('Imei', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('IdNotaCredito, CodAsesor, CodZonaVentas, CuentaCliente, ResponsableNota, Concepto, Fabricante, Factura, Valor, Observacion, Fecha, Hora, Autoriza, QuienAutoriza, EstadoCorreo, FechaAutorizacion, HoraAutorizacion, ArchivoXml, ObservacionCartera, Estado, Comentario, IdDinamica, ValorDinamica, Web, CodigoCanal, Responsable, ExtraRuta, Ruta, Imei', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'IdNotaCredito' => 'Id Nota Credito',
			'CodAsesor' => 'Cod Asesor',
			'CodZonaVentas' => 'Cod Zona Ventas',
			'CuentaCliente' => 'Cuenta Cliente',
			'ResponsableNota' => 'Responsable Nota',
			'Concepto' => 'Concepto',
			'Fabricante' => 'Fabricante',
			'Factura' => 'Factura',
			'Valor' => 'Valor',
			'Observacion' => 'Observacion',
			'Fecha' => 'Fecha',
			'Hora' => 'Hora',
			'Autoriza' => 'Autoriza',
			'QuienAutoriza' => 'Quien Autoriza',
			'EstadoCorreo' => 'Estado Correo',
			'FechaAutorizacion' => 'Fecha Autorizacion',
			'HoraAutorizacion' => 'Hora Autorizacion',
			'ArchivoXml' => 'Archivo Xml',
			'ObservacionCartera' => 'Observacion Cartera',
			'Estado' => 'Estado',
			'Comentario' => 'Comentario',
			'IdDinamica' => 'Id Dinamica',
			'ValorDinamica' => 'Valor Dinamica',
			'Web' => 'Web',
			'CodigoCanal' => 'Codigo Canal',
			'Responsable' => 'Responsable',
			'ExtraRuta' => 'Extra Ruta',
			'Ruta' => 'Ruta',
			'Imei' => 'Imei',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('IdNotaCredito',$this->IdNotaCredito);
		$criteria->compare('CodAsesor',$this->CodAsesor,true);
		$criteria->compare('CodZonaVentas',$this->CodZonaVentas,true);
		$criteria->compare('CuentaCliente',$this->CuentaCliente,true);
		$criteria->compare('ResponsableNota',$this->ResponsableNota);
		$criteria->compare('Concepto',$this->Concepto,true);
		$criteria->compare('Fabricante',$this->Fabricante,true);
		$criteria->compare('Factura',$this->Factura,true);
		$criteria->compare('Valor',$this->Valor);
		$criteria->compare('Observacion',$this->Observacion,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Hora',$this->Hora,true);
		$criteria->compare('Autoriza',$this->Autoriza);
		$criteria->compare('QuienAutoriza',$this->QuienAutoriza,true);
		$criteria->compare('EstadoCorreo',$this->EstadoCorreo);
		$criteria->compare('FechaAutorizacion',$this->FechaAutorizacion,true);
		$criteria->compare('HoraAutorizacion',$this->HoraAutorizacion,true);
		$criteria->compare('ArchivoXml',$this->ArchivoXml,true);
		$criteria->compare('ObservacionCartera',$this->ObservacionCartera,true);
		$criteria->compare('Estado',$this->Estado);
		$criteria->compare('Comentario',$this->Comentario,true);
		$criteria->compare('IdDinamica',$this->IdDinamica);
		$criteria->compare('ValorDinamica',$this->ValorDinamica);
		$criteria->compare('Web',$this->Web);
		$criteria->compare('CodigoCanal',$this->CodigoCanal,true);
		$criteria->compare('Responsable',$this->Responsable,true);
		$criteria->compare('ExtraRuta',$this->ExtraRuta);
		$criteria->compare('Ruta',$this->Ruta,true);
		$criteria->compare('Imei',$this->Imei,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notascredito the static model class
	 */
	public static function model($className=__CLASS__)
	{
              Yii::import('application.extensions.multiple.Multiple'); 
		return parent::model($className);
	}
        
         public function getConsultaAplicacontado($zonaVentas) {

        $connection=Multiple::getConexionZonaVentas();   
        $sql = "SELECT gru.AplicaContado,znalma.Autoventa FROM zonaventas zona join gruposventas gru on zona.CodigoGrupoVentas=gru.CodigoGrupoVentas join zonaventaalmacen as znalma on zona.CodZonaVentas=znalma.CodZonaVentas where zona.CodZonaVentas = '$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }
    
    
     public function getConsultaVerdadero($zonaVentas,$agencia) {

        $connection= new Multiple();   
        $sql = "SELECT COUNT(*) as verdadero FROM `zonaventaalmacen` WHERE `CodZonaVentas` = '$zonaVentas'";
        $dataReader = $connection->consultaAgencia($agencia,$sql);
        return $dataReader;
    }
    

    public function InsertNotasCredito($codzona, $asesor, $cuentacliene, $responsable, $conceptos, $fabricante, $factura, $valor, $obser,$canal,$reponsablecanal,$codDimencion) {
        
        $session=new CHttpSession;
        $session->open(); 
        
        $ExtraRuta=$session['extraruta'];
        $Ruta=$session['rutaSeleccionada'];
        
        $connection=Multiple::getConexionZonaVentas();   
        $sql = "Insert into notascredito "
                . "(CodZonaVentas,"
                . "CodAsesor,"
                . "CuentaCliente,"
                . "ResponsableNota,"
                . "Concepto,"
                . "Fabricante,"
                . "Factura,"
                . "Valor,"
                . "Observacion,"
                . "Web,"
                . "Fecha,"
                . "Hora,"
                . "Autoriza,"
                . "Estado,"
                . "CodigoCanal,"
                . "Responsable, ExtraRuta,Ruta, CodigoDimension"
                . ") VALUES ('$codzona','$asesor','$cuentacliene','$responsable','$conceptos','$fabricante','$factura','$valor','$obser','1',CURDATE(),CURTIME(),'0','1','$canal','$reponsablecanal', '$ExtraRuta', '$Ruta', '$codDimencion')";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        
        $id=$connection->getLastInsertID('notascredito');
        
        return $id;
    }

    
    
    
    public function InsertImagenesNotasCredito($id, $nombre, $codzona, $cuentacliene, $factura) {

       $connection=Multiple::getConexionZonaVentas();   
        $sql = "Insert into notascreditofoto (IdNotaCredito,Nombre,CodZonaVentas,CuentaCliente,Factura,Fecha,Hora) VALUES ('$id','$nombre','$codzona','$cuentacliene','$factura',CURDATE(),CURTIME())";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }
    
    
     public function InsertServiceNotasCredito($Id,$codigoAgencia) {

        $connection=Multiple::getConexionZonaVentas();   
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`, `IdDocumento`, `CodigoAgencia`, `EstadoTransaccion`) VALUES ('7','$Id','$codigoAgencia','0')";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

    public function getDetalleFactura($factura) {


        $connection=Multiple::getConexionZonaVentas();   
        $sql = "SELECT facdetalle.CodigoVariante,facdetalle.CodigoArticulo,por.NombreArticulo,prov.NombreCuentaProveedor,facdetalle.CantidadFacturada,facdetalle.ValorNetoArticulo FROM facturasaldo fac join facturasaldodetalle facdetalle on fac.NumeroFactura=facdetalle.NumeroFactura left join portafolio por on facdetalle.CodigoVariante=por.CodigoVariante left join proveedores prov on facdetalle.CuentaProveedor=prov.CodigoCuentaProveedor WHERE fac.NumeroFactura = '$factura' group by facdetalle.CodigoArticulo,por.NombreArticulo,prov.NombreCuentaProveedor,facdetalle.CantidadFacturada,facdetalle.ValorNetoArticulo ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getSumaDetalleAltipal($factura) {

       $connection=Multiple::getConexionZonaVentas();   
        $sql = "SELECT sum(`ValorNetoArticulo`) as valordetalle FROM `facturasaldodetalle` where NumeroFactura = '$factura'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getSumaNotasCreditosAltipal($factura) {

        $connection=Multiple::getConexionZonaVentas();   
        $sql = "SELECT sum(Valor) as ValorNotasaltipal  FROM `notascredito` where Factura = '$factura' and Autoriza = 0";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getSumaDetalleProveedor($fabricante, $factura) {

        $connection=Multiple::getConexionZonaVentas();   
        $sql = "SELECT SUM(ValorNetoArticulo) as detalleproveedro FROM `facturasaldodetalle` where CuentaProveedor = '$fabricante' and NumeroFactura='$factura' ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getSumaNotasCretidtoProveedor($fabricante, $factura) {

       $connection=Multiple::getConexionZonaVentas();   
        $sql = "SELECT sum(Valor) as ValorNotasProveedor FROM `notascredito` where Fabricante = '$fabricante' and Factura ='$factura' and  Autoriza = 0";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getSumaNotasCretidtoProveedorbyAltipal($factura) {

        $connection=Multiple::getConexionZonaVentas();   
        $sql = "SELECT sum(Valor) as ValorNotasProveedorByAltipal FROM `notascredito` where Fabricante = '' and Autoriza = 0 and Factura ='$factura'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getClientesNotaCredito($cliente) {
            
        $connection=Multiple::getConexionZonaVentas();          
        $sql = "SELECT `CuentaCliente`,`NombreCliente` FROM `cliente` WHERE `CuentaCliente` = '$cliente'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;              
       
    }

    public function getZonaNotaCredito($zonaVentas) {

        $connection=Multiple::getConexionZonaVentas();   
        $sql = "SELECT `CodZonaVentas`,`NombreZonadeVentas` FROM `zonaventas` WHERE `CodZonaVentas` = '$zonaVentas' ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getAsesorNotaCredito($zonaVentas) {


        $connection=Multiple::getConexionZonaVentas();   
        $sql = " SELECT `CodAsesor` FROM `zonaventas` WHERE `CodZonaVentas` = '$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getDetalleFacturaFabricante($factura, $fabricante) {

        $connection=Multiple::getConexionZonaVentas();   
        $sql = "SELECT facdetalle.CodigoVariante,facdetalle.CodigoArticulo,por.NombreArticulo,prov.NombreCuentaProveedor,facdetalle.CantidadFacturada,facdetalle.ValorNetoArticulo FROM facturasaldo fac join facturasaldodetalle facdetalle on fac.NumeroFactura=facdetalle.NumeroFactura left join portafolio por on facdetalle.CodigoVariante=por.CodigoVariante left join proveedores prov on facdetalle.CuentaProveedor=prov.CodigoCuentaProveedor WHERE fac.NumeroFactura = '$factura' and prov.CodigoCuentaProveedor = '$fabricante' group by facdetalle.CodigoArticulo,por.NombreArticulo,prov.NombreCuentaProveedor,facdetalle.CantidadFacturada,facdetalle.ValorNetoArticulo ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getValorADigita($factura) {

        $connection=Multiple::getConexionZonaVentas();   
        $sql = "SELECT sum(ValorNetoArticulo) - (SELECT IFNULL((SELECT SUM(Valor) FROM notascredito WHERE Factura = '$factura'),0)) as valorfactura FROM `facturasaldodetalle` where NumeroFactura = '$factura' ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }
    
     public function getFacClie($cliente){
        
        $connection=Multiple::getConexionZonaVentas(); 
        //$sql="SELECT f.NumeroFactura,f.id,(SELECT sum(ValorNetoArticulo) - (SELECT IFNULL((SELECT SUM(Valor) FROM notascredito WHERE Factura = f.NumeroFactura),0)) as valorfactura FROM `facturasaldodetalle` where NumeroFactura = f.NumeroFactura) AS TOTALVALOR FROM `facturasaldo` as f WHERE `CuentaCliente` = '$cliente' and `CodigoZonaVentas` = '$zonaVentas' and `SaldoFactura` > 0 HAVING TOTALVALOR > 0 ";  
        $sql="SELECT f.NumeroFactura,f.id,(SELECT sum(ValorNetoArticulo) - (SELECT IFNULL((SELECT SUM(Valor) FROM notascredito WHERE Factura = f.NumeroFactura),0)) as valorfactura FROM `facturasaldodetalle` where NumeroFactura = f.NumeroFactura) AS TOTALVALOR FROM `facturasaldo` as f WHERE `CuentaCliente` = '$cliente'  and `SaldoFactura` > 0 HAVING TOTALVALOR > 0 ";  
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();        
        return $dataReader;
    }
    
   
    public function getFacturasCliente($cliente){
        
        $connection=Multiple::getConexionZonaVentas(); 
        $sql="SELECT NumeroFactura FROM `facturasaldo` where CuentaCliente = '$cliente'";  
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();        
        return $dataReader;
        
    }
    
    
     public function getFacturasDelClientes($cliente){
        
        $connection=Multiple::getConexionZonaVentas(); 
        $sql="SELECT COUNT(*) as facturasdelcliente FROM `facturasaldo` where CuentaCliente = '$cliente' AND SaldoFactura > 0";  
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();        
        return $dataReader;
        
    }
    
    
    public function getDetalleFacCliente($numerofac){
        
     $connection=Multiple::getConexionZonaVentas(); 
     $sql="SELECT COUNT(*) as facturasdetalle FROM `facturasaldodetalle` where NumeroFactura ='$numerofac' AND (CodigoVariante<>'0000000' AND CodigoVariante <>'')";  
     $command = $connection->createCommand($sql);
     $dataReader = $command->queryRow();        
     return $dataReader;  
        
    }

    public  function getDimencionesConceptos($concepto){
        
     $connection=Multiple::getConexionZonaVentas(); 
     $sql="SELECT CodigoDimension FROM `conceptosnotacredito` where CodigoConceptoNotaCredito = '$concepto'";  
     $command = $connection->createCommand($sql);
     $dataReader = $command->queryRow();        
     return $dataReader;    
         
    }
    
     
    public function getAdministradoresConfiguradosConceptosNotasCredito($concepto){
          
        $connection = Yii::app()->db; 
        $sql = "SELECT a.Id, a.Cedula, a.Usuario, a.Clave, a.Nombres, a.Apellidos, a.Email
        FROM  `administrador` AS a
        INNER JOIN configuracionconceptosnotascredito AS notas ON a.Id = notas.IdAdministrador
        WHERE a.Activo =  '1'  AND notas.CodigoConceptoNotasCredito = '$concepto'
        GROUP BY a.Id";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
          
          
      }

    
}
