<?php

/**
 * This is the model class for table "fbm3".
 *
 * The followings are the available columns in table 'fbm3':
 * @property integer $id
 * @property string $comprobante
 * @property integer $dependencia_id
 * @property integer $observador_id
 * @property integer $responsable_id
 * @property integer $cantidad
 * @property double $valor_total
 * @property string $observaciones
 * @property string $fecha
 */
class Fbm3 extends CActiveRecord
{
	public $descripcion = "RELACION DE BIENES MUEBLES FALTANTES (Formulario B.M.3)";
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Fbm3 the static model class
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
		return 'fbm3';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('comprobante, dependencia_id, responsable_id, fecha', 'required'),
			array('dependencia_id, observador_id, responsable_id, cantidad', 'numerical', 'integerOnly'=>true),
			array('valor_total', 'numerical'),
			array('comprobante', 'length', 'max'=>15),
			array('observaciones', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('comprobante, dependencia_id, observador_id, responsable_id, observaciones, fecha', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'dependencia' => array(self::BELONGS_TO, 'Dependencia', 'dependencia_id'),
			'responsable' => array(self::BELONGS_TO, 'Responsable', 'responsable_id'),
			'observador' => array(self::BELONGS_TO, 'Persona', 'observador_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'comprobante' => 'Comprobante',
			'dependencia_id' => 'Dependencia',
			'observador_id' => 'Faltantes Determinados por',
			'responsable_id' => 'Responsable',
			'cantidad' => 'Cantidad',
			'valor_total' => 'Valor Total',
			'observaciones' => 'Observaciones',
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
		$criteria->compare('comprobante',$this->comprobante,true);
		$criteria->compare('dependencia_id',$this->dependencia_id);
		$criteria->compare('observador_id',$this->observador_id);
		$criteria->compare('responsable_id',$this->responsable_id);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('valor_total',$this->valor_total);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getDataPDF( $model )
	{	
		$dias=array(1=>'Uno',2=>'Dos',3=>'Tres',4=>'Cuatro',5=>'Cinco',6=>'Seis',7=>'Siete',8=>'Ocho',9=>'Nueve',
			10=>'Diez',11=>'Once',12=>'Doce',13=>'Trece',14=>'Catorce',15=>'Quince',16=>'Dieciseis',
			17=>'Diecisiete',18=>'Dieciocho',19=>'Diecinueve',20=>'Veinte',21=>'Veintiuno', 22=>'Veintidos',
			23=>'Veintitres',24=>'Veinticuatro',25=>'Veinticinco',26=>'Veintiseis',27=>'Veintisiete',
			28=>'Veintiocho',29=>'Veintinueve',30=>'Treinta',31=>'Treinta y Uno');
		$meridiano=array('AM'=>'a.m.','PM'=>'p.m.');
		
		date_default_timezone_set('America/Caracas');
        $data=array();
		$data['fecha']		=$dias[strftime("%d")].strftime(" (%d) de ").ucfirst(strftime("%B")).strftime(" de %Y");
		$data['hora']		=strftime("%I:%M ").$meridiano[strftime("%p")];
		$data['dependencia']=$model->dependencia->descripcion;
		$data['direccion']	=$model->dependencia->sede->direccion_larga;
		$data['responsable']=$model->responsable->persona->pdata->nombre;
		return $data;
    }

	public function getTotal()
	{	
		$conection = Yii::app()->db;
		$data = $conection->createCommand()
			->select('SUM(bm.cantidad) as cantidad, SUM(bm.valor_unitario) as valor_total')
			->from('fbm3_bien bf')
			->join('bienmueble bm','bf.bienmueble_id = bm.id')
		    ->where('bf.fbm3_id = '.$this->id) 
		    ->queryRow();
			//->text;
		return $data;
	}
}