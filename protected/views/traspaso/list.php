<?php
$this->breadcrumbs=array(
	'Traspaso de Bienes'=>array('index'),
	'Historial de Traspasos',
);
?>

<h1>Historial de Traspasos de Bienes Muebles</h1>
<?php
	echo CHtml::button('Iniciar Traspaso', array('submit' => array('create')));
	echo CHtml::button('Listado de Bienes', array('submit' => array('Bienmueble/index')));
	echo CHtml::button('Traspasos Pendientes', array('submit' => array('index')));
	echo '<br/><br/>';
	
	if (isset($dataProvider)) {	
		$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
			'emptyText' => 'No hay resultados',
		    'summaryText' => 'Mostrando {start}-{end} de {count} registro(s).',
		)); 
	}
?>

