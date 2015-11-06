<?php

class BmFiltro extends CFormModel
{
	var $codigo;
	var $dependencia_id;
	var $clasificacion_id;
	var $tipo_id;
	var $descripcion;
	var $status_id;
	var $anho_id;
	var $factura_nro;
	
	//var $f_incorporacion;
 
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('codigo, dependencia_id, clasificacion_id, tipo_id, status_id', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>500),
			array('dependencia_id, clasificacion_id, tipo_id, status_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
	        'dependencia' => array(self::BELONGS_TO, 'Dependencia', 'dependencia_id'),
	    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'dependencia_id' => 'Dependencia',
			'codigo' => 'Nro. ID',
			'clasificacion_id' => 'Clasificación',
			'dependencia_id' => 'Dependencia',
			'tipo_id' => 'Tipo',
			'descripcion' => 'Descripción',
			'status_id' => 'Status',
			'anho_id' => 'Año de Incorporación',
			'factura_nro' => 'Nro. de Factura',
			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;
		//$criteria->join  = 	'JOIN factura fact ON (fact.id = t.factura_id) '.
		//					'JOIN bm_movimiento mov ON (mov.id = t.ult_mov_id)';
		//$criteria->compare('dependencia_id',$this->dependencia_id);
		if (strlen($this->codigo) == 6) {
			$criteria->compare('codigo', $this->codigo);
		}
		else {
			$criteria->compare('clasificacion_id', $this->clasificacion_id);
			$criteria->compare('tipo_id', $this->tipo_id);
			$criteria->compare('status_id', $this->status_id);
			$criteria->compare('anho_id', $this->anho_id);
		//	if (isset($this->factura_nro))
		//		$criteria->compare('fact.numero', $this->factura_nro);
			$criteria->compare('descripcion', $this->descripcion, true, 'LIKE');
		//	$criteria->compare('mov.dependencia_id',$this->dependencia_id,true);
		}
		return new CActiveDataProvider('Bienmueble', array(
			'criteria'=>$criteria,
		));
	}

}
