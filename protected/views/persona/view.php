<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this PersonaController */
/* @var $model Persona */

$this->breadcrumbs=array(
	'Personas'=>array('index'),
	'V-'.number_format ( $persona->cedula, 0, ',', '.' ),
);

$this->menu=array(
	array('label'=>'Listar Personas', 'url'=>array('index')),
	array('label'=>'Registrar Persona', 'url'=>array('create')),
	array('label'=>'Asociar Cargo', 'url'=>array('add', 'persona_id'=>$persona->id)),
	array('label'=>'Modificar Persona', 'url'=>array('update', 'id'=>$persona->id)),
	array('label'=>'Eliminar Persona', 'url'=>'#', 'linkOptions'=>array('submit'=>array('eliminar','id'=>$persona->id),'confirm'=>'¿Está seguro que desea eliminar este registro?')),
);
?>

<h1>Persona C.I. <?php echo number_format ( $persona->cedula, 0, ',', ' ' ); ?></h1>

<div class="dashboardIcons span-20" style="">
    <div class="dashIcon span-2" style="">
		<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/big_icons/icon-man-tie.png" alt="" />
	</div>
	<div class="span-16 white">
		<?php 		
		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$persona,
			'attributes'=>array(
				array( 'label'=>'C.I.', 'value'=> number_format ( $persona->cedula, 0, ',', ' ' )),
				'nombre',
				array( 'label'=>'Titulo', 'value'=> $persona->profesion->descripcion),
				array( 'label'=>'Fecha de Registro', 'value'=> Yii::app()->dateFormatter->format('dd/MM/yyyy',$persona->f_creacion)),
			),
		));
		?>
	</div>
</div>
<?php
if ($persona->sexo_id==1){
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'id'=>'grid-view',
	    'columns'=>array(
			array( 'name'=>'Cargo', 'value'=> '$data->cargo->descripcion'), //'htmlOptions'=>array('style'=>'text-align: left'),
	      array(	'name'=>'Dependencia', 'value'=>'$data->dependencia->descripcion'), 
	      array( 'name'=>'Status', 'value'=> '$data->status->descripcion'),
	    	array( 'class'=>'CButtonColumn', 'template'=>'{editar}{eliminar}',
	    		 'buttons'=>array(
			        'editar' => array (
			            'label'=>'Modificar',
			            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_edit.png',
			            'url'=>'Yii::app()->createUrl("persona/edit", array("id"=>$data->id))',
			        ),
					'eliminar' => array (
			            'label'=>'Eliminar Cargo',
			            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_delete.png',
			            'url'=>'Yii::app()->createUrl("persona/delete", array("id"=>$data->id))',
			        ),
			    ),
	    	)
	    ),
	    'summaryText' => 'Mostrando {start}-{end} de {count} registro(s).',
	));
}
else {
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'id'=>'grid-view',
	    'columns'=>array(
			array( 'name'=>'Cargo', 'value'=> '$data->cargo->desc_f'), //'htmlOptions'=>array('style'=>'text-align: left'),
	        array(	'name'=>'Dependencia', 'value'=>'$data->dependencia->descripcion'), 
	    	array( 'class'=>'CButtonColumn', 'template'=>'{editar}{eliminar}',
	    		 'buttons'=>array(
			        'editar' => array (
			            'label'=>'Modificar',
			            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_edit.png',
			            'url'=>'Yii::app()->createUrl("persona/edit", array("id"=>$data->id))',
			        ),
					'eliminar' => array (
			            'label'=>'Eliminar Cargo',
			            'imageUrl'=>Yii::app()->theme->baseUrl.'/images/icon_delete.png',
			            'url'=>'Yii::app()->createUrl("persona/delete", array("id"=>$data->id))',
			        ),
			    ),
	    	)
	    ),
	    'summaryText' => 'Mostrando {start}-{end} de {count} registro(s).',
	));
}


if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error" style="margin-bottom:0.5em;">
        <font style="color:red"><?php echo Yii::app()->user->getFlash('error'); ?></font>
    </div><?php 
endif;

?>
