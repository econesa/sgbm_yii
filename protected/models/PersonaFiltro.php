<?php
/* @author Elisa Conesa <econesa@gmail.com> */
class PersonaFiltro extends CFormModel
{
	var $sexo_id;
 
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('sexo_id', 'numerical', 'integerOnly'=>true),
			array('sexo_id', 'safe', 'on'=>'search'),
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
			'sexo_id' => 'Sexo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->join  = 	'JOIN persona_data pd ON (t.pdata_id = pd.id)';
		//$criteria->compare('dependencia_id',$this->dependencia_id);
		$criteria->compare('pd.sexo_id', $this->sexo_id, true);

		return new CActiveDataProvider('Persona', array(
			'pagination'=>array('pageSize'=>6,),
			'criteria'=>$criteria,
		));
	}

}
