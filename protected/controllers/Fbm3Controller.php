<?php

class Fbm3Controller extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','buscarAjax','adscribir', 'actualizarAjax', 'updateAjax','agregarAjax','deleteBma',
					'generar', 'delete','imprimir'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Muestra algún reporte de bienes faltantes
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		
		$items = Fbm3Bien::model()->findAll( array(
			'join'=>'JOIN bienmueble as bm ON t.bienmueble_id = bm.id',
			'condition'=>'t.fbm3_id='.$model->id, 
			'order'=>'bm.codigo ASC')
		);
		
		$this->render('view',array(
			'model'=>$model, 'items'=>$items
		));
	}

	/**
	 * Reportar bienes faltantes.
	 * @redirected to 'view' page.
	 */
	public function actionCreate()
	{
		$user_id = Yii::app()->user->getId();
		$user = Usuario::model()->findbyPk($user_id);
		
		date_default_timezone_set('America/Caracas'); 
		$fecha = date('Y-m-d H:i:s');
	
		$model=new Fbm3;
		$model->dependencia_id = $user->dependencia_id;
		$model->observador = new Persona;
		$model->observador->pdata = new PersonaData;
		$model->observador->cargo = new Cargo;
		$model->status_id = 1; // creando
		$model->fecha = $fecha;

		if(isset($_POST['Fbm3']))
		{
			$model->attributes=$_POST['Fbm3'];
			$model->observador->attributes=$_POST['Persona'];
			$model->observador->pdata->attributes=$_POST['PersonaData'];
			
			$exists = PersonaData::model()->exists('cedula='.$model->observador->pdata->cedula);
			if ( !$exists ) {
				$model->observador->pdata->f_creacion = $fecha;
				$model->observador->pdata->f_cambios = $fecha;
				if ( $model->observador->pdata->save() )
					$model->observador->pdata_id = $model->observador->pdata->id;
				
				//$model->observador->cargo->attributes = $_POST['Cargo']; 
				$model->observador->dependencia_id = $_POST['Persona']['dependencia_id'];
				$model->observador->fecha = $fecha;
				if ( $model->observador->save()  ) {
					$model->observador_id = $model->observador->id;
				}
				else {
					//print_r($model->observador->getErrors());
					//exit;
				}
					
			}
			else {
				$pdata = PersonaData::model()->findByAttributes(array('cedula'=>$model->observador->pdata->cedula));
				$model->observador->pdata_id = $pdata->id;
				
				$persona = Persona::model()->find(
					array('condition'=>'t.pdata_id='.$model->observador->pdata_id.' AND t.dependencia_id='.$model->observador->dependencia_id )
				);
				if (!$persona) {
					// guardar persona 
					$model->observador->dependencia_id = $_POST['Persona']['dependencia_id'];
					$model->observador->fecha = $fecha;
					if ( $model->observador->save()  ) {
						$model->observador_id = $model->observador->id;
					}
				}
				else {
					$model->observador_id = $persona->id;
					$model->observador = $persona;
				}
			}
			
			if($model->save())
				$this->redirect(array('adscribir','id'=>$model->id));
		}
		
		$responsables = Responsable::model()->findAll();
		$profesiones = Profesion::model()->findAll();
		$dps = Dependencia::model()->findAll(array('condition'=>'sede_id=1'));
		$generos = Sexo::model()->findAll();
		$cargos = Cargo::model()->findAll();

		$this->render('create',array(
			'model'=>$model, 'responsables'=>$responsables, 'profesiones'=>$profesiones, 'dps'=>$dps, 'generos'=>$generos, 'cargos'=>$cargos
		));
	}

	/**
	 * Updates a particular model
	 * @param integer $id the ID of the model to be updated
	 * @redirected to'view' page.
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Fbm3']))
		{
			$model->attributes=$_POST['Fbm3'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$responsables = Responsable::model()->findAll();
		$profesiones = Profesion::model()->findAll();
		$dps = Dependencia::model()->findAll();
		$generos = Sexo::model()->findAll();

		$this->render('update',array(
			'model'=>$model, 'responsables'=>$responsables, 'profesiones'=>$profesiones, 'dps'=>$dps, 'generos'=>$generos
		));
	}

	/**
	 * Deshace reporte y elimina datos de la BD a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$bienes = Fbm3Bien::model()->findAll( array('condition' => 't.fbm3_id='.$model->id));
		foreach ($bienes as $bien) {
			$bien->bienmueble->ult_mov->delete();
			$bien->bienmueble->ult_mov_id = $bien->histo_mov_id;
			$item->bienmueble->status_id = 1;
			if ( $bien->bienmueble->update()) {
				//
			}
			$bien->delete();
		}
		$model->delete();
		$this->redirect(array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Fbm3', array(
	        'pagination'=>array('pageSize'=>10,),
	        'criteria'=> new CDbCriteria(
				array( 'condition' => 't.status_id>1')
	    	),
	    ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionAdscribir( $id )
	{
		$model = $this->loadModel($id);
		$bien = new Bienmueble;

		// la adscripcion de bienes es por ajax

		$this->render('adscribir',array(
			'model'=>$model, 'bien'=>$bien
		));
	}

	public function actionGenerar($id)
	{
		unset(Yii::app()->session['bmid']);
		$model 	= $this->loadModel($id);
		$bienes = Fbm3Bien::model()->findAll( array(
			'join' => 'JOIN bienmueble as bm ON t.bienmueble_id = bm.id',
			'condition' => 't.fbm3_id='.$model->id, 'order'=>'bm.codigo ASC')
		);
		Yii::app()->session['bmid'] = NULL;	
		
		if ( count($bienes) < 1 ) {
			Yii::app()->user->setFlash('error', 'Debe adscribir al menos un bien.');
			$this->redirect(array('adscribir', 'id'=>$model->id));
		}
		
		$data = $model->getDataPDF( $model );
		
		if(isset($_POST['Fbm3'])) {
			date_default_timezone_set('America/Caracas'); 
			$fecha = date('Y-m-d H:i:s');
			
			Yii::app()->session['fbmid'] = NULL;
			$model->status_id = 2; // reportado
			
			// calcular cantidad y valor total de bienes faltantes y actualizar
			$info = $model->getTotal();
			$model->cantidad = $info['cantidad']; 
			$model->valor_total = $info['valor_total']; 
			
			$items = Fbm3Bien::model()->findAll( array('condition'=>'fbm3_id='.$model->id) );
			foreach ($items as $item) {
				$movimiento = new BmMovimiento;
				$movimiento->bienmueble_id = $item->bienmueble_id;
				$movimiento->dependencia_id = $item->bienmueble->ult_mov->dependencia_id;
				$movimiento->concepto_id = 29; // concepto 60
				$movimiento->fecha = $fecha;
				if ( $movimiento->save() ) {
					$item->histo_mov_id = $item->bienmueble->ult_mov_id;
					$item->bienmueble->status_id = 2;
					$item->bienmueble->ult_mov_id = $movimiento->id;
					$item->movimiento_id = $movimiento->id;
					if ( $item->update() && $item->bienmueble->update()) {
						//
					}
					else {
						//print_r($item->getErrors()); exit;
					}	
				}
				else {
					//print_r($movimiento->getErrors()); exit;
				}
			}
			
			if ( $model->update() ) {
				$this->redirect( array('view', 'id'=>$model->id) );
			}
			
		}
		
		if( isset($_POST['cancelar']) ) {
			if ( $_POST['cancelar'] == 1 ) {
				$fbmid = $_POST['fbmid'];
				$model = $this->loadModel($fbmid);
				$model->delete();
				$items = Fbm3Bien::model()->findAll( array('condition'=>'fbm3_id='.$fbmid) );
				foreach ($items as $item)
					$item->delete();
				$this->redirect(array('index'));
			}
		}
		$this->render('generar',
			array('id'=>$id, 'model'=>$model, 'data'=>$data, 'bienes'=>$bienes)
		);
	}

	public function actionImprimir($id) {
		
		$model 	= $this->loadModel($id);
		
		$bienes = Fbm3Bien::model()->findAll( array(
			'join' => 'JOIN bienmueble as bm ON t.bienmueble_id = bm.id',
			'condition' => 't.fbm3_id='.$model->id, 'order'=>'bm.codigo ASC')
		);
		
		$data = array();
		
		
		$sede=Sede::model()->find(array('condition'=>'id=1'));
		date_default_timezone_set('America/Caracas');
		setlocale(LC_ALL, 'es_ES');
		$data=$model->getDataPDF( $model );
		
		$header=array();
		$header['formulario'] = 4;
		$header['responsable'] = $model->responsable->persona->pdata->profesion->cod.' '.$model->responsable->persona->pdata->nombre;
		$header['comprobante'] = $model->comprobante;
		$header['observaciones'] = $model->observaciones;
		if ($model->dependencia->u_adm_id!=0)
			$header['adm']	=$model->dependencia->u_adm->descripcion;
		else
			$header['adm']	= '';
		$header['cp_nombre']=$model->observador->pdata->nombre;
		$header['cp_cargo']	=$model->observador->cargo->descripcion;
		$header['cp_dp']	=$model->observador->dependencia->descripcion;
		
		$header['fecha'] = 
			Yii::app()->dateFormatter->formatDateTime(
                CDateTimeParser::parse($model->fecha, 'yyyy-MM-dd hh:mm:ss'),
                'medium',''
            );
		
		$config=array();//  de Movimiento
		$config['th'] = array('Nro. de Identificacion', 'Descripcion de los Bienes',
			'Cantidad','Valor Unitario','Dif. Cantidad', 'Dif. V.U.');
		$config['tw'] = array(15, 15, 15, 28, 96, 17, 25, 20, 25);
		$config['ta'] = array('C','C','C','C','L','C','R','R','R');
		$config['td'] = array();
		$config['twf'] = array(169,17,25,20,25);
		$config['taf'] = array('C','C','R','R','R');
		$config['tdf'] = array();
		$config['tdf'][0]='TOTAL';
		$config['tdf'][1]=0;
		$config['tdf'][2]=0;
		$config['tdf'][3]=0;
		$config['tdf'][4]=0;
		
		$header['dependencia'] = $model->dependencia->descripcion;
		$header['estado'] = 'BOLIVARIANO DE MIRANDA'; //$model->dependencia->sede->localidad->estado->descripcion;
		$header['municipio'] = 'SUCRE';//$model->dependencia->sede->localidad->municipio->descripcion;	
		
		$items = Fbm3Bien::model()->findAll(array(
			'join'=>'JOIN bienmueble as bm ON t.bienmueble_id = bm.id',
			'condition'=>'t.fbm3_id='.$model->id, 
			'order'=>'bm.codigo ASC')
		);
		$config['hc'] = array();
		
		$valor_total = 0;
		$i = 0;
		foreach ($items as $item) {
			$config['td'][$i] = array ( 
				$item->bienmueble->clasificacion->grupo,
				$item->bienmueble->clasificacion->subgrupo,
				$item->bienmueble->clasificacion->seccion, 
				$item->bienmueble->codigo,
				$item->bienmueble->descripcion, 
				1, //cantidad
				number_format($item->bienmueble->valor_unitario,2,',',' '),
				1,
				number_format($item->bienmueble->valor_unitario,2,',',' '),
			);
			$config['tdf'][1]++;
			$valor_total+=$item->bienmueble->valor_unitario;
			$config['tdf'][3]++;
			$i++;
		}
		$config['tdf'][2] = number_format($valor_total, 2, ',', ' ');
		//$config['tdf'][3] = $config['tdf'][3];
		$config['tdf'][4] = number_format($valor_total*$config['tdf'][3], 2, ',', ' ');
		$this->layout = 'pdf';
		
		$this->render('imprimir',
			array('header'=>$header,'data'=>$data,'config'=>$config)
		);
	}
	
//----------------- 
// Funciones Ajax
//------------------------------------------------------------------------------
	
	/* Carga datos de la persona en el formulario si existe en la BD un registro con la cedula solicitada. */
	public function actionBuscarAjax()
	{
		if( isset($_POST['cedula']) && $_POST['cedula']!=NULL ) {
			$cedula = $_POST['cedula'];
			$pdata = PersonaData::model()->findByAttributes( array('cedula'=>$cedula) );
			if($pdata != NULL) {
				$persona = Persona::model()->find(
					array('condition'=>'pd.cedula='.$cedula, 'join'=>'JOIN persona_data as pd ON t.pdata_id = pd.id')
				);
				if($persona != NULL) {
					echo CJSON::encode(array(
			            'value1' => $persona->id,
						'value2' => $pdata->nombre,		'value3' => $pdata->profesion_id,
						'value4' => $pdata->sexo_id,	'value5' => $persona->dependencia_id,
			            'value6' => $persona->cargo_id,	
			        ));
				}
				else {
					echo CJSON::encode(array(
			            'value1' => 0,
						'value2' => $pdata->nombre,		'value3' => $pdata->profesion_id,
						'value4' => $pdata->sexo_id,	'value5' => 0,
			            'value6' => 0,	
			        ));
				}
				
		        Yii::app()->end();
			}
        }

        echo CJSON::encode(array(
            'value1' => 0,    'value2' => '',	'value3' => 0,    'value4' => 0,    'value5' => 0,    'value6' => 0
        ));
        Yii::app()->end(); 
	}
	
	/* Buscar bien por codigo */
	public function actionUpdateAjax()
	{
		$data = array();
		$error = '';
		
		$user_id = Yii::app()->user->getId();
		$user = Usuario::model()->findbyPk($user_id);
		$dp_id = $user->dependencia_id;
		
		if( isset($_POST['codigo'])) {
			$bm = Bienmueble::model()->findByDp($dp_id, $_POST['codigo']);
			
			if ($bm == NULL) {
				$error = 'No se encuentra la placa indicada en el departamento.';
			}
			else {
				Yii::app()->session['bmid'] = $bm;	
				$data['bm'] = $bm;
			}	
		}
		else
			$error = 'Por favor, indique correctamente la placa.';
		
        $data['error'] = $error;
        
        $this->renderPartial('_content', $data, false, true);
	}

	/* Adscribe en la lista el bien faltante */	
	public function actionAgregarAjax()
	{
		$fbmid = $_POST['fbmid'];
		$bmid = NULL;
		if (isset(Yii::app()->session['bmid']))
			$bmid =  Yii::app()->session['bmid']['id']; //$_POST['bm_id'];
		$data = array();

		if ($fbmid != NULL && $bmid != NULL) {
			$it = Fbm3Bien::model()->findAll(array(
				'join'=>'JOIN bienmueble as Bienmueble ON t.bienmueble_id = Bienmueble.id',
				'condition'=>'t.fbm3_id='.$fbmid.' AND Bienmueble.id='.$bmid )
			); 
			if (count($it)<1) {
				$ebm = new Fbm3Bien;
				$ebm->fbm3_id = $fbmid;
				$ebm->bienmueble_id = $bmid;
				if ($ebm->save()) {
					Yii::app()->session['bmid']=NULL;
				}
				//else print_r($ebm->getErrors());
			}
		}
		$_POST['bm_id'] = NULL;

		$data['items'] = Fbm3Bien::model()->findAll(array(
			'join'=>'JOIN bienmueble as Bienmueble ON t.bienmueble_id = Bienmueble.id',
			'condition'=>'t.fbm3_id='.$fbmid, 
			'order'=>'Bienmueble.codigo ASC')
		);

		$this->renderPartial('_content2', $data, false, true);
	}
	
	/* Refresca la tabla de bienes faltantes dinamicamente */
	public function actionActualizarAjax()
	{
		$data = array();
		if( isset($_POST['fbmid'])) {
			$fbmid = $_POST['fbmid'];
			$data['items'] = Fbm3Bien::model()->findAll(array(
				'join'=>'JOIN bienmueble as Bienmueble ON t.bienmueble_id = Bienmueble.id',
				'condition'=>'t.fbm3_id='.$fbmid, 
				'order'=>'Bienmueble.codigo ASC')
			);
		}
		$this->renderPartial('_content2', $data, false, true);
	}

	/* Elimina un bien adscrito en la lista de bienes faltantes. */
	public function actionDeleteBma($id, $fbmid)
	{
		$item = Fbm3Bien::model()->findByPk($id);
		$item->delete();
		$this->redirect(array('adscribir','id'=>$fbmid));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Fbm3::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='fbm3-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
