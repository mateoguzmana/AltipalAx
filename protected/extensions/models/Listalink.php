<?php

/**
 * This is the model class for table "listalink".
 *
 * The followings are the available columns in table 'listalink':
 * @property integer $IdListaLink
 * @property integer $IdListaMenu
 * @property string $Descripcion
 * @property integer $Orden
 * @property string $Controlador
 */
class Listalink extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'listalink';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IdListaMenu, Descripcion, Orden, Controlador', 'required'),
			array('IdListaMenu, Orden', 'numerical', 'integerOnly'=>true),
			array('Descripcion, Controlador', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('IdListaLink, IdListaMenu, Descripcion, Orden, Controlador', 'safe', 'on'=>'search'),
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
			'IdListaLink' => 'Id Lista Link',
			'IdListaMenu' => 'Id Lista Menu',
			'Descripcion' => 'Descripcion',
			'Orden' => 'Orden',
			'Controlador' => 'Controlador',
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

		$criteria->compare('IdListaLink',$this->IdListaLink);
		$criteria->compare('IdListaMenu',$this->IdListaMenu);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('Orden',$this->Orden);
		$criteria->compare('Controlador',$this->Controlador,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Listalink the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
         public function findPerfil($controlador,$idPerfil)
        {
            $sql = "SELECT a.descripcion FROM `listalink` AS l INNER JOIN configuracionperfil AS c ON l.IdListaLink = c.IdListaLink INNER JOIN accion AS a ON a.IdAccion=c.IdAccion WHERE l.Controlador='".$controlador."' AND c.IdPerfil='".$idPerfil."' ";
            return Yii::app()->db->createCommand($sql)->queryAll();            
        }
}
