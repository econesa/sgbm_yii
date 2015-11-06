<?php

/**
 * This is the model class for table "fbm3_bien".
 *
 * The followings are the available columns in table 'fbm3_bien':
 * @property integer $id
 * @property integer $fbm_id
 * @property integer $bienmueble_id
 * @property integer $movimiento_id
 */
class Fbm3Bien extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Fbm3Bien the static model class
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
		return 'fbm3_bien';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fbm3_id, bienmueble_id', 'required'),
			array('fbm3_id, bienmueble_id, movimiento_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fbm3_id, bienmueble_id, movimiento_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'bienmueble' => array(self::BELONGS_TO, 'Bienmueble', 'bienmueble_id'),
			'movimiento' => array(self::BELONGS_TO, 'BmMovimiento', 'movimiento_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fbm3_id' => 'Fbm',
			'bienmueble_id' => 'Bienmueble',
			'movimiento_id' => 'Movimiento',
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
		$criteria->compare('fbm_id',$this->fbm_id);
		$criteria->compare('bienmueble_id',$this->bienmueble_id);
		$criteria->compare('movimiento_id',$this->movimiento_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}