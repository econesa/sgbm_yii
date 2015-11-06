<?php
/* @var $this Fbm3Controller */
/* @var $model Fbm3 */

$this->breadcrumbs=array(
	'Formularios B.M.3'=>array('index'),
	$model->comprobante,
);

$this->menu=array(
	array('label'=>'Listar B.M.3', 'url'=>array('index')),
	array('label'=>'Crear B.M.3', 'url'=>array('create')),
	array('label'=>'Modificar B.M.3', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar B.M.3', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Está seguro que desea anular este formulario B.M.3, se eliminaran los cambios asociados?')),
	array('label'=>'Imprimir B.M.3', 'url'=>array('imprimir', 'id'=>$model->id), 'linkOptions'=>array('target'=>'_blank')),
);
?>

<h1>Formulario B.M.3 #<?php echo $model->comprobante; ?></h1>

<?php 
$responsable = '';
if (isset($model->responsable->persona)) :
	$responsable = $model->responsable->persona->pdata->nombre;
endif;

$determinante = '';
if (isset($model->observador)) :
	$determinante = $model->observador->pdata->nombre;
endif;
 
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'comprobante',
		array( 	'label'=> CHtml::encode($model->getAttributeLabel('dependencia_id')), 'type'=>'text',
				'value'=> $model->dependencia->descripcion
		),
		array( 	'label'=> CHtml::encode($model->getAttributeLabel('responsable_id')), 'type'=>'text',
				'value'=> $responsable
		),
		array( 	'label'=> CHtml::encode($model->getAttributeLabel('observador_id')), 'type'=>'text',
				'value'=> $determinante
		),
		'observaciones',
		'fecha'
	),
)); 
?>
<h2>Bienes Faltantes</h2>
<?php
echo $this->renderPartial('_table_bma', array('bienes'=>$items)); 

if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error" style="margin-bottom:0.5em;">
        <font style="color:red"><?php echo Yii::app()->user->getFlash('error'); ?></font>
    </div><?php 
endif;
?>

