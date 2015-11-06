<?php
/**
 * Fbm1 class.
 */

class Fbm1 extends CFormModel
{
	public $cod = 1;
	public $mes_id;
	public $anho;
	public $dependencia_id;
	public $informativo;
	public $descripcion = "Inventario de Bienes (Formulario B.M.1)";

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('mes_id, anho', 'required'),
			array('mes_id, anho, informativo', 'numerical', 'integerOnly'=>true),
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
			'informativo'=>'Uso Informativo (Modo Borrador)',
		);
	}
	
	public function getData()
	{
		$data = array();
		$data['items'] = array();
		$data['thd'] = array('Nro. de Identificacion', 'Descripcion de los Elementos','Valor Unitario Bs,','Valor Total Bs.');
		
		$items = $this->getInventario();
		$i = 0;
		if ($this->informativo==0) {
			$data['thd'] = array('Cantidad','Nro. de Identificacion', 'Descripcion de los Elementos','Valor Unitario Bs,','Valor Total Bs.');
			$data['thw'] = array(15, 15, 15, 14, 30, 113, 27, 27);
			$data['ta'] = array('C','C','C','C','C','L','R','R');
			$data['twf'] = array(45,14,143,27,27);
			$data['taf'] = array('C','C','C','R','R');
			$data['tdf'] = array('TOTAL',0,'',0,0);
			$data['tdf'][1] = 0; //cantidad
			$data['tdf'][3] = 0; //valor_unitario
			$data['tdf'][4] = 0; //valor_total
			
			foreach ($items as $item) {
				$data['tdf'][1] += $item['cantidad'];
				$data['tdf'][3] += $item['valor_unitario'];
				$data['tdf'][4] += $item['valor_unitario']*$item['cantidad'];
				$data['items'][$i] = array ( 
					$item['grupo'], $item['subgrupo'], $item['seccion'],
					$item['cantidad'],
					$item['codigo'],
					$item['descripcion'],
					number_format($item['valor_unitario'], 2, ',', '.'),
					number_format($item['valor_unitario']*$item['cantidad'], 2, ',', '.') // Valor Total;
				);
				$i++;
			}
			$data['tdf'][3] = number_format($data['tdf'][3], 2, ',', '.');
			$data['tdf'][4] = number_format($data['tdf'][4], 2, ',', '.');
		}
		else {
			$data['thd'] = array('Nro. de Identificacion', 'Descripcion de los Elementos','Valor Unitario Bs,');
			
			$data['twf'] = array(45,14,113,54);
			$data['taf'] = array('C','C','C','R');
			$data['tdf'] = array('TOTAL',0,'',0);
			$data['tdf'][1] = 0; //cantidad
			$data['tdf'][3] = 0; //valor_unitario
			
			foreach($items as $item) {
				$data['thw'] = array(0, 0, 0, 14, 158, 54);
				$data['ta'] = array('L','C','C','C','L','R');

				$data['tdf'][1] += $item['cantidad'];
				$data['tdf'][3] += $item['valor_unitario'];
				$data['items'][$i] = array ( 
					'','','',
					$item['codigo'],
					$item['descripcion'],
					number_format($item['valor_unitario'], 2, ',', '.'),
				);
				$i++;
			}
			$data['tdf'][3] = number_format($data['tdf'][3], 2, ',', '.');
		}
		
		return $data;
	}
	
	public function getInventario()
	{
		// 1er dia del mes siguiente
		$dp_id = $this->dependencia_id;
		$anho = $this->anho;
		$mes = $this->mes_id;
		
		$obs='';
		if ($this->informativo==1) {
			$obs = 'bm.observaciones, ';
		}
		
		$anho = $anho + (int)(($mes+1)/12);
		$mes  = ($mes+1)%12;
		$timeStamp = mktime(0,0,0,$mes,1,$anho);
		$fecha     = date('Y-m-d',$timeStamp);
		
		$conection = Yii::app()->db;
        $data = $conection->createCommand()
			->select( 'bm.id, cl.grupo, cl.subgrupo, cl.seccion, bm.codigo, bm.cantidad, bm.descripcion, bm.valor_unitario, '.$obs)
			->from(	'bienmueble bm')
			->join( 'bm_clasificacion cl', 'bm.clasificacion_id = cl.id')
			->join( '(	SELECT bstatus.bienmueble_id, bstatus.fecha
						FROM bm_movimiento bstatus
						INNER JOIN (
							SELECT bienmueble_id, MAX( fecha ) AS fecha
							FROM bm_movimiento sta
							GROUP BY bienmueble_id, dependencia_id
							HAVING fecha < "'.$fecha.'"
						) AS last_sta ON ( bstatus.bienmueble_id = last_sta.bienmueble_id AND bstatus.fecha = last_sta.fecha ) 
						WHERE dependencia_id='.$dp_id.' AND concepto_id<20 AND last_sta.fecha < "'.$fecha.'" 
					  ) as st_hist', 'st_hist.bienmueble_id=bm.id' )
		    ->where('st_hist.fecha < "'.$fecha.'" AND st_hist.bienmueble_id = bm.id AND 
				cl.id = bm.clasificacion_id')
				//, array(':dp_id'=>$dp_id) )
			->order('bm.codigo ASC, st_hist.fecha')
			//->text;
		    //print_r($data);exit;
		    ->queryAll();
		return $data;
		/*
		SELECT `bm`.`id`, `cl`.`grupo`, `cl`.`subgrupo`, `cl`.`seccion`, `bm`.`codigo`, `bm`.`cantidad`, `bm`.`descripcion`, `bm`.`valor_unitario` 
		FROM `bienmueble` `bm` 
		JOIN `bm_clasificacion` `cl` ON bm.clasificacion_id = cl.id 
		JOIN (	SELECT bstatus.bienmueble_id, bstatus.fecha 
				FROM bm_movimiento bstatus 
				INNER JOIN ( 	SELECT bienmueble_id, MAX( fecha ) AS fecha 
								FROM bm_movimiento sta 
								WHERE dependencia_id=12 
								GROUP BY bienmueble_id, dependencia_id ) 
				AS last_sta ON ( bstatus.bienmueble_id = last_sta.bienmueble_id AND bstatus.fecha = last_sta.fecha ) 
				WHERE dependencia_id=12 AND concepto_id<20 AND last_sta.fecha < "2012-08-01" ) 
				AS st_hist ON st_hist.bienmueble_id=bm.id 
		WHERE st_hist.fecha < "2012-08-01" AND st_hist.bienmueble_id = bm.id AND cl.id = bm.clasificacion_id 
		ORDER BY `bm`.`codigo` ASC, `st_hist`.`fecha`
		*/
    }

}
