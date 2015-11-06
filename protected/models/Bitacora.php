<?php

/**
 * This is the model class for table "system_bita".
 *
 * The followings are the available columns in table 'system_bita':
 * @property integer $id
 * @property string $fecha
 * @property integer $operacion_id
 * @property integer $objeto_id
 * @property integer $usuario_id
 * @property string $observacion
 */
class Bitacora extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bitacora the static model class
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
		return 'system_bita';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, operacion_id, objeto_id, usuario_id, observacion', 'required'),
			array('operacion_id, objeto_id, usuario_id', 'numerical', 'integerOnly'=>true),
			array('observacion', 'length', 'max'=>120),
			array('fecha, operacion_id, objeto_id, usuario_id, observacion', 'safe', 'on'=>'search'),
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
			'fecha' => 'Fecha',
			'operacion_id' => 'Operacion',
			'objeto_id' => 'Objeto',
			'usuario_id' => 'Usuario',
			'observaciones' => 'Observaciones',
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
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('operacion_id',$this->operacion_id);
		$criteria->compare('objeto_id',$this->objeto_id);
		$criteria->compare('usuario_id',$this->usuario_id);
		$criteria->compare('observacion',$this->observaciones,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
