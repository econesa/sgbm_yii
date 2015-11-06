<?php

class ReporteController extends Controller
{
	public function actionIndex()
	{
		$user_id = Yii::app()->user->getId();
		$user = Usuario::model()->findbyPk($user_id);
		$valido = 0;
		$responsable = Responsable::model()->findByAttributes(array('dependencia_id' => $user->dependencia_id, 'status_id' => 1));
		if (!isset($responsable->persona_id)) {
			$valido = 1;
			Yii::app()->user->setFlash('error', 'Debe registrar un responsable para la dependencia');
		}
		$this->render('index', array('valido'=>$valido));
	}
	
	public function actionGenerar($formulario)
	{
		
		$meses = Mes::model()->findAll();
		
		$user_id = Yii::app()->user->getId();
		$user = Usuario::model()->findbyPk($user_id);
		$dp_id  = $user->dependencia_id;
		
		date_default_timezone_set('America/Caracas');
		$anho_actual = date('Y');
		$i = 0;
		$t_anho = $anho_actual;
		$anhos = array();
		while ($t_anho > 2011) {
			$anhos[$i] = $t_anho;
			$i++;
			$t_anho--;
		}
		switch ($formulario) {
			case 1:
			$model = new Fbm1;
			$model->dependencia_id = $dp_id;
			
			if(isset($_POST['Fbm1'])) {
				$fecha = date('Y-m-d H:i:s');
				$responsable = Responsable::model()->findByAttributes(array('dependencia_id' => $model->dependencia_id, 'status_id' => 1));
				
				$model->attributes = $_POST['Fbm1'];
				
				if (isset($responsable) && $model->validate()) 
				{
					$model->anho = $anhos[$model->anho];
					$data = $model->getData();
					$mes = Mes::model()->find(array('condition'=>'id='.$model->mes_id));
					$info = Dependencia::model()->getInfo($model->dependencia_id);
					$header = array();
					if ($model->informativo == 1) {
						$header['columna'] = 4;
						$header['formulario'] = 1;
					}
					else {
						$header['columna'] = 5;
						$header['formulario'] = 2;
					}	

					$header['dependencia'] = $info['dp'];
					$header['estado'] = 'BOLIVARIANO DE MIRANDA';
					$header['municipio'] = 'SUCRE';
					$header['servicio'] = $info['servicio'];
					$header['direccion'] = $info['direccion_corta'];
					$header['fecha'] = $mes->descripcion.'/'.$model->anho;
					$header['responsable'] = $responsable->persona->pdata->nombre;
					$header['cargo'] = $responsable->persona->cargo->descripcion;
					
					$this->render('pdf',array(
						'header'=>$header, 'data'=>$data
					));
				}
			}
			break;
			
			case 2:
			$model = new Fbm2;
			$model->dependencia_id = $dp_id;
			
			if(isset($_POST['Fbm2'])) {
				$fecha = date('Y-m-d H:i:s');
				$responsable = Responsable::model()->findByAttributes(array('dependencia_id' => $model->dependencia_id));
				$model->attributes = $_POST['Fbm2'];
				
				if (isset($responsable) && $model->validate()) 
				{
					$model->anho = $anhos[$model->anho];
					$data = $model->getData();
					$mes = Mes::model()->find(array('condition'=>'id='.$model->mes_id));
					$info = Dependencia::model()->getInfo($model->dependencia_id);
					$header = array();
					$header['columna'] = 6;
					$header['formulario'] = 3;
					$header['responsable'] = $responsable->persona->pdata->nombre;
					$header['cargo'] = $responsable->persona->cargo->descripcion;
					$header['dependencia'] = $info['dp'];
					$header['estado'] = 'BOLIVARIANO DE MIRANDA';
					$header['municipio'] = 'SUCRE';
					$header['servicio'] = $info['servicio'];
					$header['direccion'] = $info['direccion_corta'];
					$header['fecha'] = $mes->descripcion.'/'.$model->anho;

					$this->render('pdf',array(
						'header'=>$header, 'data'=>$data
					));
				}
			}
			break;
			
			case 3:
				$this->redirect(array('/fbm3/index'));
			break;
			
			case 4:
			$model = new Fbm4;
			$model->dependencia_id = $dp_id;
			
			if(isset($_POST['Fbm4'])) {
				$fecha = date('Y-m-d H:i:s');
				$responsable = Responsable::model()->findByAttributes(array('dependencia_id' => $model->dependencia_id));
				$model->attributes = $_POST['Fbm4'];
				
				if (isset($responsable) && $model->validate()) 
				{
					$model->anho = $anhos[$model->anho];
					$data = $model->getData();
					$mes = Mes::model()->find(array('condition'=>'id='.$model->mes_id));
					$info = Dependencia::model()->getInfo($model->dependencia_id);
					$header = array();
					$header['columna'] = 6;
					$header['formulario'] = 5;
					$header['responsable'] = $responsable->persona->pdata->nombre;
					$header['cargo'] = $responsable->persona->cargo->descripcion;
					$header['dependencia'] = $info['dp'];
					$header['estado'] = 'BOLIVARIANO DE MIRANDA';
					$header['municipio'] = 'SUCRE';
					$header['servicio'] = $info['servicio'];
					$header['direccion'] = $info['direccion_corta'];
					$header['fecha'] = $mes->descripcion.'/'.$model->anho;
					$header['hoja'] = $mes->id;

					$this->render('pdf4',array(
						'header'=>$header, 'data'=>$data
					));
				}else {
					echo 1;exit;
				}
			}
			break;
		}
		
		$this->render('generar', array('model'=>$model, 'meses'=>$meses, 'anhos'=>$anhos));
	}

	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users
				'actions'=>array('index','generar'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
}
