<?php

/**
 * This is the model class for table "cargo".
 *
 * The followings are the available columns in table 'cargo':
 * @property integer $id
 * @property integer $cod
 * @property string $descripcion
 * @property string $desc_f
 */
class Cargo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cargo the static model class
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
		return 'cargo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('descripcion, desc_f', 'required'),
			array('descripcion, desc_f', 'length', 'max'=>50),
			array('cod, descripcion', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
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
			'cod' => 'Codigo',
			'descripcion' => 'Descripcion',
			'desc_f' => 'Descripcion (femenino)',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('cod',$this->cod);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('desc_f',$this->desc_f,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}