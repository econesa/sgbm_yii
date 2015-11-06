<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com> */

class TraspasoController extends Controller
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
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','list','create','update', 'searchAjax', 'adscribirAjax', 'actualizarAjax', 'enviar','confirmar', 'rechazar', 'removeBm','delete', 'imprimir'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
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
		$model=$this->loadModel($id);
		$bienes=BmTraspasoItem::model()->findAll(array('condition'=>'traspaso_id='.$id));
		$data = $model->getDataPDF( $model );	
			
		$this->render('view',array(
			'model'=>$model,
			'bienes'=>$bienes,
			'data'=>$data,
		));
	}

	/**
	 * Iniciar Traspaso
	 */
	public function actionCreate()
	{
		date_default_timezone_set('America/Caracas'); 
		$fecha = date('Y-m-d H:i:s');	
		$bien = new Bienmueble;

		$user_id = Yii::app()->user->getId();
		$user = Usuario::model()->findbyPk($user_id);
		$dp_id = $user->dependencia_id;
		
		$emisores = Responsable::model()->findByDp($dp_id, 0);
		$receptores = Responsable::model()->findByDp($dp_id, 1);
		
		if (!isset(Yii::app()->session['tid'])) {
		
			$model = new BmTraspaso;
			$model->dependencia_id = $dp_id;
			$model->status_id = 1;
			$model->fecha = $fecha;
			$model->emisor_id = $emisores['id'];
		
			if ($model->save()) {
				Yii::app()->session['tid'] = $model->id;

				$this->render('create',array(
					'model'=>$model, 'bien'=>$bien, 'emisores'=>$emisores, 'receptores'=>$receptores,
				));
			}
			else { // Flujo en caso de error fatal
				$dataProvider=new CActiveDataProvider('BmTraspaso');
				$this->render('index',array(
					'dataProvider'=>$dataProvider,
				));
			}
		}
		else {
			$model = $this->loadModel(Yii::app()->session['tid']);
			
			if(isset($_POST['BmTraspaso']))
			{
				$model->scenario = 'update';
				$model->attributes = $_POST['BmTraspaso'];		
				$data = BmTraspaso::model()->getTotal( $model->id );
				$model->cantidad_total = $data['cantidad_total'];
				$model->total = $data['total'];
				if($model->validate() && $model->update())
					$this->redirect(array('enviar','id'=>$model->id));
			}
			
			$this->render('create',array(
				'model'=>$model, 'bien'=>$bien, 'emisores'=>$emisores, 'receptores'=>$receptores,
			));
		}
	}

	/**
	 * Updates a particular model.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['BmTraspaso']))
		{
			$model->attributes=$_POST['BmTraspaso'];
			if($model->save())
				$this->redirect(array('enviar','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Elimina un bien adscrito
	 */
	public function actionRemoveBm($id)
	{
		$item = BmTraspasoItem::model()->findByPk($id);
		$item->delete();
		$this->redirect(array('create'));
	}

	/**
	 * Elimina un traspaso (No anula).
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model=$this->loadModel($id);
		date_default_timezone_set('America/Caracas');
		$fecha = date('Y-m-d H:s:i');
		
		if ($model->status_id != 1) {
			$bita = new Bitacora;
			$bita->operacion_id = 15;
			$bita->objeto_id = 2;
			$bita->observacion = 'Emisor: '.$model->emisor_id.'; Receptor: '.$model->receptor_id.'; Fecha :'.$model->fecha;
			$bita->usuario_id = Yii::app()->user->getId();
			$bita->fecha = $fecha;
			if($bita->save()) {}
		}
		$model->delete();
		unset(Yii::app()->session['tid']);
		$items = BmTraspasoItem::model()->findAll(array('condition'=>'traspaso_id='.$model->id));
		foreach ($items as $item)
			$item->delete();
		$this->redirect(array('index'));
	}

	/**
	 * Muestra una bandeja de entrada de traspaso 
	 */
	public function actionIndex()
	{
		//$dataProvider=new CActiveDataProvider('BmTraspaso');
		
		$user_id = Yii::app()->user->getId();
		$user = Usuario::model()->findbyPk($user_id);
		$dp_id = $user->dependencia_id;
		
		if (isset($dp_id)) {
			$dataProviderR = new CActiveDataProvider('BmTraspaso', array(
		        'pagination'=>array('pageSize'=>4,),
		        'criteria'=> new CDbCriteria(
					array(
						'join' =>  'LEFT JOIN responsable r ON r.id = t.receptor_id
									LEFT JOIN persona p ON p.id = r.persona_id',
						'condition' => 't.status_id=2 AND p.dependencia_id='.$dp_id,
				        'order'=>'fecha DESC, status_id ASC',
		    		)
		    	),
		    ));
		    
		    $dataProviderE = new CActiveDataProvider('BmTraspaso', 
				array(	'pagination' => array('pageSize'=>4,),
		        		'criteria'=>new CDbCriteria(
							array(	'join' =>  'LEFT JOIN responsable r ON r.id = t.emisor_id
												LEFT JOIN persona p ON p.id = r.persona_id',
									'condition' => 't.status_id<>1 AND t.status_id<>4 AND p.dependencia_id='.$dp_id,
						        	'order'=>'fecha DESC',
				    		)
		    			),
		    	)
			);
			$this->render('index',array(
				//'dataProvider'=>$dataProvider,
				'dataProviderR'=>$dataProviderR,
				'dataProviderE'=>$dataProviderE
			));
		}
	}
	
	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$user_id = Yii::app()->user->getId();
		$user = Usuario::model()->findbyPk($user_id);
		$dp_id = $user->dependencia_id;
		
		if (isset($dp_id)) {
	    	$dataProvider=new CActiveDataProvider('BmTraspaso', array(
		        'pagination'=>array('pageSize'=>5,),
				'criteria' => new CDbCriteria( array(
					'join' => 	'LEFT JOIN responsable re ON re.id = t.emisor_id
								 LEFT JOIN responsable rr ON rr.id = t.receptor_id
								 LEFT JOIN persona pe ON pe.id = re.persona_id
								 LEFT JOIN persona pr ON pr.id = rr.persona_id',
					'condition' => 	't.status_id<>1 AND '.
									'(pe.dependencia_id='.$dp_id.' OR pr.dependencia_id='.$dp_id.')',
			        'order'=>'t.status_id DESC,fecha DESC',
		    		)
		    	),
		    ));
		} 
		/*
	    if ( Yii::app()->user->isAdmin ) {
	    	$DataProviderA=new CActiveDataProvider('BmTraspaso', array(
		        'pagination'=>array('pageSize'=>5,), 
				'criteria'=>new CDbCriteria(array(
					'condition' => 'status_id<>1',
			        'order'=>'fecha ASC',
		    		)
		    	),
		    ));
		    $this->render('list',array(
				'dataProviderA'=>$DataProviderA, 'dataProviderE'=>$DataProvider
			));
		}
		*/
		//else {
			$this->render('list',array('dataProvider'=>$dataProvider,));
		//}
	}
	
	/**
	 * 
	 */
	public function actionEnviar($id)
	{
		$model=$this->loadModel($id);
		$bienes = BmTraspasoItem::model()->findAll(array(
			'join'=>'JOIN bienmueble as bm ON t.bienmueble_id = bm.id',
			'condition'=>'t.traspaso_id='.$model->id, 
			'order'=>'bm.codigo ASC')
		);
		
		if(isset($_POST['BmTraspaso'])) {
			Yii::app()->session['tid'] = NULL;
			$model->status_id = 2;
			if($model->update())
				$this->redirect(array('index')); //,'id'=>$model->id
			else {
				//print_r($model->getErrors()); exit;
			}
		}
		
		$data = $model->getDataPDF( $model );
		Yii::app()->session['bmid'] = NULL;
		
		$this->render('enviar',array(
			'model'=>$model, 'data'=>$data, 'bienes'=>$bienes,
		));
	}
	
	/**
	 * Confirmar un traspaso entrante
	 */
	public function actionConfirmar($id)
	{
		$model = $this->loadModel($id);
		
		$bienes = BmTraspasoItem::model()->findAll(array(
			'join'=>'JOIN bienmueble as bm ON t.bienmueble_id = bm.id',
			'condition'=>'t.traspaso_id='.$model->id, 
			'order'=>'bm.codigo ASC')
		);
		
		if(isset($_POST['BmTraspaso'])){
			date_default_timezone_set('America/Caracas'); 
			$fecha = date('Y-m-d H:i:s');
			$fecha2 = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s', strtotime($fecha)) . " +2 second"));
			
			foreach ($bienes as $item) {
				// Se coloca desincorporado para el dp origen
				$status_h0 = new BmMovimiento;
				$status_h0->bienmueble_id = $item->bienmueble_id;
				$status_h0->dependencia_id = $model->dependencia_id;
				$status_h0->concepto_id = 20; // 51: Desincorporacion por Traspaso
				$status_h0->fecha = $fecha;
				
				// Se coloca incorporado para el dp destino
				$status_h1 = new BmMovimiento;
				$status_h1->bienmueble_id = $item->bienmueble_id;
				$status_h1->dependencia_id = $model->receptor->dependencia->id;
				$status_h1->concepto_id = 2; // 02: Incorporacion por Traspaso
				$status_h1->fecha = $fecha2;
				
				if ($status_h0->save()) {
					if ($status_h1->save()) {
						$item->mov_origen_id = $status_h0->id;
						$status_h0->update();
						$item->mov_destino_id = $status_h1->id;
						$status_h1->update();
						
						if ($item->save()) {
							/*
							$bita = new Bitacora;
							$bita->operacion_id = 30;
							$bita->item_id = $model->id;
							$bita->descripcion = '';
							$bita->usuario_id = Yii::app()->user->getId();

							$bita->fecha = $fecha;
							if($bita->save()) {}
							*/
						} else {
							//print_r($model->getErrors()); exit;
						}
					}
					//else print_r($status_h0->getErrors()); exit;
				}
			}
			$model->status_id = 3;
			if ($model->save()) {
				$this->redirect(array('view','id'=>$id));
			}
			//else print_r($status_h0->getErrors()); exit;
			
		}
		
		$data = $model->getDataPDF( $model );
		
		$this->render('confirmar', array(
			'model'=>$model, 'data'=>$data, 'bienes'=>$bienes,
		));
	}
	
	/**
	 * Rechazar un traspaso entrante
	 */
	public function actionRechazar($id)
	{
		$model = $this->loadModel($id);
		
		if( $model->status_id == 2 ) {
			$model->status_id = 4;
			if ($model->save()) {
				$this->actionIndex($model->id);
			}
		}

	}

	public function actionImprimir($id)
	{
		$this->redirect(array('/bienmueble'));
	}
	
	/**
	 * Buscar Bienes Adscritos.
	 */
	public function actionSearchAjax()
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
        
        $this->renderPartial('_ajaxContent', $data, false, true);
	}
	//
	
	public function actionAdscribirAjax()
	{
		$data = array();
		$bm = Yii::app()->session['bmid'];
		$traspaso_id = Yii::app()->session['tid'];
		
		if (isset($traspaso_id)) {
			if (isset($bm) && isset($bm['id'])) {
				$bm_id =  $bm['id']; // Obtenido en UpdateAjax
				$it = BmTraspasoItem::model()->findAll(array(
					'join'=>'JOIN bienmueble as bm ON t.bienmueble_id = bm.id ',
					'condition'=>'t.traspaso_id='.$traspaso_id.' AND bm.id='.$bm_id )
				);
			
				if (count($it) < 1) {
					$ebm = new BmTraspasoItem;
					$ebm->traspaso_id = $traspaso_id;
					$ebm->bienmueble_id = $bm_id;
					if ($ebm->save()) {
						Yii::app()->session['bmid'] = NULL;
					}
					//else { print_r($ebm->getErrors()); exit; }
				}
			}
			
			$data['items'] = BmTraspasoItem::model()->findAll(array(
				'join'=>'JOIN bienmueble as bm ON t.bienmueble_id = bm.id',
				'condition'=>'t.traspaso_id='.$traspaso_id, 
				'order'=>'bm.codigo ASC')
			);
		}
		//print_r($data['items']); exit;
		
		$this->renderPartial('_ajaxContent2', $data, false, true);
	}

	/*
	 *
	 */
	public function actionActualizarAjax()
	{
		//Yii::app()->user->setFlash('error', NULL);
		$data = array();
		$tid = Yii::app()->session['tid'];
		if( isset($tid)) {
			$data['items'] = BmTraspasoItem::model()->findAll(array(
				'join'=>'JOIN bienmueble as bm ON t.bienmueble_id = bm.id',
				'condition'=>'t.traspaso_id='.$tid, 
				'order'=>'bm.codigo ASC')
			);
		}
		$this->renderPartial('_ajaxContent2', $data, false, true);
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=BmTraspaso::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='bm-traspaso-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
