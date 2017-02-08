<?php

/**
 * This is the model class for table "descripciontransferenciaautoventa".
 *
 * The followings are the available columns in table 'descripciontransferenciaautoventa':
 * @property integer $IdTransferenciaAutoventa
 * @property string $CodVariante
 * @property string $CodigoArticulo
 * @property string $NombreArticulo
 * @property string $CodigoUnidadMedida
 * @property string $NombreUnidadMedida
 * @property string $Cantidad
 * @property string $Lote
 * @property string $PedidoMaquina
 * @property string $IdentificadorEnvio
 * @property string $ValorUnitario
 * @property string $TotalPrecioNeto
 */
class Descripciontransferenciaautoventa extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'descripciontransferenciaautoventa';
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
            array('IdTransferenciaAutoventa, CodVariante, CodigoArticulo, NombreArticulo, CodigoUnidadMedida, NombreUnidadMedida, Cantidad, Lote, IdentificadorEnvio, ValorUnitario, TotalPrecioNeto', 'required'),
            array('IdTransferenciaAutoventa', 'numerical', 'integerOnly' => true),
            array('CodVariante, CodigoArticulo, Cantidad, Lote', 'length', 'max' => 50),
            array('NombreArticulo', 'length', 'max' => 150),
            array('CodigoUnidadMedida, NombreUnidadMedida, PedidoMaquina, IdentificadorEnvio, ValorUnitario', 'length', 'max' => 25),
            array('TotalPrecioNeto', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('IdTransferenciaAutoventa, CodVariante, CodigoArticulo, NombreArticulo, CodigoUnidadMedida, NombreUnidadMedida, Cantidad, Lote, PedidoMaquina, IdentificadorEnvio, ValorUnitario, TotalPrecioNeto', 'safe', 'on' => 'search'),
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
            'IdTransferenciaAutoventa' => 'Id Transferencia Autoventa',
            'CodVariante' => 'Cod Variante',
            'CodigoArticulo' => 'Codigo Articulo',
            'NombreArticulo' => 'Nombre Articulo',
            'CodigoUnidadMedida' => 'Codigo Unidad Medida',
            'NombreUnidadMedida' => 'Nombre Unidad Medida',
            'Cantidad' => 'Cantidad',
            'Lote' => 'Lote',
            'PedidoMaquina' => 'Pedido Maquina',
            'IdentificadorEnvio' => 'Identificador Envio',
            'ValorUnitario' => 'Valor Unitario',
            'TotalPrecioNeto' => 'Total Precio Neto',
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

        $criteria->compare('IdTransferenciaAutoventa', $this->IdTransferenciaAutoventa);
        $criteria->compare('CodVariante', $this->CodVariante, true);
        $criteria->compare('CodigoArticulo', $this->CodigoArticulo, true);
        $criteria->compare('NombreArticulo', $this->NombreArticulo, true);
        $criteria->compare('CodigoUnidadMedida', $this->CodigoUnidadMedida, true);
        $criteria->compare('NombreUnidadMedida', $this->NombreUnidadMedida, true);
        $criteria->compare('Cantidad', $this->Cantidad, true);
        $criteria->compare('Lote', $this->Lote, true);
        $criteria->compare('PedidoMaquina', $this->PedidoMaquina, true);
        $criteria->compare('IdentificadorEnvio', $this->IdentificadorEnvio, true);
        $criteria->compare('ValorUnitario', $this->ValorUnitario, true);
        $criteria->compare('TotalPrecioNeto', $this->TotalPrecioNeto, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Descripciontransferenciaautoventa the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
