<?php

class PersonaController extends Controller
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
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'	=> array('index','view','list','create','update', 'add', 'edit', 'delete', 'eliminar', 'delete'),
				'users'		=> array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index'),
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
	public function actionView($pid)
	{
		$persona = PersonaData::model()->findByPk($pid);
		if (isset($persona)) {
			$dataProvider = new CActiveDataProvider('Persona', array(
				'criteria'=> new CDbCriteria(
					array('condition'=>'pdata_id='.$persona->id)
				),
			));
			
			$this->render('view',array(
				'persona'=>$persona, 'dataProvider'=>$dataProvider,
			));
		}
		else {
			$this->redirect(array('index'));
		}	
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{	
		$pdata = new PersonaData;
		
		if(isset($_POST['PersonaData']))
		{
			date_default_timezone_set('America/Caracas'); 
            $fecha = date('Y-m-d H:i:s');
			
			$pdata->attributes = $_POST['PersonaData'];
			$pdata->f_cambios = $fecha;
			
			if( $pdata->validate() ) {
				$persona = PersonaData::model()->findByAttributes(array('cedula'=>$pdata->cedula));
				if (isset($persona)) {
					$persona->attributes = $_POST['PersonaData'];
					$persona->f_cambios = $fecha;
					if( $persona->update() ) {
						$this->redirect(array('add','persona_id'=>$persona->id));
					}
				}
				else {
					$pdata->f_creacion = $fecha;

					if( $pdata->save() ) {
						$this->redirect(array('add','persona_id'=>$pdata->id));
					}
				}
			}
			//else print_r($persona->getErrors()); exit;
		}
		
		$profesiones = Profesion::model()->findAll( array('select' => 'id, descripcion', 'order'=>'descripcion ASC') );		
		$genero = Sexo::model()->findAll( array('select' => 'id, descripcion', 'order'=>'descripcion ASC') );

		$this->render('create',array(
			'pdata'=>$pdata, 'profesiones'=>$profesiones, 'genero'=>$genero
		));
		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$pdata = PersonaData::model()->findByPk($id);
		
		if(isset($_POST['PersonaData']))
		{
			$pdata->attributes=$_POST['PersonaData'];
			$persona = PersonaData::model()->findByAttributes(array('cedula'=>$pdata->cedula));
			if ($persona->id==$pdata->id) {
				if($pdata->update())
					$this->redirect(array('view','pid'=>$pdata->id));
			}
			else {
				$pdata->id = NULL;
				if($pdata->validate());
			}
		}
		
		$profesiones = Profesion::model()->findAll( array('select' => 'id, descripcion', 'order'=>'descripcion ASC') );
		$genero = Sexo::model()->findAll( array('select' => 'id, descripcion', 'order'=>'descripcion ASC') );

		$this->render('update',array(
			'pdata'=>$pdata, 'profesiones'=>$profesiones, 'genero'=>$genero
		));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['Persona']))
		{
			$model->attributes=$_POST['Persona'];
			if($model->update())
				$this->redirect(array('view','pid'=>$model->pdata_id));
		}
		
		if ($model->pdata->sexo_id==1)
			$cargos = Cargo::model()->findAll(array('order'=>'descripcion ASC'));
		else
			$cargos = Cargo::model()->findAll(array('select'=>'id, desc_f as descripcion', 'order'=>'descripcion ASC'));
		$dps = Dependencia::model()->findAll( array('condition'=>'sede_id=1', 'order'=>'descripcion ASC') );
		$status = BmStatus::model()->findAll();
		
		$this->render('edit',array(
			'model'=>$model, 'cargos'=>$cargos, 'dps'=>$dps, 'status'=>$status
		));
	}
	
	/**
	 * Asociar Cargo
	 */
	public function actionAdd($persona_id)
	{
		$persona = PersonaData::model()->findByPk($persona_id);
		if (isset($persona)) 
		{
			$model=new Persona;
			$model->pdata_id = $persona->id;
			$model->status_id = 1;
			
			if(isset($_POST['Persona']))
			{
				$model->attributes = $_POST['Persona'];
				date_default_timezone_set('America/Caracas'); 
				$fecha = date('Y-m-d H:i:s');           
				$model->fecha = $fecha;
				if( $model->save() ) {
					$this->redirect(array('view','pid'=>$model->pdata_id));
					//else print_r($model->getErrors()); exit;
				}
				//else print_r($persona->getErrors()); exit;
			}
			if ($persona->sexo_id==1)
				$cargos = Cargo::model()->findAll(array('order'=>'descripcion ASC'));
			else
				$cargos = Cargo::model()->findAll(array('select'=>'id, desc_f as descripcion', 'order'=>'descripcion ASC'));
			$dps = Dependencia::model()->findAll(array('condition'=>'sede_id=1', 'order'=>'descripcion ASC'));
			
			$this->render('add',array(
				'persona_id'=>$persona->id,'model'=>$model, 'cargos'=>$cargos, 'dps'=>$dps
			));	
		}
		else
			$this->redirect(array('create'));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		
		$existeR = Responsable::model()->exists('persona_id='.$model->id); 
		$existeT = BmTraspaso::model()->exists('emisor_id='.$model->id.' OR receptor_id='.$model->id); 
		$existeF = FBm3::model()->exists('observador_id='.$model->id); 
		$pdata_id = $model->pdata_id;
		if (!$existeR && !$existeT && !$existeF ) {
			$model->delete();
			$this->redirect(array('view','pid'=>$pdata_id));
		}
		else {
			Yii::app()->user->setFlash('error', 'No puede efectuarse la operación. Existen registros que utilizan este dato.');
			$this->redirect(array('view','pid'=>$pdata_id));
		}
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionEliminar($id)
	{
		$eliminadas = 0;
		$fallos = 0;

		$model = PersonaData::model()->findByPk($id);
		$personas = Persona::model()->findAll(array('condition'=>'pdata_id='.$model->id));
		foreach ($personas as $persona) {
			$existeR = Responsable::model()->exists('persona_id='.$persona->id); 
			$existeT = BmTraspaso::model()->exists('emisor_id='.$persona->id.' OR receptor_id='.$persona->id); 
			$existeF = FBm3::model()->exists('observador_id='.$persona->id);
			if (!$existeR && !$existeT && !$existeF ) {
				$persona->delete();
				$eliminadas++; 
			}
			else
				$fallos++;
		}
		
		if ($fallos==0) {
			$model->delete();
			$this->redirect(array('index'));
		}	
		else {
			Yii::app()->user->setFlash('error', 'No puede efectuarse la operación. Existen registros que utilizan este dato.');
			$this->redirect(array('view','pid'=>$model->id));
		}
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$filtro = new PersonaFiltro;
		
		if(isset($_GET['PersonaFiltro'])) {
			$filtro->attributes = $_GET['PersonaFiltro'];
		}
		
		$genero = Sexo::model()->findAll( array('select' => 'id, descripcion', 'order'=>'descripcion ASC') );
		$dataProvider = $filtro->search();
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'filtros'=>$filtro, 'genero'=>$genero
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{	
		//$personas = PersonaDtata::model()->findAll();
		$dataProvider = new CActiveDataProvider('PersonaData', array(
			'pagination'=>array('pageSize'=>6,),
			'criteria'=>new CDbCriteria(
				array(
					//'join' =>  'LEFT JOIN responsable r ON r.id = t.receptor_id',
					//'condition' => 't.status_id=2 AND p.dependencia_id='.$dp_id,
			        //'order'=>'fecha DESC, status_id ASC',
	    		)
	    	),
		));
		
		$this->render('list',array(
			'dataProvider'=>$dataProvider
		));
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Persona::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='persona-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
