<?php

/**
 * This is the model class for table "sede".
 *
 * The followings are the available columns in table 'sede':
 * @property integer $id
 * @property string $cod
 * @property string $rif
 * @property integer $servicio_id
 * @property integer $localidad_id
 * @property string $telefono
 * @property string $direccion_corta
 * @property string $direccion_larga
 * @property string $descripcion
 * @property string $entidad_propietaria
 */
class Sede extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sede the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sede';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cod, rif, servicio_id, localidad_id, telefono, direccion_corta, direccion_larga, descripcion, entidad_propietaria', 'required'),
			array('servicio_id, localidad_id', 'numerical', 'integerOnly'=>true),
			array('cod', 'length', 'max'=>2),
			array('rif', 'length', 'max'=>15),
			array('telefono', 'length', 'max'=>30),
			array('direccion_corta, descripcion', 'length', 'max'=>60),
			array('direccion_larga', 'length', 'max'=>100),
			array('entidad_propietaria', 'length', 'max'=>80),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cod, rif, servicio_id, localidad_id, telefono, direccion_corta, direccion_larga, descripcion, entidad_propietaria', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'cod' => 'Cod',
			'rif' => 'Rif',
			'servicio_id' => 'Servicio',
			'localidad_id' => 'Localidad',
			'telefono' => 'Telefono',
			'direccion_corta' => 'Direccion Corta',
			'direccion_larga' => 'Direccion Larga',
			'descripcion' => 'Descripcion',
			'entidad_propietaria' => 'Entidad Propietaria',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('cod',$this->cod,true);
		$criteria->compare('rif',$this->rif,true);
		$criteria->compare('servicio_id',$this->servicio_id);
		$criteria->compare('localidad_id',$this->localidad_id);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('direccion_corta',$this->direccion_corta,true);
		$criteria->compare('direccion_larga',$this->direccion_larga,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('entidad_propietaria',$this->entidad_propietaria,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}