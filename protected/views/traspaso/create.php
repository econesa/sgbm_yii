<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this TraspasoController */
/* @var $model BmTraspaso */
?>

<h1>Traspaso de Bienes Muebles</h1>
<h2>Paso 1: Seleccionar Destinatario y Bienes Adscritos</h2>

<?php echo $this->renderPartial('_form', 
	array('model'=>$model, 'bien'=>$bien, 'emisores'=>$emisores, 'receptores'=>$receptores)); 
?>