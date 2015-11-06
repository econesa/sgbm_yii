<?php

/**
 * This is the model class for table "bm_movimiento".
 *
 * The followings are the available columns in table 'bm_movimiento':
 * @property integer $id
 * @property integer $bienmueble_id
 * @property integer $dependencia_id
 * @property integer $concepto_id
 * @property string $fecha
 */
class BmMovimiento extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BmMovimiento the static model class
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
		return 'bm_movimiento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bienmueble_id, dependencia_id, concepto_id, fecha', 'required'),
			array('bienmueble_id, dependencia_id, concepto_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, bienmueble_id, dependencia_id, concepto_id, fecha', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'bienmueble' => array(self::BELONGS_TO, 'Bienmueble', 'bienmueble_id'),
			'dependencia' => array(self::BELONGS_TO, 'Dependencia', 'dependencia_id'),
			'concepto' => array(self::BELONGS_TO, 'Concepto', 'concepto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bienmueble_id' => 'Bienmueble',
			'dependencia_id' => 'Dependencia',
			'concepto_id' => 'Concepto',
			'fecha' => 'Fecha',
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
		$criteria->compare('bienmueble_id',$this->bienmueble_id);
		$criteria->compare('dependencia_id',$this->dependencia_id);
		$criteria->compare('concepto_id',$this->concepto_id);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}