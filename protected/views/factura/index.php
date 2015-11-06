<?php
/* @var $this FacturaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Facturas',
);

$this->menu=array(
	array('label'=>'Registrar Factura', 'url'=>array('create')),
);
?>

<h1>Facturas</h1>

<?php 
$this->widget('zii.widgets.grid.CGridView', 
	array(
		'dataProvider'=>$dataProvider,
		'id'=>'grid-view',
	    'columns'=>array(
			'numero',
	      'proveedor',  
	    	array( 'class'=>'CButtonColumn', 'template'=>'{mostrar}{editar}',
	    		 'buttons' => array(
			        'mostrar' => array (
			            'label'=>'Ver detalles',
			            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_view.png',
			            'url'=>'Yii::app()->createUrl("factura/view", array("id"=>$data->id))',
			      	),
					'editar' => array (
			            'label'=>'Modificar',
			            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_edit.png',
			            'url'=>'Yii::app()->createUrl("factura/update", array("id"=>$data->id))',
			      	),
				)
	    	),
	    ),
	    'summaryText' => 'Mostrando {start}-{end} de {count} registro(s).',
	)
);

?>
