<?php

/**
 * This is the model class for table "pedidos".
 *
 * The followings are the available columns in table 'pedidos':
 * @property integer $IdPedido
 * @property string $Conjunto
 * @property string $CodAsesor
 * @property string $CodZonaVentas
 * @property string $CuentaCliente
 * @property string $CodGrupoVenta
 * @property string $CodGrupoPrecios
 * @property string $CodigoSitio
 * @property string $CodigoAlmacen
 * @property string $FechaPedido
 * @property string $HoraDigitado
 * @property string $HoraEnviado
 * @property string $FechaEntrega
 * @property string $FormaPago
 * @property string $Plazo
 * @property string $TipoVenta
 * @property string $ActividadEspecial
 * @property string $Observacion
 * @property string $NroFactura
 * @property double $ValorPedido
 * @property string $TotalPedido
 * @property double $TotalValorIva
 * @property double $TotalSubtotalBaseIva
 * @property double $TotalValorImpoconsumo
 * @property string $TotalValorDescuento
 * @property string $Estado
 * @property string $ArchivoXml
 * @property string $FechaTerminacion
 * @property string $HoraTerminacion
 * @property integer $EstadoPedido
 * @property string $AutorizaDescuentoEspecial
 * @property integer $Web
 * @property string $PedidoMaquina
 * @property string $IdentificadorEnvio
 * @property string $CodigoCanal
 * @property string $Responsable
 * @property integer $ExtraRuta
 * @property string $Ruta
 * @property string $Imei
 * @property string $CodigoGrupodeImpuestos
 * @property string $CodigoZonaLogistica
 * @property string $Resolucion
 * @property string $Prefijo
 * @property string $CedulaUsuario
 */
class Pedidos extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pedidos';
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
            array('CodZonaVentas, CuentaCliente, CodGrupoVenta, CodGrupoPrecios, CodigoSitio, CodigoAlmacen, TipoVenta, PedidoMaquina, IdentificadorEnvio, CodigoCanal, ExtraRuta, Ruta, CodigoGrupodeImpuestos', 'required'),
            array('EstadoPedido, Web, ExtraRuta', 'numerical', 'integerOnly' => true),
            array('ValorPedido, TotalValorIva, TotalSubtotalBaseIva, TotalValorImpoconsumo', 'numerical'),
            array('Conjunto, CodZonaVentas, CodGrupoVenta, CodGrupoPrecios, IdentificadorEnvio, CodigoGrupodeImpuestos', 'length', 'max' => 15),
            array('CodAsesor, TotalPedido', 'length', 'max' => 16),
            array('CuentaCliente, CodigoSitio, CodigoAlmacen, TipoVenta, ActividadEspecial, NroFactura, TotalValorDescuento, Estado, AutorizaDescuentoEspecial, Responsable, CodigoZonaLogistica', 'length', 'max' => 25),
            array('FormaPago, Plazo', 'length', 'max' => 10),
            array('PedidoMaquina, Resolucion, Prefijo', 'length', 'max' => 60),
            array('CodigoCanal, Imei', 'length', 'max' => 50),
            array('CedulaUsuario', 'length', 'max' => 100),
            array('FechaPedido, HoraDigitado, HoraEnviado, FechaEntrega, Observacion, ArchivoXml, FechaTerminacion, HoraTerminacion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('IdPedido, Conjunto, CodAsesor, CodZonaVentas, CuentaCliente, CodGrupoVenta, CodGrupoPrecios, CodigoSitio, CodigoAlmacen, FechaPedido, HoraDigitado, HoraEnviado, FechaEntrega, FormaPago, Plazo, TipoVenta, ActividadEspecial, Observacion, NroFactura, ValorPedido, TotalPedido, TotalValorIva, TotalSubtotalBaseIva, TotalValorImpoconsumo, TotalValorDescuento, Estado, ArchivoXml, FechaTerminacion, HoraTerminacion, EstadoPedido, AutorizaDescuentoEspecial, Web, PedidoMaquina, IdentificadorEnvio, CodigoCanal, Responsable, ExtraRuta, Ruta, Imei, CodigoGrupodeImpuestos, CodigoZonaLogistica, Resolucion, Prefijo, CedulaUsuario', 'safe', 'on' => 'search'),
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
            'IdPedido' => 'Id Pedido',
            'Conjunto' => 'Conjunto',
            'CodAsesor' => 'Cod Asesor',
            'CodZonaVentas' => 'Cod Zona Ventas',
            'CuentaCliente' => 'Cuenta Cliente',
            'CodGrupoVenta' => 'Cod Grupo Venta',
            'CodGrupoPrecios' => 'Cod Grupo Precios',
            'CodigoSitio' => 'Codigo Sitio',
            'CodigoAlmacen' => 'Codigo Almacen',
            'FechaPedido' => 'Fecha Pedido',
            'HoraDigitado' => 'Hora Digitado',
            'HoraEnviado' => 'Hora Enviado',
            'FechaEntrega' => 'Fecha Entrega',
            'FormaPago' => 'Forma Pago',
            'Plazo' => 'Plazo',
            'TipoVenta' => 'Tipo Venta',
            'ActividadEspecial' => 'Actividad Especial',
            'Observacion' => 'Observacion',
            'NroFactura' => 'Nro Factura',
            'ValorPedido' => 'Valor Pedido',
            'TotalPedido' => 'Total Pedido',
            'TotalValorIva' => 'Total Valor Iva',
            'TotalSubtotalBaseIva' => 'Total Subtotal Base Iva',
            'TotalValorImpoconsumo' => 'Total Valor Impoconsumo',
            'TotalValorDescuento' => 'Total Valor Descuento',
            'Estado' => 'Estado',
            'ArchivoXml' => 'Archivo Xml',
            'FechaTerminacion' => 'Fecha Terminacion',
            'HoraTerminacion' => 'Hora Terminacion',
            'EstadoPedido' => 'Estado Pedido',
            'AutorizaDescuentoEspecial' => 'Autoriza Descuento Especial',
            'Web' => 'Web',
            'PedidoMaquina' => 'Pedido Maquina',
            'IdentificadorEnvio' => 'Identificador Envio',
            'CodigoCanal' => 'Codigo Canal',
            'Responsable' => 'Responsable',
            'ExtraRuta' => 'Extra Ruta',
            'Ruta' => 'Ruta',
            'Imei' => 'Imei',
            'CodigoGrupodeImpuestos' => 'Codigo Grupode Impuestos',
            'CodigoZonaLogistica' => 'Codigo Zona Logistica',
            'Resolucion' => 'Resolucion',
            'Prefijo' => 'Prefijo',
            'CedulaUsuario' => 'Cedula Usuario',
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

        $criteria->compare('IdPedido', $this->IdPedido);
        $criteria->compare('Conjunto', $this->Conjunto, true);
        $criteria->compare('CodAsesor', $this->CodAsesor, true);
        $criteria->compare('CodZonaVentas', $this->CodZonaVentas, true);
        $criteria->compare('CuentaCliente', $this->CuentaCliente, true);
        $criteria->compare('CodGrupoVenta', $this->CodGrupoVenta, true);
        $criteria->compare('CodGrupoPrecios', $this->CodGrupoPrecios, true);
        $criteria->compare('CodigoSitio', $this->CodigoSitio, true);
        $criteria->compare('CodigoAlmacen', $this->CodigoAlmacen, true);
        $criteria->compare('FechaPedido', $this->FechaPedido, true);
        $criteria->compare('HoraDigitado', $this->HoraDigitado, true);
        $criteria->compare('HoraEnviado', $this->HoraEnviado, true);
        $criteria->compare('FechaEntrega', $this->FechaEntrega, true);
        $criteria->compare('FormaPago', $this->FormaPago, true);
        $criteria->compare('Plazo', $this->Plazo, true);
        $criteria->compare('TipoVenta', $this->TipoVenta, true);
        $criteria->compare('ActividadEspecial', $this->ActividadEspecial, true);
        $criteria->compare('Observacion', $this->Observacion, true);
        $criteria->compare('NroFactura', $this->NroFactura, true);
        $criteria->compare('ValorPedido', $this->ValorPedido);
        $criteria->compare('TotalPedido', $this->TotalPedido, true);
        $criteria->compare('TotalValorIva', $this->TotalValorIva);
        $criteria->compare('TotalSubtotalBaseIva', $this->TotalSubtotalBaseIva);
        $criteria->compare('TotalValorImpoconsumo', $this->TotalValorImpoconsumo);
        $criteria->compare('TotalValorDescuento', $this->TotalValorDescuento, true);
        $criteria->compare('Estado', $this->Estado, true);
        $criteria->compare('ArchivoXml', $this->ArchivoXml, true);
        $criteria->compare('FechaTerminacion', $this->FechaTerminacion, true);
        $criteria->compare('HoraTerminacion', $this->HoraTerminacion, true);
        $criteria->compare('EstadoPedido', $this->EstadoPedido);
        $criteria->compare('AutorizaDescuentoEspecial', $this->AutorizaDescuentoEspecial, true);
        $criteria->compare('Web', $this->Web);
        $criteria->compare('PedidoMaquina', $this->PedidoMaquina, true);
        $criteria->compare('IdentificadorEnvio', $this->IdentificadorEnvio, true);
        $criteria->compare('CodigoCanal', $this->CodigoCanal, true);
        $criteria->compare('Responsable', $this->Responsable, true);
        $criteria->compare('ExtraRuta', $this->ExtraRuta);
        $criteria->compare('Ruta', $this->Ruta, true);
        $criteria->compare('Imei', $this->Imei, true);
        $criteria->compare('CodigoGrupodeImpuestos', $this->CodigoGrupodeImpuestos, true);
        $criteria->compare('CodigoZonaLogistica', $this->CodigoZonaLogistica, true);
        $criteria->compare('Resolucion', $this->Resolucion, true);
        $criteria->compare('Prefijo', $this->Prefijo, true);
        $criteria->compare('CedulaUsuario', $this->CedulaUsuario, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Pedidos the static model class
     */
    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function UpdatePedidosTerminarRuta($fecha, $hora, $zona, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `pedidos` SET `FechaTerminacion` = '$fecha', HoraTerminacion = '$hora' WHERE `CodZonaVentas` = '$zona' AND `FechaPedido` = CURDATE() AND IdentificadorEnvio = '1'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

}
