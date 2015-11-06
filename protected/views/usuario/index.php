<?php
/* @var $this UsuarioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Usuarios',
);

$this->menu=array(
	array('label'=>'Crear Usuario', 'url'=>array('create')),
);
?>

<h1>Usuarios</h1>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'grid-view',
    'columns'=>array(
		'username',
      array(	'name'=>'rol',
         	'htmlOptions'=>array('style'=>'text-align: left'),
          'value'=>'$data->rol->descripcion',
      ),  
    	array( 'class'=>'CButtonColumn', 'template'=>'{mostrar}',
    		 'buttons'=>array(
		        'mostrar' => array (
		            'label'=>'Ver detalles',
		            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_view.png',
		            'url'=>'Yii::app()->createUrl("usuario/view", array("id"=>$data->id))',
		        ),
		    ),
    	)
    ),
    'summaryText' => 'Mostrando {start}-{end} de {count} registro(s).',
));
?>
