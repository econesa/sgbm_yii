<?php

/**
 * This is the model class for table "persona_data".
 *
 * The followings are the available columns in table 'persona_data':
 * @property integer $id
 * @property integer $cedula
 * @property string $nombre
 * @property integer $profesion_id
 * @property integer $sexo_id
 * @property string $f_creacion
 * @property string $f_cambios
 */
class PersonaData extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersonaData the static model class
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
		return 'persona_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('cedula, nombre, sexo_id, profesion_id', 'required'),
			array('cedula', 'unique'),
			array('sexo_id, profesion_id', 'numerical', 'integerOnly'=>true),
			array('cedula', 'numerical', 'integerOnly'=>true, 'message'=>'Entrada no válida (e.g. 22123567)'),
			array('nombre', 'length', 'max'=>128),
			array('f_creacion, f_cambios', 'safe'),
			array('cedula, nombre, profesion_id, sexo_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'profesion' => array(self::BELONGS_TO, 'profesion', 'profesion_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cedula' => 'Cedula',
			'nombre' => 'Nombre',
			'sexo_id' => 'Sexo',
			'profesion_id' => 'Profesion',
			'f_creacion' => 'F Creacion',
			'f_cambios' => 'F Cambios',
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
		$criteria->compare('cedula',$this->cedula);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('profesion_id',$this->profesion_id);
		$criteria->compare('f_creacion',$this->f_creacion,true);
		$criteria->compare('f_cambios',$this->f_cambios,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}