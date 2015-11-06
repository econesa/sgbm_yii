<?php
/* @var $this ResponsableController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Responsables',
);

$this->menu=array(
	array('label'=>'Responsable Nuevo', 'url'=>array('create')),
	array('label'=>'Ir a Reportes', 'url'=>array('/reporte')),
);
?>

<h1>Responsables</h1>

<p>El responsable es aquella persona que está encargada de firmar los documentos generados en este sistema de una o más dependencias.</p>

<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'grid-view',
    'columns'=>array(/*
		array(	'name'=>'Dependencia',
	           	'value'=>'$data->dependencia->descripcion',
	    ), */
        array(	'name'=>'persona',
           		'htmlOptions'=>array('style'=>'text-align: left'),
           		'value'=>'$data->persona->pdata->nombre',
        ), 
    	array( 'class'=>'CButtonColumn', 'template'=>'{mostrar}',
    		 'buttons'=>array(
		        'mostrar' => array (
		            'label'=>'Ver detalles',
		            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_view.png',
		            'url'=>'Yii::app()->createUrl("responsable/view", array("id"=>$data->id))',
		        ),
		    ),
    	)
    ),
    'summaryText' => 'Mostrando {start}-{end} de {count} registro(s).',
));
?>
