<?php
/**
 * Fbm1 class.
 */

class Fbm2 extends CFormModel
{
	public $cod = 2;
	public $mes_id;
	public $anho;
	public $dependencia_id;
	public $descripcion = "Relación de Movimiento de Bienes (Formulario B.M.2)";

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('mes_id, anho', 'required'),
			array('mes_id, anho', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'mes_id'=>'Mes',
			'anho'=>'Año',
		);
	}
	
	public function getData()
	{
		$data = array();
		$data['items'] = array();
		$data['thd'] = array('Concepto', 'Cantidad', 'Nro. de Identificacion', 'Nombre y Descripcion de los Elementos','Incorporacion Bs.','Desincorporacion Bs.');
		$data['twf'] = array(13, 45,14,130,27,27);
		$data['taf'] = array('C','C','C','C','R','R');
		$data['tdf'] = array('','TOTAL',0,'',0,0);
		$data['tdf'][2] = 0; //cantidad
		$data['tdf'][4] = 0; //incorporacion
		$data['tdf'][5] = 0; //desincorporacion
		
		$items = $this->getMovimientos();
		$i = 0;
			$data['thw'] = array(13, 15, 15, 15, 14, 30, 100, 27, 27);
			$data['ta'] = array('C','C','C','C','C','C','L','R','R');
			
			foreach($items as $item){
				$data['tdf'][2] += $item['cantidad'];
				$data['tdf'][4] += $item['incorporacion'];
				$data['tdf'][5] += $item['desincorporacion'];
				$data['items'][$i] = array ( 
					$item['grupo'], $item['subgrupo'], $item['seccion'],
					$item['concepto'],
					$item['cantidad'],
					$item['codigo'],
					$item['descripcion'],
					number_format($item['incorporacion'], 2, ',', '.'),
					number_format($item['desincorporacion'], 2, ',', '.') // Valor Total;
				);
				$i++;
			}
			$data['tdf'][4] = number_format($data['tdf'][4], 2, ',', '.');
			$data['tdf'][5] = number_format($data['tdf'][5], 2, ',', '.');
		
		return $data;
	}
	
	public function getMovimientos()
	{
		// 1er dia del mes siguiente
		$dp_id = $this->dependencia_id;
		$anho = $this->anho;
		$mes = $this->mes_id;
		
		$timeStamp = mktime(0,0,0,$mes,1,$anho);
		$finicio     = date('Y-m-d',$timeStamp);
		
		$mes  = ($mes+1)%12;
		$anho = $anho + (int)(($mes+1)/12);
		$timeStamp = mktime(0,0,0,$mes,1,$anho);
		$ffin     = date('Y-m-d',$timeStamp);
		
		$conection = Yii::app()->db;
        $data = $conection->createCommand()
			->select(	'bm.id, cl.grupo, cl.subgrupo, cl.seccion, bm.codigo, bm.cantidad, '.
						'bm.descripcion, IF(mov.concepto_id<20, bm.valor_unitario, 0) as incorporacion, '. 
						'IF(mov.concepto_id>=20, bm.valor_unitario, 0) as desincorporacion, co.cod as concepto')
			->from(	'bm_movimiento mov')
			->join( 'bienmueble bm', 'mov.bienmueble_id = bm.id')
			->join( 'bm_clasificacion cl', 'bm.clasificacion_id = cl.id')
			->join( 'concepto co', 'mov.concepto_id = co.id')
		    ->where('mov.fecha > "'.$finicio.'" AND mov.fecha <= "'.$ffin.'" AND dependencia_id='.$dp_id)
				//, array(':dp_id'=>$dp_id) )
			->order('bm.codigo ASC, mov.fecha')
			//->text;
		    //print_r($data);exit;
		    ->queryAll();
		return $data;
		/*
		*/
    }

}
