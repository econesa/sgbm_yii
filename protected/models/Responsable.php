<?php

/**
 * This is the model class for table "responsable".
 *
 * The followings are the available columns in table 'responsable':
 * @property integer $id
 * @property integer $dependencia_id
 * @property integer $persona_id
 * @property string $fecha
 */
class Responsable extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Responsable the static model class
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
		return 'responsable';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dependencia_id, persona_id, status_id, fecha', 'required'),
			array('dependencia_id, persona_id, status_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, dependencia_id, persona_id, fecha', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'persona' => array(self::BELONGS_TO, 'Persona', 'persona_id'),
			'dependencia' => array(self::BELONGS_TO, 'Dependencia', 'dependencia_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'dependencia_id' => 'Dependencia',
			'persona_id' => 'Persona',
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
		$criteria->compare('dependencia_id',$this->dependencia_id);
		$criteria->compare('persona_id',$this->persona_id);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function findByDp( $dp_id, $flag = 0)
	{
		$conection = Yii::app()->db;
		
		if ($flag == 0) {
			$data = $conection->createCommand()
				->select('t.id, CONCAT(pd.nombre, " - ", dp.descripcion) as descripcion')
			    ->from($this->tableName().' t')
			    ->join('persona p', 't.persona_id = p.id')
				->join('persona_data pd', 'p.pdata_id = pd.id')
				->join('dependencia dp', 't.dependencia_id = dp.id')
			    ->where('t.dependencia_id = '.$dp_id.' AND t.status_id=1')
			    ->queryRow();
		}
		else {
			$user_id = Yii::app()->user->getId();
			$user = Usuario::model()->findbyPk($user_id);
			$sede_id = $user->dependencia->sede_id;
			
			$data = $conection->createCommand()
				->select('t.id, CONCAT(pd.nombre, " - ", dp.descripcion) as descripcion')
			    ->from($this->tableName().' t')
			    ->join('persona p', 't.persona_id = p.id')
				->join('persona_data pd', 'p.pdata_id = pd.id')
				->join('dependencia dp', 't.dependencia_id = dp.id')
			    ->where('t.dependencia_id <>'.$dp_id.' AND dp.sede_id = '.$sede_id.' AND t.status_id=1')
			    ->queryAll();
		}
		//->text;
		//print_r($data);exit;
		return $data;
    }
}