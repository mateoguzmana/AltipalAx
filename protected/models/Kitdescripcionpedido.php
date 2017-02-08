<?php

/**
 * This is the model class for table "kitdescripcionpedido".
 *
 * The followings are the available columns in table 'kitdescripcionpedido':
 * @property integer $Id
 * @property integer $IdDescripcionPedido
 * @property string $CodigoListaMateriales
 * @property string $CodigoArticuloComponente
 * @property string $Nombre
 * @property string $CodigoUnidadMedida
 * @property string $CodigoTipo
 * @property string $Fijo
 * @property string $Opcional
 * @property integer $Cantidad
 * @property string $PrecioVentaBaseVariante
 */
class Kitdescripcionpedido extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function getDbConnection() {
        return self::setConexion();
    }

    public function tableName() {
        return 'kitdescripcionpedido';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('IdDescripcionPedido, CodigoListaMateriales, CodigoArticuloComponente, Nombre, CodigoUnidadMedida, CodigoTipo, PrecioVentaBaseVariante', 'required'),
            array('IdDescripcionPedido, Cantidad', 'numerical', 'integerOnly' => true),
            array('CodigoListaMateriales, CodigoArticuloComponente, CodigoUnidadMedida, CodigoTipo', 'length', 'max' => 25),
            array('Nombre', 'length', 'max' => 75),
            array('Fijo, Opcional', 'length', 'max' => 5),
            array('PrecioVentaBaseVariante', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id, IdDescripcionPedido, CodigoListaMateriales, CodigoArticuloComponente, Nombre, CodigoUnidadMedida, CodigoTipo, Fijo, Opcional, Cantidad, PrecioVentaBaseVariante', 'safe', 'on' => 'search'),
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
            'IdDescripcionPedido' => 'Id Descripcion Pedido',
            'CodigoListaMateriales' => 'Codigo Lista Materiales',
            'CodigoArticuloComponente' => 'Codigo Articulo Componente',
            'Nombre' => 'Nombre',
            'CodigoUnidadMedida' => 'Codigo Unidad Medida',
            'CodigoTipo' => 'Codigo Tipo',
            'Fijo' => 'Fijo',
            'Opcional' => 'Opcional',
            'Cantidad' => 'Cantidad',
            'PrecioVentaBaseVariante' => 'Precio Venta Base Variante',
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

        $criteria->compare('Id', $this->Id);
        $criteria->compare('IdDescripcionPedido', $this->IdDescripcionPedido);
        $criteria->compare('CodigoListaMateriales', $this->CodigoListaMateriales, true);
        $criteria->compare('CodigoArticuloComponente', $this->CodigoArticuloComponente, true);
        $criteria->compare('Nombre', $this->Nombre, true);
        $criteria->compare('CodigoUnidadMedida', $this->CodigoUnidadMedida, true);
        $criteria->compare('CodigoTipo', $this->CodigoTipo, true);
        $criteria->compare('Fijo', $this->Fijo, true);
        $criteria->compare('Opcional', $this->Opcional, true);
        $criteria->compare('Cantidad', $this->Cantidad);
        $criteria->compare('PrecioVentaBaseVariante', $this->PrecioVentaBaseVariante, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Kitdescripcionpedido the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
