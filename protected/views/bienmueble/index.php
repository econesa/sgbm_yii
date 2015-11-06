<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this BienmuebleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Inventario de Bienes',
);

$this->menu = array();
$i = 0;
$this->menu[$i++] = array('label'=>'Incorporar Bien', 'url'=>array('create'));
if ($acceso)
	$this->menu[$i++] = array('label'=>'Ver Resumen', 'url'=>array('verResumen'));


echo $this->renderPartial('_search', array('model'=>$filtro,'vars'=>$vars));
?>

<h1>Inventario de Bienes</h1>

<?php 
$this->widget('zii.widgets.grid.CGridView', 
	array(
		'dataProvider'=>$dataProvider,
		'id'=>'grid-view',
	    'columns'=>array(
			array(	'name'=>'#', 'htmlOptions'=>array('style'=>'width: 40px'),
	           		'value'=>'$data->codigo',
	        ),
			'descripcion',
	        array(	'name'=>'V U',	'htmlOptions'=>array('style'=>'text-align: right;'),
	           		'value'=>'number_format ( $data->valor_unitario, 2,",", " ")',
	        ),  
	    	array( 'class'=>'CButtonColumn', 'template'=>'{mostrar}{editar}',
	    		 'buttons' => array(
			        'mostrar' => array (
			            'label'=>'Ver detalles',
			            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_view.png',
			            'url'=>'Yii::app()->createUrl("bienmueble/view", array("id"=>$data->id))',
			      	),
					'editar' => array (
			            'label'=>'Modificar',
			            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_edit.png',
			            'url'=>'Yii::app()->createUrl("bienmueble/update", array("id"=>$data->id))',
			      	),
				)
	    	),
	    ),
	    'summaryText' => 'Mostrando {start}-{end} de {count} registro(s).',
	)
);
/*
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
*/
?>
