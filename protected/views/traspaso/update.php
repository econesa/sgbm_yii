<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this TraspasoController */
/* @var $model BmTraspaso */

$this->breadcrumbs=array(
	'Bm Traspasos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BmTraspaso', 'url'=>array('index')),
	array('label'=>'Create BmTraspaso', 'url'=>array('create')),
	array('label'=>'View BmTraspaso', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BmTraspaso', 'url'=>array('admin')),
);
?>

<h1>Update BmTraspaso <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>