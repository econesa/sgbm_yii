<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this PersonaController */
/* @var $model Persona */

$this->breadcrumbs=array(
	'Personas'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Listar Personas', 'url'=>array('index')),
	array('label'=>'Ver Todas', 'url'=>array('list')),
);
?>

<h1>Registrar Persona</h1>

<?php echo $this->renderPartial('_form', array('pdata'=>$pdata, 'profesiones'=>$profesiones, 'genero'=>$genero)); ?>