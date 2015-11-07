<?php

class BienmuebleController extends Controller
{

	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // authenticated user
				'actions'=>array('index','view','create','update','delete','corregir','desincorporar','mejorar','verResumen'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->pageTitle = 'Mostrar Bien';
		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );
		$acceso = Usuario::privilegiado($user->rol_id);

		$model = $this->loadModel($id);

		if ($model->ult_mov->dependencia_id == $user->dependencia_id) {
			$acceso = 1;
		}
		
		$movimientos = new CActiveDataProvider('BmMovimiento', 
			array(	'pagination' => array('pageSize'=>5,),
	        		'criteria'=>new CDbCriteria(
					array(	'join' =>  'LEFT JOIN bienmueble bm ON bm.id = t.bienmueble_id',
						'condition' => 't.bienmueble_id = '.$model->id,
				        	'order'=>'fecha DESC',
			    		)
	    			),
	    	)
		);
		
		$this->render('view',array(
			'model' => $model, 'movimientos' => $movimientos, 'acceso' => $acceso
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->pageTitle = 'Incorporar Bien';
		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );
		
		$model = new Bienmueble;
		$factura = new Factura;
		$movimiento = new BmMovimiento;
		date_default_timezone_set('America/Caracas'); 
		$fecha = date('Y-m-d H:i:s');
		$model->f_incorporacion = $fecha;
		$movimiento->dependencia_id = $user->dependencia_id;

		if(isset($_POST['Bienmueble']))
		{
			$model->attributes=$_POST['Bienmueble'];
			//print_r();exit;
			$movimiento->attributes=$_POST['BmMovimiento'];
			$model->cantidad = 1;
			$model->status_id = 1;
			$model->factura_id = 1;
			
			if(isset($_POST['Factura'])) {
				$factura->attributes=$_POST['Factura'];
				$factura->fecha = $model->f_incorporacion;
				if ($factura->save()) {
					$model->factura_id = $factura->id;
				}
			}
			
			$model->f_actualizacion = $model->f_incorporacion;
			$model->valor_referencial = $model->valor_unitario;
			if($model->save()) {
				$movimiento->bienmueble_id = $model->id;
				$movimiento->fecha = $model->f_incorporacion;
				if($movimiento->save()) {
					$model->ult_mov_id = $movimiento->id;
					if($model->update()) {
						$bita = new Bitacora;
						$bita->dependencia_id = $user->dependencia_id;
						$bita->fecha = $fecha;
						$bita->operacion_id = 2; // CREAR
						$bita->objeto_id = 1; // Bienmueble
						$bita->usuario_id = $user->id;
						$bita->observacion = 'Se crea BM '.$model->codigo. ' (ID:'.$model->id.')';
						if($bita->save()) {}
						$this->redirect(array('view','id'=>$model->id));
					}
				}
				else {
					 //print_r($movimiento->getErrors()); exit;
				}
			}
		}
		
		$dps = Dependencia::model()->findAll(array('condition'=>'sede_id=1','order'=>'descripcion ASC'));
		$clases = BmClasificacion::model()->listAll();
		$tipos = BmTipo::model()->findAll(array('order'=>'descripcion'));
		$conceptos = Concepto::model()->findAll(array('condition'=>'id>0 AND id<20 AND id<>2 AND id<>15 AND id<>16 AND id<>17'));

		$this->render('create',array(
			'model'=>$model,
			'movimiento'=>$movimiento,
			'dps'=>$dps,
			'clases'=>$clases,
			'tipos'=>$tipos,
			'conceptos'=>$conceptos,
			'factura'=>$factura,
			'acceso' => $user->rol_id
		));
	}

	/**
	 * Desincorporar e Incorporar en el mismo Dp
	 */
	private function movilizar($model, $fecha, $concepto0, $concepto1) {
		$fecha2 = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s', strtotime($fecha)) . " +2 second"));
		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );
		
		$movimiento0 = new BmMovimiento;
		$movimiento0->bienmueble_id = $model->id;
		$movimiento0->dependencia_id = $model->ult_mov->dependencia_id;
		$movimiento0->concepto_id = $concepto0;
		$movimiento0->fecha = $fecha;
		
		$movimiento1 = new BmMovimiento;
		$movimiento1->bienmueble_id = $model->id;
		$movimiento1->dependencia_id = $movimiento0->dependencia_id;
		$movimiento1->concepto_id = $concepto1;
		$movimiento1->fecha = $fecha2;
		
		if($movimiento0->save() && $movimiento1->save()){
			$model->ult_mov_id = $movimiento1->id;
			if($model->update()) {
				$bita = new Bitacora;
				$bita->dependencia_id = $user->dependencia_id;
				$bita->fecha = $fecha;
				$bita->operacion_id = 3; // EDITAR
				$bita->objeto_id = 1; // Bienmueble
				$bita->usuario_id = $user->id;
				$bita->observacion = 'Movimiento de BM '.$model->codigo. ' (ID:'.$model->id.'): concepto id '.$concepto0;
				if($bita->save()) {}
				$bita2 = new Bitacora;
				$bita2->dependencia_id = $user->dependencia_id;
				$bita2->fecha = $fecha;
				$bita2->operacion_id = 3; // EDITAR
				$bita2->objeto_id = 1; // Bienmueble
				$bita2->usuario_id = $user->id;
				$bita2->observacion = 'Movimiento de BM '.$model->codigo. ' (ID:'.$model->id.'): concepto id '.$concepto1;
				if($bita2->save()) {}
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Modifica un bien en particular.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );
		$acceso = Usuario::privilegiado($user->rol_id);
		$this->pageTitle = 'Modificar Bien #'.$model->codigo;

		if (!$acceso && $model->ult_mov->dependencia_id != $user->dependencia_id) {
			Yii::app()->user->setFlash('error', 'No esta autorizado para realizar esta operacion');
			$this->redirect(array('view','id'=>$model->id));
		}
		
		$factura = new Factura;

		if(isset($_POST['Bienmueble']))
		{
			date_default_timezone_set('America/Caracas'); 
			$fecha = date('Y-m-d H:i:s');
			
			$cmodel = $this->loadModel($id);
			$model->attributes = $_POST['Bienmueble'];
			
			// Verificar si hay Cambio de Agrupación
			if ($model->validate()) {
				if ($model->clasificacion_id!=$cmodel->clasificacion_id) {
					if($this->movilizar($model, $fecha, 34, 16)) {
						//$this->redirect(array('view','id'=>$model->id));
					}
				}

				// Verificar si hay Adiciones y Mejoras
				if ($model->valor_unitario!=$cmodel->valor_unitario) {
					if($this->movilizar($model, $fecha, 36, 5)) {
						//$this->redirect(array('view','id'=>$model->id));
					}
				}
				$model->f_actualizacion = $fecha;

				if($model->save()) {
					$bita = new Bitacora;
					$bita->dependencia_id = $user->dependencia_id;
					$bita->fecha = $fecha;
					$bita->operacion_id = 3; // EDITAR
					$bita->objeto_id = 1; // Bienmueble
					$bita->usuario_id = $user->id;
					$bita->observacion = 'Se edito BM '.$model->codigo. ' (ID:'.$model->id.')';
					if($bita->save()) {}
					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}
		
		$clases = BmClasificacion::model()->listAll();
		$tipos = BmTipo::model()->findAll(array('order'=>'descripcion'));

		$this->render('update',array(
			'model'=>$model,
			'clases'=>$clases,
			'tipos'=>$tipos,
			'factura'=>$factura,
		));
	}
	
	/**/
	public function actionCorregir($id) {
		$this->pageTitle = 'Corregir Movimientos';
		
		$model=$this->loadModel($id);
		$movimiento = new BmMovimiento;
		
		$correccion = 17;
		if ($model->ult_mov->concepto_id < 20) {
			$correccion= 35;
		}
		
		if(isset($_POST['BmMovimiento']))
		{
			date_default_timezone_set('America/Caracas'); 
			$fecha = date('Y-m-d H:i:s');
			
			$movimiento->attributes=$_POST['BmMovimiento'];
			$model->attributes=$_POST['Bienmueble'];
			// Verificar si hay Correcciones de Conceptos
			if (isset($movimiento->concepto_id)){
				if($this->movilizar($model, $fecha, $correccion, $movimiento->concepto_id)) {
					$this->redirect(array('view','id'=>$model->id));	
				}
			}
		}
		$noid = $model->ult_mov->concepto_id;
				
		if ($noid < 20) {
			$conceptos = Concepto::model()->findAll(array('condition'=>'id<>0 AND id<20 AND id<>'.$noid ));
		}
		else{
			$conceptos = Concepto::model()->findAll(array('condition'=>'id<>0 AND id>=20 AND id<>'.$noid ));
		}
		
		$this->render('corregir',array(
			'model'=>$model,
			'movimiento'=>$movimiento,
			'conceptos'=>$conceptos,
		));
	}
	
	/**/
	public function actionMejorar($id) {
		$this->pageTitle = 'Otros Movimientos';
		
		$model=$this->loadModel($id);
		$movimientoI = new BmMovimiento;
		$movimientoD = new BmMovimiento;
		
		if(isset($_POST['BmMovimiento2']))
		{
			date_default_timezone_set('America/Caracas'); 
			$fecha = date('Y-m-d H:i:s');
			//print_r($_POST);exit;
			$movimientoI->attributes=$_POST['BmMovimiento2'];
			// Verificar si hay Correcciones de Conceptos
			if ($model->ult_mov->concepto_id<20 ) {
				if(isset($_POST['BmMovimiento']) && $movimientoI->concepto_id>0)
				{
					$movimientoD->attributes=$_POST['BmMovimiento'];
					$model->attributes=$_POST['Bienmueble'];
					$model->status_id = 1;
					if( isset($movimientoD->concepto_id) && isset($movimientoI->concepto_id) &&
						$this->movilizar($model, $fecha, $movimientoD->concepto_id, $movimientoI->concepto_id) ) {
						$this->redirect(array('view','id'=>$model->id));	
					}
				}
			} else {
				$model->attributes=$_POST['Bienmueble'];
				// Reincorporar
				$movimientoI->bienmueble_id = $model->id;
				$movimientoI->dependencia_id = $model->ult_mov->dependencia_id;
				$movimientoI->fecha = $fecha;
				if( $movimientoI->save() ) {
					$model->ult_mov_id = $movimientoI->id;
					$model->status_id = 1;
					if($model->update()) {
						$this->redirect(array('view','id'=>$model->id));
					}
				}
			}
			
		}
		$noid = $model->ult_mov->concepto_id;
		$conceptosI = Concepto::model()->findAll(array('condition'=>'id<20 AND id<>0 AND id<>16 AND id<>'.$noid ));
		$conceptosD = Concepto::model()->findAll(array('condition'=>'id>=20 AND id<>0 AND id<>29 AND id<>'.$noid ));
		
		$this->render('mejorar',array(
			'model'=>$model,
			'movimientoI'=>$movimientoI,
			'movimientoD'=>$movimientoD,
			'conceptosI'=>$conceptosI,
			'conceptosD'=>$conceptosD,
		));
	}
	
	/**/
	public function actionVerResumen() {
		$this->pageTitle = 'Resumen';
		$data = Bienmueble::model()->getResumen();
		
		date_default_timezone_set('America/Caracas'); 
		$fecha = date('Y-m-d H:i:s');
		
		$this->render('resumen',array(
			'data'=>$data,
		));
	}
	
	/**/
	public function actionDesincorporar($id) {
		$this->pageTitle = 'Desincorporar Bien';
		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );
		$model = $this->loadModel($id);
		$movimiento = new BmMovimiento;
		$movimiento->bienmueble_id = $model->id;
		
		if(isset($_POST['BmMovimiento']))
		{
			date_default_timezone_set('America/Caracas'); 
			$fecha = date('Y-m-d H:i:s');
			
			$movimiento->attributes=$_POST['BmMovimiento'];
			// Verificar 
			if (isset($movimiento->concepto_id)) {
				$movimiento->fecha = $fecha;
				$movimiento->dependencia_id = $model->ult_mov->dependencia_id;
				if($movimiento->save()) {
					$model->ult_mov_id = $movimiento->id;
					$model->status_id = 2;
					if($model->update()) {
						$bita = new Bitacora;
						$bita->dependencia_id = $user->dependencia_id;
						$bita->fecha = $fecha;
						$bita->operacion_id = 3; // EDITAR
						$bita->objeto_id = 1; // Bienmueble
						$bita->usuario_id = $user->id;
						$bita->observacion = 'Se desincorporo el BM '.$model->codigo. ' (ID:'.$model->id.') por concepto '.$movimiento->concepto_id;
						if($bita->save()) {}
					
						$this->redirect(array('view','id'=>$model->id));
					}
					else {
						 //print_r($model->getErrors()); exit;
					}
				}
				else {
					 //print_r($movimiento->getErrors()); exit;
				}	
			}
		}

		$existeT = BmTraspasoItem::model()->exists('bienmueble_id='.$model->id); 
		$existeF = Fbm3Bien::model()->exists('bienmueble_id='.$model->id);
		if ($existeT) {
			Yii::app()->user->setFlash('error', 'No puede efectuarse la operación. El bien esta en proceso de traspaso.');
			$this->redirect(array('view', 'id'=>$model->id));
		}
		if ($existeF) {
			Yii::app()->user->setFlash('error', 'No puede efectuarse la operación. El bien esta reportado como extraviado');
			$this->redirect(array('view', 'id'=>$model->id));
		}
		
		$conceptos = Concepto::model()->findAll(array('condition'=>'id>=20'));
		
		$this->render('desincorporar',array(
			'model'=>$model,
			'movimiento'=>$movimiento,
			'conceptos'=>$conceptos,
		));
	}
	/*
	 * Para dar de alta un bien que ha sido reconstruido o trasformado mediante desmantelamiento de bienes inservibles o por la utilización de repuestos nuevos. 
	 * El bien será desincoporado por deterioro e reincorporado por reconstrucción. Opcionalmente puede que otro bien se desincorpore por desarme (55). 
	 * En las observaciones debe especificarse los detalles de este proceso.
	 */

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->pageTitle = 'Eliminar Bien';
		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );
		$model = $this->loadModel($id);
		date_default_timezone_set('America/Caracas'); 
		$fecha = date('Y-m-d H:i:s');
		
		$existeT = BmTraspasoItem::model()->exists('bienmueble_id='.$model->id); 
		$existeF = FBm3Bien::model()->exists('bienmueble_id='.$model->id);
		if (!$existeT && !$existeF) {
			$movimientos = BmMovimiento::model()->findAllByAttributes(array('bienmueble_id'=>$model->id));
			foreach ($movimientos as $mov) {
				$mov->delete();
			}

			$bita = new Bitacora;
			$bita->dependencia_id = $user->dependencia_id;
			$bita->fecha = $fecha;
			$bita->operacion_id = 4;
			$bita->objeto_id = 1; // Bienmueble
			$bita->usuario_id = $user->id;
			$bita->observacion = 'Se elimina el BM '.$model->codigo. ' (ID:'.$model->id.')';
			if($bita->save()) {}

			$model->delete();
			
			$this->redirect(array('index'));
		}
		else {
			Yii::app()->user->setFlash('error', 'No puede efectuarse la operación. Existen registros que utilizan este dato.');
			$this->redirect(array('view', 'id'=>$model->id));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->pageTitle = 'Listar Bienes';
		$filtro = new BmFiltro;

		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );

		$acceso = Usuario::privilegiado($user->rol_id);
		
		if(isset($_GET['BmFiltro'])) {
			$filtro->attributes = $_GET['BmFiltro'];
		}
		
		$vars = array();
		$vars['dps'] = Dependencia::model()->findAll(array('condition'=>'sede_id=1','order'=>'descripcion ASC'));
		$vars['clases'] = BmClasificacion::model()->listAll();
		$vars['tipos'] = BmTipo::model()->findAll(array('order'=>'descripcion'));
		$vars['conceptos'] = Concepto::model()->findAll();
		$vars['status'] = BmStatus::model()->findAll();
		$vars['anhos'] = array('1'=>"2012", '2'=>"2011");
		
		$dataProvider = $filtro->search();
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'filtro'=>$filtro, 'vars'=>$vars, 'acceso'=>$acceso
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Bienmueble::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bienmueble-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
