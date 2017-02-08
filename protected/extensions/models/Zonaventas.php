<?php

/**
 * This is the model class for table "zonaventas".
 *
 * The followings are the available columns in table 'zonaventas':
 * @property string $CodZonaVentas
 * @property string $CodAsesor
 * @property string $NombreZonadeVentas
 * @property string $CodigoGrupoVentas
 * @property string $Transferencia
 *
 * The followings are the available model relations:
 * @property Clienteruta[] $clienterutas
 * @property Cupocredito[] $cupocreditos
 * @property Devoluciones[] $devoluciones
 * @property Norecaudos[] $norecaudoses
 * @property Restriccioncuentaproveedor[] $restriccioncuentaproveedors
 * @property Transaccionesabiertas[] $transaccionesabiertases
 * @property Gruposventas $codigoGrupoVentas
 */
class Zonaventas extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'zonaventas';
    }

    /* public function getDbConnection()
      {

      return self::setConexion();
      } */

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('CodZonaVentas, CodAsesor, CodigoGrupoVentas, Transferencia', 'required'),
            array('CodZonaVentas, CodAsesor', 'length', 'max' => 15),
            array('NombreZonadeVentas', 'length', 'max' => 180),
            array('CodigoGrupoVentas', 'length', 'max' => 25),
            array('Transferencia', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('CodZonaVentas, CodAsesor, NombreZonadeVentas, CodigoGrupoVentas, Transferencia', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'clienterutas' => array(self::HAS_MANY, 'Clienteruta', 'CodZonaVentas'),
            'cupocreditos' => array(self::HAS_MANY, 'Cupocredito', 'ZonaVenta'),
            'devoluciones' => array(self::HAS_MANY, 'Devoluciones', 'CodZonaVentas'),
            'norecaudoses' => array(self::HAS_MANY, 'Norecaudos', 'CodZonaVentas'),
            'restriccioncuentaproveedors' => array(self::HAS_MANY, 'Restriccioncuentaproveedor', 'CodZonaVentas'),
            'transaccionesabiertases' => array(self::HAS_MANY, 'Transaccionesabiertas', 'CodZonadeVentas'),
            'codigoGrupoVentas' => array(self::BELONGS_TO, 'Gruposventas', 'CodigoGrupoVentas'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'CodZonaVentas' => 'Cod Zona Ventas',
            'CodAsesor' => 'Cod Asesor',
            'NombreZonadeVentas' => 'Nombre Zonade Ventas',
            'CodigoGrupoVentas' => 'Codigo Grupo Ventas',
            'Transferencia' => 'Transferencia',
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

        $criteria->compare('CodZonaVentas', $this->CodZonaVentas, true);
        $criteria->compare('CodAsesor', $this->CodAsesor, true);
        $criteria->compare('NombreZonadeVentas', $this->NombreZonadeVentas, true);
        $criteria->compare('CodigoGrupoVentas', $this->CodigoGrupoVentas, true);
        $criteria->compare('Transferencia', $this->Transferencia, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Zonaventas the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
