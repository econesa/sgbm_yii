<?php

/**
 * This is the model class for table "persona".
 *
 * The followings are the available columns in table 'persona':
 * @property integer $id
 * @property integer $pdata_id
 * @property integer $cargo_id
 * @property integer $dependencia_id
 * @property string $fecha
 */
class Persona extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Persona the static model class
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
		return 'persona';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('pdata_id, cargo_id, dependencia_id, status_id, fecha', 'required'),
			array('pdata_id, cargo_id, dependencia_id', 'numerical', 'integerOnly'=>true),
			array('id, pdata_id, cargo_id, dependencia_id, fecha', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'pdata' => array(self::BELONGS_TO, 'PersonaData', 'pdata_id'),
	        'cargo' => array(self::BELONGS_TO, 'Cargo', 'cargo_id'),
	        'dependencia' => array(self::BELONGS_TO, 'Dependencia', 'dependencia_id'),
	        'status' => array(self::BELONGS_TO, 'BmStatus', 'status_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pdata_id' => 'Persona',
			'cargo_id' => 'Cargo',
			'status_id' => 'Status',
			'dependencia_id' => 'Dependencia',
			'fecha' => 'Fecha',
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
		$criteria->compare('pdata_id',$this->pdata_id);
		$criteria->compare('cargo_id',$this->cargo_id);
		$criteria->compare('dependencia_id',$this->dependencia_id);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function listAll()
	{		
        $conection = Yii::app()->db;
		$data = $conection->createCommand()
			->select('p.id, CONCAT(pd.nombre, " - ",dp.descripcion ) as descripcion')
			->from('persona p')
		    ->join('persona_data pd', 'p.pdata_id=pd.id')
			->join('dependencia dp', 'p.dependencia_id=dp.id')
		    ->order('descripcion ASC')
		    ->queryAll();
		return $data;
    }

}
