<?php 
if (isset($error) )
{
if (!$error) 
{
	if (isset($bm)) {
		//foreach ($bm as $bien) {
			$this->widget('zii.widgets.CDetailView', array(
				'data'=>$bm,
				'attributes'=>array(
					array(
						'label'=>'Nro. ID', 'type'=>'raw',
						'value'=>$bm['codigo']
					),
					array(               // related city displayed as a link
						'label'=>'Clasificacion - Codigo', 'type'=>'raw',
						'value'=>$bm['grupo'].'.'.$bm['subgrupo'].'-'.$bm['seccion'],
					),
					'descripcion',
					'valor_unitario'
				),
			));
			 
		//}
	}	
}
else
	echo '<font style="color:red;">'.$error.'</font>';
}
if(Yii::app()->user->hasFlash('error')):?>
    <div class="info">
        <font style="color:red"><?php echo Yii::app()->user->getFlash('error'); ?></font>
    </div>
<?php endif; 
?>
