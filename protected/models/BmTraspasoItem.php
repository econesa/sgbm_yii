<?php

/**
 * This is the model class for table "bm_traspaso_item".
 *
 * The followings are the available columns in table 'bm_traspaso_item':
 * @property integer $id
 * @property integer $traspaso_id
 * @property integer $bienmueble_id
 * @property integer $mov_origen_id
 * @property integer $mov_destino_id
 */
class BmTraspasoItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BmTraspasoItem the static model class
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
		return 'bm_traspaso_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('traspaso_id, bienmueble_id', 'required'),
			array('traspaso_id, bienmueble_id, mov_origen_id, mov_destino_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, traspaso_id, bienmueble_id, mov_origen_id, mov_destino_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'bienmueble' => array(self::BELONGS_TO, 'Bienmueble', 'bienmueble_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'traspaso_id' => 'Traspaso',
			'bienmueble_id' => 'Bienmueble',
			'mov_origen_id' => 'Mov Origen',
			'mov_destino_id' => 'Mov Destino',
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
		$criteria->compare('traspaso_id',$this->traspaso_id);
		$criteria->compare('bienmueble_id',$this->bienmueble_id);
		$criteria->compare('mov_origen_id',$this->mov_origen_id);
		$criteria->compare('mov_destino_id',$this->mov_destino_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}