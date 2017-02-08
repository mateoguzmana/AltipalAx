<?php

/**
 * This is the model class for table "descripciondevolucion".
 *
 * The followings are the available columns in table 'descripciondevolucion':
 * @property integer $IdDevolucion
 * @property string $CodigoVariante
 * @property string $CodigoArticulo
 * @property string $NombreArticulo
 * @property string $CodigoUnidadMedida
 * @property string $NombreUnidadMedida
 * @property integer $Cantidad
 * @property double $ValorUnitario
 * @property double $ValorBruto
 * @property double $Impoconsumo
 * @property double $ValorImpoconsumo
 * @property string $Iva
 * @property double $ValorIva
 * @property double $ValorTotalProducto
 * @property integer $Autoriza
 * @property string $UnidadMedidaConversion
 * @property integer $CantidadConversion
 */
class Descripciondevolucion extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'descripciondevolucion';
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
            array('IdDevolucion, CodigoVariante, CodigoArticulo, NombreArticulo, CodigoUnidadMedida, NombreUnidadMedida, Cantidad, ValorBruto, Impoconsumo, ValorImpoconsumo, Iva, ValorIva, ValorTotalProducto, UnidadMedidaConversion, CantidadConversion', 'required'),
            array('IdDevolucion, Cantidad, Autoriza, CantidadConversion', 'numerical', 'integerOnly' => true),
            array('ValorUnitario, ValorBruto, Impoconsumo, ValorImpoconsumo, ValorIva, ValorTotalProducto', 'numerical'),
            array('CodigoVariante, CodigoArticulo, CodigoUnidadMedida, NombreUnidadMedida, Iva, UnidadMedidaConversion', 'length', 'max' => 25),
            array('NombreArticulo', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('IdDevolucion, CodigoVariante, CodigoArticulo, NombreArticulo, CodigoUnidadMedida, NombreUnidadMedida, Cantidad, ValorUnitario, ValorBruto, Impoconsumo, ValorImpoconsumo, Iva, ValorIva, ValorTotalProducto, Autoriza, UnidadMedidaConversion, CantidadConversion', 'safe', 'on' => 'search'),
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
            'IdDevolucion' => 'Id Devolucion',
            'CodigoVariante' => 'Codigo Variante',
            'CodigoArticulo' => 'Codigo Articulo',
            'NombreArticulo' => 'Nombre Articulo',
            'CodigoUnidadMedida' => 'Codigo Unidad Medida',
            'NombreUnidadMedida' => 'Nombre Unidad Medida',
            'Cantidad' => 'Cantidad',
            'ValorUnitario' => 'Valor Unitario',
            'ValorBruto' => 'Valor Bruto',
            'Impoconsumo' => 'Impoconsumo',
            'ValorImpoconsumo' => 'Valor Impoconsumo',
            'Iva' => 'Iva',
            'ValorIva' => 'Valor Iva',
            'ValorTotalProducto' => 'Valor Total Producto',
            'Autoriza' => 'Autoriza',
            'UnidadMedidaConversion' => 'Unidad Medida Conversion',
            'CantidadConversion' => 'Cantidad Conversion',
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

        $criteria->compare('IdDevolucion', $this->IdDevolucion);
        $criteria->compare('CodigoVariante', $this->CodigoVariante, true);
        $criteria->compare('CodigoArticulo', $this->CodigoArticulo, true);
        $criteria->compare('NombreArticulo', $this->NombreArticulo, true);
        $criteria->compare('CodigoUnidadMedida', $this->CodigoUnidadMedida, true);
        $criteria->compare('NombreUnidadMedida', $this->NombreUnidadMedida, true);
        $criteria->compare('Cantidad', $this->Cantidad);
        $criteria->compare('ValorUnitario', $this->ValorUnitario);
        $criteria->compare('ValorBruto', $this->ValorBruto);
        $criteria->compare('Impoconsumo', $this->Impoconsumo);
        $criteria->compare('ValorImpoconsumo', $this->ValorImpoconsumo);
        $criteria->compare('Iva', $this->Iva, true);
        $criteria->compare('ValorIva', $this->ValorIva);
        $criteria->compare('ValorTotalProducto', $this->ValorTotalProducto);
        $criteria->compare('Autoriza', $this->Autoriza);
        $criteria->compare('UnidadMedidaConversion', $this->UnidadMedidaConversion);
        $criteria->compare('CantidadConversion', $this->CantidadConversion);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Descripciondevolucion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
