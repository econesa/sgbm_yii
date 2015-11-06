<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this PersonaController */
/* @var $model Persona */

$this->breadcrumbs=array(
	'Personas'=>array('index'),
	$model->pdata->cedula =>array('view','pid'=>$model->pdata_id),
	'Editar Cargo',
);

$this->menu=array(
	array('label'=>'Listar Personas', 'url'=>array('index')),
	array('label'=>'Registrar Persona', 'url'=>array('create')),
	array('label'=>'Mostrar Persona', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Modificar Cargo</h1>

<?php echo $this->renderPartial('_form_cp', array('model'=>$model, 'cargos'=>$cargos, 'dps'=>$dps, 'status'=>$status)); ?>
