<?php

class ResponsableController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','delete','cambiarStatus'),
				'users'=>array('@'),
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
	public function actionView($id)
	{
		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );
		$acceso = Usuario::privilegiado($user->rol_id);
			
		$this->render('view',array(
			'model'=>$this->loadModel($id), 'acceso'=>$acceso
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );
		$acceso = Usuario::privilegiado($user->rol_id);
		date_default_timezone_set('America/Caracas'); 
      $fecha = date('Y-m-d H:i:s');
		
		$model = new Responsable;
		$model->dependencia_id = $user->dependencia_id;	
		$model->fecha = $fecha;

		if(isset($_POST['Responsable']))
		{
			$model->attributes=$_POST['Responsable'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$dps = Dependencia::model()->findAll( array('condition'=>'sede_id=1', 'order'=>'descripcion ASC') );
		$status = BmStatus::model()->findAll();
		$personas = Persona::model()->listAll();
		
		$this->render('create',array(
			'model'=>$model, 'dps'=>$dps, 'status'=>$status, 'personas'=>$personas, 'acceso'=>$acceso
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );
		$acceso = Usuario::privilegiado($user->rol_id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Responsable']))
		{
			$model->attributes=$_POST['Responsable'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$status = BmStatus::model()->findAll();
		$personas = Persona::model()->listAll();

		$this->render('update',array(
			'model'=>$model, 'status'=>$status, 'personas'=>$personas, 'acceso'=>$acceso
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionCambiarStatus($id)
	{
		$model = $this->loadModel($id);
		if ($model->status_id < 2)
			$model->status_id = 2;
		else
			$model->status_id = 1;
			
		if ( $model->save() )
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view', 'id'=>$id));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$user = Usuario::model()->findbyPk( Yii::app()->user->getId() );
		$condition = '';
		$acceso = 0;

		if ($user->rol_id > 3) {
			$condition = 'dependencia_id='.$user->dependencia_id;
		}
		else
			$acceso = 1;

		$dataProvider = new CActiveDataProvider('Responsable', array(
		      'pagination'=>array('pageSize' => 10,),
		      'criteria'=> new CDbCriteria(
					array('condition' => $condition,)
		    	),
		   )
		);
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Responsable::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='responsable-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
