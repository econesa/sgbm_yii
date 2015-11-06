<?php
/* @author Elisa Conesa <econesa@gmail.com> */
$this->breadcrumbs=array(
	'Personas'=>array('index'),
	'Registrar',
);

$this->menu=array(
	array('label'=>'Listar Personas', 'url'=>array('index')),
);
?>

<h1>Registrar Persona</h1>

<?php echo $this->renderPartial('_form_cp', 
	array('model'=>$model, 'cargos'=>$cargos, 'dps'=>$dps)); 
?>