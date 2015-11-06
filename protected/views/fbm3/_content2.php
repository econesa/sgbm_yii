<?php ?>

<?php 
if ( isset($items) && count($items) > 0 ) {
?>
<table class="items">
<thead>
<tr>
<th colspan="3" style="text-align:center;">Clasificacion</th>
<th rowspan="2" style="text-align:center;">Nro. ID</th>
<th rowspan="2" style="text-align:center;">Descripcion</th>
<th rowspan="2" style="text-align:center;">Cantidad</th>
<th rowspan="2" style="text-align:center;">Valor Unitario</th>
<th rowspan="2" style="text-align:center;"></th>
</tr>
<tr>
<th style="text-align:center;">Grupo</th>
<th style="text-align:center;">SubGrupo</th>
<th style="text-align:center;">Seccion</th>
</tr>
</thead>
<tbody>
<?php 
foreach( $items as $bien) { ?>
		<tr>
		<td style="text-align:center;"><p><?php echo $bien->bienmueble->clasificacion->grupo; ?></p></td>
		<td style="text-align:center;"><p><?php echo $bien->bienmueble->clasificacion->subgrupo; ?></p></td>
		<td style="text-align:center;"><p><?php echo $bien->bienmueble->clasificacion->seccion; ?></p></td>
		<td style="text-align:center; width:40px;"><p><?php echo $bien->bienmueble->codigo; ?></p></td>
		<td><p><?php echo CHtml::encode($bien->bienmueble->descripcion); ?></p></td>
		<td style="text-align:center;"><p><?php echo $bien->bienmueble->cantidad; ?></p></td>
		<td style="text-align:right;"><p><?php echo $bien->bienmueble->valor_unitario; ?></p></td>
		<td style="text-align:right;">
		<div>
			<?php 
			echo CHtml::link('Eliminar', array('deleteBma', 'id'=>$bien->id, 'fbmid'=>$bien->fbm3_id)); 
			?>
		</div>
		</td>
		</tr> <?php 
} ?>
</tbody>
</table>
<?php
}
?>

