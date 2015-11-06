<?php

/**
 * This is the model class for table "fbm4".
 *
 * The followings are the available columns in table 'fbm4':
 * @property integer $id
 * @property integer $dependencia_id
 * @property integer $mes_id
 * @property integer $anho
 * @property double $existencia_final
 */
class Fbm4 extends CActiveRecord
{
	public $cod = 4;
	public $descripcion = "Resumen de la Cuenta de Bienes (Formulario B.M.4)";
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Fbm4 the static model class
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
		return 'fbm4';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dependencia_id, mes_id, anho', 'required'),
			array('dependencia_id, mes_id, anho, existencia_final', 'numerical', 'integerOnly'=>true),
			array('existencia_final', 'numerical'),
			array('id, dependencia_id, mes_id, anho, existencia_final', 'safe', 'on'=>'search'),
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
			'dependencia_id' => 'Dependencia',
			'mes_id' => 'Mes',
			'anho' => 'Año',
			'existencia_final' => 'Existencia Final',
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
		$criteria->compare('dependencia_id',$this->dependencia_id);
		$criteria->compare('mes_id',$this->mes_id);
		$criteria->compare('anho',$this->anho);
		$criteria->compare('existencia_final',$this->existencia_final);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getInfo()
	{
		// 1er dia del mes siguiente
		$dp_id = $this->dependencia_id;
		$anho = $this->anho;
		$mes1 = $this->mes_id;
		
		$timeStamp = mktime(0,0,0,$mes1,1,$anho);
		$finicio     = date('Y-m-d',$timeStamp);
		
		$mes2  = ($mes1+1)%12;
		$anho = $anho + (int)(($mes2+1)/12);
		$timeStamp = mktime(0,0,0,$mes2,1,$anho);
		$ffin     = date('Y-m-d',$timeStamp);
		
		$conection = Yii::app()->db;
        $data = $conection->createCommand()
			->select(	'SUM(CASE WHEN mov.concepto_id<20 THEN bm.valor_unitario ELSE 0 END) AS incorporacion, '.
			 			'SUM(CASE WHEN mov.concepto_id>=20 AND mov.concepto_id<>29 THEN bm.valor_unitario ELSE 0 END) AS desincorporacion, '.
						'SUM(CASE WHEN mov.concepto_id=29 THEN bm.valor_unitario ELSE 0 END) AS desin60, '.
						'f4.existencia_final as existencia_anterior')
			->from(	'bm_movimiento mov')
			->join( 'concepto co', 'mov.concepto_id = co.id')
		    ->join( 'bienmueble bm', 'mov.bienmueble_id = bm.id')
			->join( 'fbm4 f4', 'mov.dependencia_id = f4.dependencia_id')
			->where('mov.fecha > "'.$finicio.'" AND mov.fecha <= "'.$ffin.'" AND mov.dependencia_id='.$dp_id.' AND f4.mes_id='.($mes1-1).' AND f4.anho='.$this->anho)
				//, array(':dp_id'=>$dp_id) )
			//->text;
		    //print_r($data);exit;
		   	->queryRow();
		return $data;
		/*
		*/
    }
	
	public function getData()
	{
		$info = $this->getInfo();
		$data = array();
		$data['existencia_anterior'] = number_format($info['existencia_anterior'], 2, ',', '.');
		$data['incorporacion'] = number_format($info['incorporacion'], 2, ',', '.');
		$data['desin_t'] = number_format($info['desincorporacion'], 2, ',', '.');
		$data['desin_f'] = number_format($info['desin60'], 2, ',', '.');
		$info['existencia_final'] = $info['existencia_anterior'] + $info['incorporacion'] - $info['desincorporacion'] - $info['desin60'];
		$data['existencia_final'] = number_format($info['existencia_final'], 2, ',', '.');
		$info['total'] = $info['existencia_final'] + $info['desincorporacion'] + $info['desin60'];
		$info['total2'] = $info['existencia_anterior'] + $info['incorporacion'];
		$data['total'] = number_format($info['total'], 2, ',', '.');
		$data['total2'] = number_format($info['total2'], 2, ',', '.');
		
		return $data;
	}
	
}