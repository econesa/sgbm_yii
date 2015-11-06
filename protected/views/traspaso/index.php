<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this TraspasoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Traspasos de Bienes',
);

$this->menu=array(
	array('label'=>'Iniciar Traspaso', 'url'=>array('create')),
);
?>

<h1>Traspasos de Bienes</h1>

<?php 
/*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>

<div class="" style="background-color: #DFD; min-height:150px; padding:0.75em; margin-bottom:10px;">
<?php
if (isset($dataProviderR)) {
	echo '<h2>Traspasos Entrantes</h2>';
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProviderR,
		'itemView'=>'_view_e'
	)); 
}
?>
</div>
<div style="background-color: #FAFAFA; min-height:150px; padding:0.75em; ">
<?php
if (isset($dataProviderE)) {
	echo '<h2>Traspasos Salientes</h2>';
	
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProviderE,
		'itemView'=>'_view_s'
	)); 
}
echo '</br>';
?>
</div>