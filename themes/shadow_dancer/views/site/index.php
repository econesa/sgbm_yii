<?php  
  $baseUrl = Yii::app()->theme->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile('http://www.google.com/jsapi');
  $cs->registerCoreScript('jquery');
  $cs->registerScriptFile($baseUrl.'/js/jquery.gvChart-1.0.1.min.js');
  $cs->registerScriptFile($baseUrl.'/js/pbs.init.js');
  $cs->registerCssFile($baseUrl.'/css/jquery.css');

  if (isset($username))
	echo "<p>Bienvenido, $username.</p>";
  $this->pageTitle=Yii::app()->name; 
?>

<div class="span-23 showgrid" style="min-height:410px">
	
<div class="dashboardIcons span-10" style="padding-left:18px">
    <div class="dashIcon dashIcon_yellow span-3" style="min-height:112px">
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/big_icons/icon-building.png" alt="Nosotros" /></a>
        <div class="dashIconText"><?php echo CHtml::link('Nosotros', array('/site/page', 'view'=>'about')); ?></div>
    </div>

	<div class="dashIcon dashIcon_yellow span-3">
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/big_icons/icon-barcode3.png" alt="Bienes" /></a>
        <div class="dashIconText"><?php echo CHtml::link('Inventario de Bienes', array('/bienmueble')); ?></div>
    </div>

	<div class="dashIcon dashIcon_yellow span-3">
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/big_icons/icon-box-open.png" alt="Traspaso de Bienes" /></a>
        <div class="dashIconText"><?php echo CHtml::link('Traspaso de Bienes', array('/traspaso')); ?></div>
    </div>

	<div class="dashIcon dashIcon_blue span-3">
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/big_icons/icon-clipboard.png" alt="Reportes" /></a>
        <div class="dashIconText"><?php echo CHtml::link('Reportes', array('/reporte')); ?></div>
    </div>
    
    <div class="dashIcon dashIcon_blue span-3">
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/big_icons/icon-book3.png" alt="Usuarios" /></a>
        <div class="dashIconText"><?php echo CHtml::link('Usuarios', array('/usuario')); ?></div>
    </div>

	<div class="dashIcon dashIcon_blue span-3">
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/big_icons/icon-people.png" alt="Personas" /></a>
        <div class="dashIconText"><?php echo CHtml::link('Personas', array('/persona')); ?></div>
    </div>

	<div class="dashIcon dashIcon_red span-3">
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/big_icons/icon-people2.png" alt="Personas" /></a>
        <div class="dashIconText"><?php echo CHtml::link('Responsables', array('/responsable')); ?></div>
    </div>

	<div class="dashIcon dashIcon_red span-3">
        <a href="#"><img src="<?php ///images/big_icons/icon-socket.png
        echo Yii::app()->theme->baseUrl; ?>/images/big_icons/icon-broken-key.png" alt="Bienes Faltantes" />
        </a>
        <div class="dashIconText"><?php echo CHtml::link('Bienes Faltantes', array('/fbm3')); ?></div>
    </div>
    
    <div class="dashIcon dashIcon_red span-3">
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/big_icons/icon-calculator.png" alt="Facturas" /></a>
        <div class="dashIconText"><?php echo CHtml::link('Facturas', array('/factura')); ?></div>
    </div>
</div><!-- END OF .dashIcons -->

<div class="span-5 last">
	<div class="dashIcon span-12" style="min-height:230px">
	</div>
</div>

</div>
