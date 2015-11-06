<?php
// CREAR PDF

$pdf = new PDF('Landscape', 'mm', 'Letter', $header);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->TablaHeaderBM( $data['thd'], $data['thw'], true );
$pdf->Tabla( $data['thd'], $data['items'], $data['thw'], $data['ta'], 1, $header['columna'] );
$pdf->TablaFooter( $data['tdf'], $data['twf'], $data['taf']);

$pdf->Output('bm1.pdf','D');	

?>
