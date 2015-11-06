<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this PersonaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Personas',
);

$this->menu=array(
	array('label'=>'Crear Persona', 'url'=>array('create')),
	array('label'=>'Ver Todas', 'url'=>array('list')),
);

echo $this->renderPartial('_search', array('model'=>$filtros, 'genero'=>$genero));
?>

<h1>Personas</h1>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'grid-view',
    'columns'=>array(
		'dependencia.descripcion',
        array(	'name'=>'persona',
           		'htmlOptions'=>array('style'=>'text-align: left'),
           		'value'=>'$data->pdata->nombre',
        ),  
    	array( 'class'=>'CButtonColumn', 'template'=>'{mostrar}',
    		 'buttons'=>array(
		        'mostrar' => array (
		            'label'=>'Ver detalles',
		            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_view.png',
		            'url'=>'Yii::app()->createUrl("persona/view", array("pid"=>$data->pdata_id))',
		        ),
		    ),
    	)
    ),
    'summaryText' => 'Mostrando {start}-{end} de {count} registro(s).',
));
?>