<?php

/**
 * This is the model class for table "dependencia".
 *
 * The followings are the available columns in table 'dependencia':
 * @property integer $id
 * @property string $cod
 * @property integer $sede_id
 * @property integer $u_adm_id
 * @property string $descripcion
 * @property string $desc_corta
 */
class Dependencia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Dependencia the static model class
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
		return 'dependencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cod, sede_id, descripcion, desc_corta', 'required'),
			array('sede_id, u_adm_id', 'numerical', 'integerOnly'=>true),
			array('cod', 'length', 'max'=>8),
			array('descripcion', 'length', 'max'=>120),
			array('desc_corta', 'length', 'max'=>55),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cod, sede_id, u_adm_id, descripcion, desc_corta', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'sede' => array(self::BELONGS_TO, 'Sede', 'sede_id'),
			'u_adm' => array(self::BELONGS_TO, 'Dependencia', 'u_adm_id'),
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
			'sede_id' => 'Sede',
			'u_adm_id' => 'U Adm',
			'descripcion' => 'Descripcion',
			'desc_corta' => 'Desc Corta',
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
		$criteria->compare('sede_id',$this->sede_id);
		$criteria->compare('u_adm_id',$this->u_adm_id);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('desc_corta',$this->desc_corta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/* Buscar el bien con codigo y dependencia indicados, si existe.
	 * @return .
	 */
	public function getInfo( $dp_id )
	{	
		$conection = Yii::app()->db;
		$data = $conection->createCommand()
			->select('dp.descripcion as dp, s.direccion_corta, s.telefono, serv.descripcion as servicio')
			->from('dependencia dp')
		    ->join('sede s', 'dp.sede_id = s.id')
		    ->join('servicio serv', 's.servicio_id = serv.id')
			->where('dp.id = '.$dp_id) 
		    ->queryRow();
			//->text;
		return $data;
	}
}