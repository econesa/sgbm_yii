<?php
// CREAR PDF
$pdf = new PDF('Landscape', 'mm', 'Letter', $header);
$pdf->AliasNbPages();
$pdf->AddPage();

	$fs = 8;
	$lh = 8;
	
	$pdf->SetFont('Arial','',$fs);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Ln(2);
	$y = $pdf->getY();
	$x = $pdf->getX();
	$pdf->Celda(256, 160, '', 1, 1, '', true);
	$y2 = $pdf->getY();
	$pdf->setY($y+1);
	$pdf->setX($x+1);
	$pdf->Celda(20, 5, 'Estado: ', 0, 0, '', true);
	$pdf->Celda(100, 5, $pdf->capitalizar($header['estado']), 'B', 0, '', true);
	$pdf->Celda(20, 5, 'Municipio: ', 0, 0, '', true);
	$pdf->Celda(110, 5, $pdf->capitalizar($header['municipio']), 'B', 1, '', true);
	$y = $pdf->getY();
	$pdf->setY($y+1);
	$pdf->setX($x+1);
	$pdf->Celda(50, 5, 'Unidad de Trabajo o Dependencia: ', 0, 0, '', true);
	$pdf->Celda(200, 5, $pdf->capitalizar($header['dependencia']), 'B', 1, '', true);
	$yt = $pdf->getY();
	$pdf->setX($yt+1);
	$pdf->setX($x+1);
	$lh2 = 5;
	$yt = $pdf->getY();
	
	$pdf->setY($yt+5);
	$pdf->setX($x+1);
	$pdf->Celda(50, $lh2, utf8_decode('Correspondientes al mes y año'), 0, 0, '', true);
	$pdf->Celda(50, $lh2, $pdf->capitalizar($header['fecha']), 'B', 1, 'C', true);
	
	$pdf->setY($yt+15);
	$pdf->setX($x+1);
	$pdf->Celda(30, $lh2, 'Existencia Anterior: ', 0, 0, '', true);
	$pdf->setX($x+120);
	$pdf->Celda(50, $lh2, $data['existencia_anterior'], 'B', 1, 'C', true);
	$pdf->setY($yt+25);
	$pdf->setX($x+1);
	$pdf->Celda(30, $lh2, utf8_decode('Incorporación en el Mes: '), 0, 0, '', true);
	$pdf->setX($x+120);
	$pdf->Celda(50, $lh2, $data['incorporacion'], 'B', 1, 'C', true);
	$pdf->setY($yt+35);
	$pdf->setX($x+1);
	$pdf->Celda(60, $lh2, utf8_decode('Desincorporación en el Mes por Todos los Conceptos a Excepción del 60'), 0, 0, '', true); // "Faltantes de Bienes por Investigar"
	$pdf->setX($x+200);
	$pdf->Celda(50, $lh2, $data['desin_t'], 'B', 1, 'C', true);
	
	$pdf->setY($yt+45);
	$pdf->setX($x+1);
	$pdf->Celda(60, $lh2, utf8_decode('Desincorporación en el Mes por el Conceptos 60'), 0, 0, '', true); // Faltantes de Bienes por Investigar
	$pdf->setX($x+200);
	$pdf->Celda(50, $lh2, $data['desin_f'], 'B', 1, 'C', true);
	
	$pdf->setY($yt+55);
	$pdf->setX($x+1);
	$pdf->Celda(60, $lh2, utf8_decode('Existencia Final'), 0, 0, '', true);
	$pdf->setX($x+200);
	$pdf->Celda(50, $lh2, $data['existencia_final'], 'B', 1, 'C', true);
	
	$pdf->setY($yt+65);
	$pdf->setX($x+1);
	$pdf->Celda(60, $lh2, utf8_decode('TOTALES IGUALES'), 0, 0, '', true);
	$pdf->setX($x+120);
	$pdf->Celda(50, $lh2, $data['total'], 'B', 0, 'C', true);
	$pdf->setX($x+200);
	$pdf->Celda(50, $lh2, $data['total2'], 'B', 1, 'C', true);
	
	$pdf->setY($yt+100);
	$pdf->SetDrawColor( 0, 0, 0 );
	$y=$pdf->GetY();
	$pdf->SetY($y+30);
	$pdf->SetX($pdf->GetX()+8);
	$pdf->Cell(70,$lh, $pdf->capitalizar("{$header['responsable']}"),0,1,'C',false);
	$pdf->SetX($pdf->GetX()+8);
	$pdf->Cell(70,$lh, utf8_decode("Nombre y Apellido del {$header['cargo']}"),'T',0,'C',false);
	$pdf->SetX($pdf->GetX()+19);
	$pdf->Cell(70,$lh, 'Sello de la Unidad','T',0,'C',false);
	$pdf->SetX($pdf->GetX()+19);
	$pdf->Cell(70,$lh, "Firma",'T',1,'C',false);
	
	$pdf->Ln(5);

$pdf->Output('bm4.pdf','D');	

?>
