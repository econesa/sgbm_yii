<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this PersonaController */
/* @var $model Persona */

$this->breadcrumbs=array(
	'Personas'=>array('index'),
	'V-'.number_format ( $pdata->cedula, 0, ',', '.' ) => array('view','pid'=>$pdata->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Personas', 'url'=>array('index')),
	array('label'=>'Registrar Persona', 'url'=>array('create')),
	array('label'=>'Mostrar Persona', 'url'=>array('view', 'id'=>$pdata->id)),
);
?>

<h1>Modificar Persona C.I <?php echo number_format ( $pdata->cedula, 0, ',', ' ' ); ?></h1>

<?php echo $this->renderPartial('_form', array('pdata'=>$pdata, 'profesiones'=>$profesiones, 'genero'=>$genero)); ?>