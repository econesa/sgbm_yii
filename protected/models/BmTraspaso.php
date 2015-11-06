<?php

/**
 * This is the model class for table "bm_traspaso".
 *
 * The followings are the available columns in table 'bm_traspaso':
 * @property integer $id
 * @property integer $sede_id
 * @property integer $emisor_id
 * @property integer $receptor_id
 * @property integer $status_id
 * @property integer $cantidad_total
 * @property double $total
 * @property string $fecha
 * @property string $observaciones
 */
class BmTraspaso extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BmTraspaso the static model class
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
		return 'bm_traspaso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('dependencia_id, emisor_id, receptor_id, status_id, fecha', 'required', 'on'=>'update'),
			array('cantidad_total', 'required', 'on'=>'update', 'message'=>'Debe adscribir al menos un bien'),
			array('dependencia_id, emisor_id, receptor_id, status_id, cantidad_total', 'numerical', 'integerOnly'=>true),
			array('total', 'numerical'),
			array('observaciones', 'length', 'max'=>70),
			// The following rule is used by search().
			array('dependencia_id, emisor_id, receptor_id, status_id, fecha, observaciones', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'dependencia' => array(self::BELONGS_TO, 'Dependencia', 'dependencia_id'),
			'emisor' => array(self::BELONGS_TO, 'Responsable', 'emisor_id'),
			'receptor' => array(self::BELONGS_TO, 'Responsable', 'receptor_id'),
			'status' => array(self::BELONGS_TO, 'BmTraspasoStatus', 'status_id'),
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
			'emisor_id' => 'Emisor',
			'receptor_id' => 'Receptor',
			'status_id' => 'Status',
			'cantidad_total' => 'Cantidad Total',
			'total' => 'Total',
			'fecha' => 'Fecha',
			'observaciones' => 'Observaciones',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('dependencia_id',$this->sede_id);
		$criteria->compare('emisor_id',$this->emisor_id);
		$criteria->compare('receptor_id',$this->receptor_id);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getTotal( $traspaso_id )
	{		
        $conection = Yii::app()->db;
		$data = $conection->createCommand()
			->select('SUM(bm.cantidad) as cantidad_total, SUM(bm.valor_unitario) as total')
		    ->from('bm_traspaso_item ti')
		    ->join('bienmueble bm', 'ti.bienmueble_id=bm.id')
		    ->where('ti.traspaso_id=:tid', array(':tid'=>$traspaso_id))
		    ->group('ti.traspaso_id')
		    ->queryRow();
		return $data;
    }

	public function getDataPDF( $model )
	{	
		date_default_timezone_set('America/Caracas');
		$meridiano = array('AM'=>'a.m.','PM'=>'p.m.');
		$dias = array(1=>'Uno',2=>'Dos',3=>'Tres',4=>'Cuatro',5=>'Cinco',6=>'Seis',7=>'Siete',8=>'Ocho',9=>'Nueve',10=>'Diez',
			11=>'Once',12=>'Doce',13=>'Trece',14=>'Catorce',15=>'Quince',16=>'Dieciseis',17=>'Diecisiete',18=>'Dieciocho',
			19=>'Diecinueve',20=>'Veinte',21=>'Veintiuno',22=>'Veintidos',23=>'Veintitres',24=>'Veinticuatro',
			25=>'Veinticinco',26=>'Veintiseis',27=>'Veintisiete',28=>'Veintiocho',29=>'Veintinueve',30=>'Treinta',31=>'Treinta y Uno');
		
			
        $data=array();
        $data['fecha_numerica'] = date('Y-m-d H:i:s');
		$fd = preg_split("/[\s-:]+/", $model->fecha);
		
		$mes = Mes::model()->findByPk($fd[1]);
		$data['fecha']=$dias[(int)$fd[2]]." ($fd[2]) de ".ucfirst($mes->descripcion)." de $fd[0]";
		
		if ($fd[3] == 12) {
			$hh = $fd[3];
			$tt = 'm.';
		} else {
			if ($fd[3] > 12) {
				$hh = $fd[3]-12;
				$tt = 'p.m.';
			} else {
				$hh = $fd[3];
				$tt = 'a.m.';
			}
		}
		$data['hora']		=$hh.':'.$fd[4].' '.$tt;
		$data['sede']		=$model->dependencia->sede->descripcion;
		$data['direccion']	=$model->dependencia->sede->direccion_larga;
		$data['emisor']		=$model->emisor->persona->pdata->nombre;
		$data['emisor_ttl']	=$model->emisor->persona->pdata->profesion->cod;
		$data['emisor_ci']	=number_format( $model->emisor->persona->pdata->cedula, 0, ',', '.' );
		$data['emisor_cargo']	=$model->emisor->persona->cargo->descripcion;
		$data['dp_emisora']		=$model->emisor->persona->dependencia->descripcion;
		if ($model->emisor->dependencia->genero_id == 1)
			$data['dp_emisora_g'] = 'en el';
		else
			$data['dp_emisora_g'] = 'en la';
		
		$data['receptor']		=$model->receptor->persona->pdata->nombre;
		$data['receptor_ttl']	=$model->receptor->persona->pdata->profesion->cod;
		$data['receptor_ci']	=number_format( $model->receptor->persona->pdata->cedula, 0, ',', '.' );
		$data['receptor_cargo']	=$model->receptor->persona->cargo->descripcion;
		$data['dp_receptora']	=$model->receptor->persona->dependencia->descripcion;
		if ($model->receptor->dependencia->genero_id == 1)
			$data['dp_receptora_g'] = 'en el';
		else
			$data['dp_receptora_g'] = 'en la';
		return $data;
    }
}