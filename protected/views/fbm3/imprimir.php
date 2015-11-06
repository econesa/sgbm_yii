<?php
// CREAR PDF
	date_default_timezone_set('America/Caracas');  
	$pw=170;
	$lh=8;
	$pdf = new PDF('Landscape', 'mm', 'Letter', $header);
	
	$pdf->AddPage();
	$pdf->AliasNbPages();
	
	$pdf->TablaHeaderBM( $config['th'], $config['tw'], true );
	$pdf->Tabla( $config['th'], $config['td'], $config['tw'], $config['ta'], 1, 4 );
	$pdf->TablaFooter( $config['tdf'], $config['twf'], $config['taf']);
	
	$pdf->Ln(5);
	$pdf->Output();	
?>