<?php 
if (isset($items)) {
	if ( count($items) > 0 ) {	
		$cantidad_total = 0;
		$valor_total = 0;
		
		foreach( $items as $bien) { 
			$cantidad_total += $bien->bienmueble->cantidad;
			$valor_total += $bien->bienmueble->valor_unitario;
			?>
			<tr>
			<td style="text-align:center;"><p><?php echo $bien->bienmueble->clasificacion->grupo; ?></p></td>
			<td style="text-align:center;"><p><?php echo $bien->bienmueble->clasificacion->subgrupo; ?></p></td>
			<td style="text-align:center;"><p><?php echo $bien->bienmueble->clasificacion->seccion; ?></p></td>
			<td style="text-align:center; width:50px;">
				<p><?php echo $bien->bienmueble->codigo; ?></p>
			</td>
			<td><p><?php echo CHtml::encode($bien->bienmueble->descripcion); ?></p></td>
			<td style="text-align:center;"><p><?php echo $bien->bienmueble->cantidad; ?></p></td>
			<td style="text-align:right;">
				<p><?php echo sprintf("%.2F", $bien->bienmueble->valor_unitario);?></p>
			</td>
			<td style="text-align:right;">
				<div>
				<?php echo CHtml::link('Eliminar', array('removeBm', 'id'=>$bien->id)); ?>
				</div>
			</td>
			</tr><?php 
		} ?>
		<tr>
			<td colspan="5" style="text-align:right;">Total:</td>
			<td style="text-align:center;"><p><?php echo $cantidad_total; ?></p></td>
			<td style="text-align:right;">
				<p><?php echo sprintf("%.2F", $valor_total);?></p>
			</td>
			<td style="text-align:right;"></td>
		</tr>
<?php	
	}
}
?>

