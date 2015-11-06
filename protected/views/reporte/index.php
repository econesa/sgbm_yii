<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this ReporteController */

$this->breadcrumbs=array(
	'Reportes',
);
?>
<h1>Reportes</h1>

<?php
if($valido==1):
    if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error" style="margin-bottom:0.5em;">
        <font style="color:red"><?php echo Yii::app()->user->getFlash('error'); ?></font>
    </div><?php

	echo '<ul>';
	echo '<li>'.CHtml::link('Ir a Responsables', array('/responsable')).'</li>'; 
	echo '</ul>';
     
    endif;
else :

echo '<ul>';
echo '<li>'.CHtml::link('Resumen de la Cuenta de Bienes (Formulario B.M.4)', array('/reporte/generar', 'formulario'=>4)).'</li>';
echo '<li>'.CHtml::link('Relación de Bienes Faltantes (Formulario B.M.3)', array('/reporte/generar', 'formulario'=>3)).'</li>';
//echo '<li>'.CHtml::link('Relación del Mantenimiento de Bienes', array('/mantenimiento')).'</li>';
echo '<li>'.CHtml::link('Relación de Movimiento de Bienes (Formulario B.M.2)', array('/reporte/generar', 'formulario'=>2)).'</li>';
echo '<li>'.CHtml::link('Inventario de Bienes (Formulario B.M.1)', array('/reporte/generar', 'formulario'=>1)).'</li>'; 
echo '</ul>';

endif;
?>


