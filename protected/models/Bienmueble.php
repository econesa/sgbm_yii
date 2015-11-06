<?php

/**
 * This is the model class for table "bienmueble".
 *
 * The followings are the available columns in table 'bienmueble':
 * @property integer $id
 * @property string $codigo
 * @property integer $clasificacion_id
 * @property integer $tipo_id
 * @property string $descripcion
 * @property integer $cantidad
 * @property double $valor_unitario
 * @property double $valor_referencial
 * @property integer $factura_id
 * @property integer $status_id
 * @property string $observaciones
 * @property string $f_incorporacion
 * @property string $f_actualizacion
 * @property integer $actualizado_por
 */
class Bienmueble extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bienmueble the static model class
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
		return 'bienmueble';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('codigo, clasificacion_id, tipo_id, valor_unitario, f_incorporacion', 'required'),
			array('codigo', 'unique'),
			array('clasificacion_id, tipo_id, cantidad, factura_id, status_id, actualizado_por', 'numerical', 'integerOnly'=>true),
			array('valor_unitario, valor_referencial', 'numerical'), //'numberPattern'=>'/^\s*[-+]?[0-9]*\,?[0-9]+([eE][-+]?[0-9]+)?\s*$/'),
			array('codigo', 'length', 'min'=>6, 'max'=>6),
			array('descripcion', 'length', 'max'=>500),
			array('observaciones', 'length', 'max'=>200),
			array('f_actualizacion', 'safe'),
			array('codigo, clasificacion_id, tipo_id, descripcion, factura_id, status_id, f_incorporacion, f_actualizacion', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			//'factura' => array(self::BELONGS_TO, 'Factura', 'factura_id'),
	        'clasificacion' => array(self::BELONGS_TO, 'BmClasificacion', 'clasificacion_id'),
	        'tipo' => array(self::BELONGS_TO, 'BmTipo', 'tipo_id'),
	        'dependencia' => array(self::BELONGS_TO, 'Dependencia', 'dependencia_id'),
			'status' => array(self::BELONGS_TO, 'BmStatus', 'status_id'),
			'factura' => array(self::BELONGS_TO, 'Factura', 'factura_id'),
			'ult_mov' => array(self::BELONGS_TO, 'BmMovimiento', 'ult_mov_id'),
			//'actualizado' => array(self::BELONGS_TO, 'User', 'actualizado_por'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codigo' => 'Nro. ID',
			'clasificacion_id' => 'Clasificacion',
			'tipo_id' => 'Tipo',
			'descripcion' => 'Descripcion',
			'cantidad' => 'Cantidad',
			'valor_unitario' => 'Valor Unitario',
			'valor_referencial' => 'Valor Referencial',
			'factura_id' => 'Factura',
			'status_id' => 'Status',
			'observaciones' => 'Observaciones',
			'f_incorporacion' => 'Fecha de Incorporación',
			'f_actualizacion' => 'Fecha de Actualización',
			'ult_mov_id' => 'Ultimo Movimiento',
			'actualizado_por' => 'Actualizado Por',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->join  = 	'JOIN bm_movimiento mov ON (mov.id = t.ult_mov_id) '.

		$criteria->compare('id',$this->id);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('clasificacion_id',$this->clasificacion_id);
		$criteria->compare('tipo_id',$this->tipo_id);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('factura_id',$this->factura_id);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('f_incorporacion',$this->f_incorporacion,true);
		$criteria->compare('f_actualizacion',$this->f_actualizacion,true);
		$criteria->compare('mov.dependencia_id',$this->ult_mov->dependencia_id,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Buscar el bien con codigo y dependencia indicados, si existe.
	 * @return .
	 */
	public function findByDp( $dp_id, $codigo )
	{	
		$conection = Yii::app()->db;
		$data = $conection->createCommand()
			->select('bm.id, cl.grupo, cl.subgrupo, cl.seccion, bm.codigo, bm.cantidad, bm.descripcion, bm.valor_unitario')
			->from('bienmueble bm')
		    ->join('bm_movimiento m', 'm.bienmueble_id = bm.id')
			->join('bm_clasificacion cl', 'bm.clasificacion_id = cl.id')
		    ->where('bm.codigo = \''.$codigo.'\' AND bm.status_id<>2 AND m.dependencia_id='.$dp_id) 
		    ->queryRow();
			//->text;
		return $data;
	}
	
	/**
	 * Buscar el bien con codigo y dependencia indicados, si existe.
	 * @return .
	 */
	public function getResumen()
	{	
		$conection = Yii::app()->db;
		$data = $conection->createCommand()
			->select('dp.id, dp.descripcion as dependencia, SUM(inv.cantidad) as cantidad_total, SUM(inv.valor_unitario) as valor_total')
			->from('dependencia dp')
			->join( '(	SELECT t2.id, t2.dependencia_id, bm.cantidad, bm.valor_unitario, bm.status_id, t2.fecha
						FROM bm_movimiento t2
						INNER JOIN (
							SELECT bienmueble_id, MAX( fecha ) AS fecha
							FROM bm_movimiento
							GROUP BY bienmueble_id, dependencia_id
						) AS temp ON ( t2.bienmueble_id = temp.bienmueble_id AND t2.fecha = temp.fecha ) 
						LEFT JOIN bienmueble bm ON (t2.bienmueble_id = bm.id)
						WHERE t2.concepto_id<20
					  ) as inv', 'inv.dependencia_id=dp.id' )
			->where('inv.status_id=1')
			->group('inv.dependencia_id') 
		    ->queryAll();
			//->text;
			//print_r($data);exit;
		return $data;
	}
}
