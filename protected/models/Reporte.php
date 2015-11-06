<?php

class Reporte extends CFormModel
{
	var $mes_id;
	var $anho;
	var $responsable_id;
	var $dependencia_id;
 
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('mes_id, anho', 'required', 'message'=>'{attribute} no puede ser vacio'),
			array('mes_id, anho', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			//array('dependencia_id, responsable_id, fecha_emision', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
	        //'dependencia' => array(self::BELONGS_TO, 'Dependencia', 'dependencia_id'),
	        //'responsable' => array(self::BELONGS_TO, 'CargoPersona', 'responsable_id'),
	    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mes_id' => 'Mes',
			'anho' => 'Año',
			'fecha_emision' => 'Fecha Emision',
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
		//$criteria->compare('dependencia_id',$this->dependencia_id);
		//$criteria->compare('responsable_id',$this->responsable_id);
		$criteria->compare('fecha_emision',$this->fecha_emision,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
