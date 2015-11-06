<div style="float:left; padding: 0px 5px; width:45%;">

<div class="list">
	<p>Seleccione una Operación</p>
	<ul>
	<?php //if ($rol != 2) { ?>
	<li><?php echo CHtml::link('Inventario de Bienes', array('/bienmueble')); ?></li>
	<li><?php echo CHtml::link('Traspaso de Bienes', array('/traspaso')); ?></li>
	<li><?php echo CHtml::link('Reportes', array('/reporte')); ?></li>
	<?php 
	//} 
	//if ($rol == 2) { ?>
		<li><?php echo CHtml::link('Listado de Personas', array('/persona')); ?></li>
		<li><?php echo CHtml::link('Listado de Usuarios', array('/usuario')); ?></li>
	<?php //} ?>
	<li><?php echo CHtml::link('Sobre Nosotros', array('/site/page', 'view'=>'about')); ?></li>
	</ul>
</div>

</div>
<div style="float:right; width:50%; padding-right: 10px;">
<?php echo CHtml::image('images/grupo.jpg', 'Contraloria Municipal de Sucre'); ?>
</div>
