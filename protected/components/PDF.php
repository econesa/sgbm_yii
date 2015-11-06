<?php
/*
* Clase PDF
* @version 1.0.1b 01/06/2012
*/

@require('fpdf/fpdf.php');

class PDF extends FPDF {

	var $orientation;
	var $familia;
	var $tamano;
	var $pageHeight; 
	var $primera_pagina_con_pie = true;
	var $ancho;
	var $titulo_tabla;
	var $plantilla;
	var $op_actual;
	var $pagina_nueva;
	var $tw;  // arreglo con anchos de columnas de la tabla
	
	var $flowingBlockAttr;
	
	
// ===============================================================================
// 	Encabezado de los PDFs
// ===============================================================================
	
	public function Header() {
		$this->SetLeftMargin( 20 );
		$this->SetFillColor( 255, 255, 255 );
		
		switch ($this->plantilla) {
			case 1:
			$this->EncabezadoFBM1_Info();
			break;
			
			case 2:
			$this->EncabezadoFBM1();
			break;
			
			case 3:
			$this->EncabezadoFBM2();
			break;
			
			case 4:
			$this->EncabezadoFBM3();
			break;
			
			case 5:
			//$this->SetLeftMargin( 10 );
			$y1 = $this->getY();
			$x1 = $this->getX();
			$this->Celda(75, 23, '', 1, 0, '', true);
			$y2 = $this->getY();
			$x2 = $this->getX();
			$this->Celda(150, 23, '', 1, 0, '', true);
			$y3 = $this->getY();
			$x3 = $this->getX();
			$this->Celda(28, 23, '', 1, 1, '', true);
			$y4 = $this->getY();
			$x4 = $this->getX();
			$this->setY($y1);
			$this->setX($x1);
			$this->Image( 'images/logo_medium.png', 22, 11, 68 );
			$this->setY($y2+5);
			$this->setX($x2+1);
			$this->Formato( 'Helvetica', 'B', 10 );
			$this->Celda(162, 6, 'Formulario B.M.4', 0, 1, 'C', true);
			$this->Formato( 'Helvetica', '', 8 );
			$this->setX($x2+1);
			$this->Celda(162, 8, 'Resumen de la Cuenta de Bienes', 0, 1, 'C', true);
			$this->setY($y3);
			$this->setX($x3);
			$this->Celda(31, 8, 'HOJA Nro.', 1, 1, 'C', true);
			$this->setX($x3);
			$this->Celda(31, 15, $this->header['hoja'], 1, 1, 'C', true);
			$this->setY($y4);
			$this->setX($x4);
			break;
			
			case 6:
			$this->EncabezadoFBM5();
			break;
		}
	}
	
	
//=================================================================================
// 	Pie de Pagina de los PDFs - Imprime el numero de Pagina
//=================================================================================
	
	public function Footer() {
		$this->SetY(-20);
		if ( ($this->PageNo() == 1 && $this->primera_pagina_con_pie) || $this->PageNo() != 1 ) {
			//$this->SetY(-15); //Position at 1.5 cm from bottom
			//$this->Formato( $this->familia, 'I', 8 );
			//$this->Celda( 0, 10, 'Página '.$this->PageNo().'/{nb}',0, 0, 'C');
		}
		switch ($this->plantilla) {
			case 1:
			/*
			$this->SetFillColor( 0, 0, 0 );
			$this->Celda( $this->ancho-10, 0.2, '', 0, 1, '', true );
			$this->Ln();
			$this->SetFillColor(255, 255, 255);
			$this->Celda( $this->ancho-10, 0.2, '', 0, 1, '', true );
			$this->Ln();
			$this->SetFillColor( 0, 0, 0 );
			$this->Celda( $this->ancho-10, 0.2, '', 0, 1, '', true );
			$this->Ln();
			$this->Formato( 'Helvetica', '', 9	 );
			$this->Celda( $this->ancho-10, 4, "\"CONTRALORES SOMOS TODOS\"", 0, 1, 'C');
			$this->SetY(-20);
			$this->SetFont('','',6);
			$this->Celda( $this->ancho-10, 6, "C.M.S.= U.B.M. - 07(09-08-2010)", 0, 1, 'R');
			*/
			break;
			
			case 2:
			$this->SetY(-25);
				$this->Formato( 'Helvetica', '', 10 );
				$this->SetFillColor(255, 255, 255 );
				$this->Celda( 256, 6, utf8_decode($this->header['responsable']), 0, 1, 'R', true );
				$this->Celda( 256, 6, 'Nombre y Apellido del '.utf8_decode($this->header['cargo']), 0, 1, 'R', true );
				$this->Celda( 50, 6, 'Sello de la Unidad', 0, 0, 'C', true );
				$this->Celda( 206, 6, 'Firma', 0, 1, 'R', true );
			break;

			case 3:
			$this->SetY(-25);
				$this->Formato( 'Helvetica', '', 10 );
				$this->SetFillColor(255, 255, 255 );
				$this->Celda( 256, 6, utf8_decode($this->header['responsable']), 0, 1, 'R', true );
				$this->Celda( 256, 6, 'Nombre y Apellido del '.utf8_decode($this->header['cargo']), 0, 1, 'R', true );
				$this->Celda( 50, 6, 'Sello de la Unidad', 0, 0, 'C', true );
				$this->Celda( 206, 6, 'Firma', 0, 1, 'R', true );
			
			break;
			
			case 4:
			$this->SetY(-60);
			$this->SetFillColor( 0, 0, 0 );
			$this->Celda( $this->ancho-100, 0.2, '', 0, 1, '', true );
			$this->SetFillColor( 255, 255, 255 );
			$y = $this->GetY();
			$this->Celda( 120, 48, '', 1, 0, '', true );
			$x = $this->GetX();
			$this->Celda( 136, 48, '', 1, 1, '', true );
			$x2 = $this->GetX();
			
			$this->SetY($y+1);
			$this->SetX($x+1);
			$this->Celda( 66, 7, '12. Faltantes Determinados por:', 0, 0, '', true );
			$this->Celda( 65, 7, utf8_decode($this->header['cp_nombre']), 'B', 1, '', true );
			$this->SetX($x+1);
			$this->Celda( 66, 7, '13. Cargo que Desempeña:', 0, 0, '', true );
			$this->Celda( 65, 7, utf8_decode($this->header['cp_cargo']), 'B', 1, '', true );
			$this->SetX($x+1);
			$this->Celda( 66, 7, '14. Dependencia a la Cual está Adscrito:', 0, 0, '', true );
			$this->Celda( 65, 7, utf8_decode($this->header['cp_dp']), 'B', 1, '', true );
			$this->SetX($x+1);
			$this->Celda( 66, 7, '15. Firma', 0, 0, '', true );
			$this->Celda( 65, 7, '', 'B', 1, '', true );
			$this->SetX($x+1);
			$this->Celda( 66, 7, '16. Jefe de Unidad de Trabajo:', 0, 0, '', true );
			$this->Celda( 65, 7, utf8_decode($this->header['responsable']), 'B', 1, '', true );
			$this->SetX($x+1);
			$this->Celda( 66, 7, '17. Firma', 0, 0, '', true );
			$this->Celda( 65, 7, '', 'B', 1, '', true );
			
			$this->SetY($y+1);
			$this->SetX($x2+1);
			$this->Celda( 35, 6, '11. Observaciones:', 0, 1, '', true );
			
			$this->SetX($x2+3);
			$this->MultiCell( 114, 6, utf8_decode($this->header['observaciones']),'','');
			// 
			$this->Ln();
			$this->SetY(-11);
			$this->SetFont('','',7);
			$this->Celda( $this->ancho-10, 6, "C.M.S.= U.B.M. - 15(17-12-2007)", 0, 1, 'R');
			break;
			
			default:
			break;
		}
	}
	
	// ==========================================================================================
	// 	Establece el formato a utilizar al imprimar una celda
	// 		SetFont(string family [, string style [, float size]])
	// ==========================================================================================
	
	public function Formato( $familia, $estilo = '', $tamano = 8 ) {
		if ( $familia != '' ) {
			$this->familia = $familia;
		}
		$this->tamano = $tamano;
		$this->SetFont( $this->familia, $estilo, $this->tamano );
	}
	
	
// ==============================================================================
// 	Imprime una celda
// 	Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align 
//			[, boolean fill [, mixed link]]]]]]])
// ================================================================================
	
	public function Celda( $w, $h, $txt, $borde = 0, $ln = 1, $align = 'L', $fill = false, $link = '' )
	{
		$this->Cell( $w, $h, $txt, $borde, $ln, $align, $fill, $link );
	}
	
	
// ================================================================================
// 	Dibuja una línea
// ================================================================================
	
	public function Linea( $x1, $y1, $x2, $y2 ){
		$this->Line( $x1, $y1, $x2, $y2 );
	}
	
	
// ================================================================================
// 	Generar PDF
// ================================================================================
	
	public function Generar( ){
		$this->Output();
	}
	
	
// ================================================================================
// 	Imprime el Encabezado de una Tabla
// ================================================================================
	
	public function TablaHeaderBM( $headings, $header, $fill ) {
		if ($fill) 
			$this->SetFillColor( 184, 184, 184 );
		else
			$this->SetFillColor( 255, 255, 255 );
	    $this->SetTextColor( 0 );
	    $this->SetDrawColor( 0, 0, 0 );
	    $this->SetFont('Arial','B', 7);
		
		$y = $this->getY();
		$x = $this->getX();
		$wi = $header[0]+$header[1]+$header[2];
		
		if ($wi > 0) {
			$this->Celda($wi , 8, '', 1, 0, 'C', true );
			//,
			$i = 3;
		    foreach ($headings as $th) {
		        $this->Celda( $header[$i], 8, $th, 1, 0, 'C', true );
				$i++;
			}
			$this->Ln();
			$y2 = $this->getY();
			$x2 = $this->getX();

			$this->setY($y);
			$this->setX($x);
			$this->SetFont('','B', 7);
			
			$this->Celda($wi , 4, utf8_decode('CLASIFICACION'), 1, 1, 'C', true );
			$this->SetFont('','B', 6);
			$this->Celda($header[0], 4, 'GRUPO', 1, 0, 'C', true );
			$this->Celda($header[1], 4, 'SUBGRUPO', 1, 0, 'C', true );
			$this->Celda($header[2], 4, 'SECCIÓN', 1, 1, 'C', true );
			
			$this->setY($y2);
			$this->setX($x2);
		}
		
	}
	
	public function TablaHeader( $header ) {
		$this->SetFillColor( 255, 255, 255 );
	    $this->SetTextColor( 0 );
	    $this->SetDrawColor( 0, 0, 0 );
	    $this->SetFont('Arial','B', 8);
		
		$i = 0;
	    foreach ($header['th'] as $th) {
	        $this->Celda( $header['tw'][$i], 7, $th, 1, 0, 'C', true );
			$i++;
		}
		$this->Ln();
	}
	
// ================================================================================
// 	Imprime el Pie de una Tabla
// ================================================================================
	
	public function TablaFooter( $td, $tw, $ta=array('C','C') ) {
	    $this->SetTextColor( 0 );
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B', 9);
		$lh=6;
		$this->SetDrawColor( 0, 0, 0 );
		$this->SetFillColor( 0, 0, 0 );
		$this->Celda( array_sum($this->tw), 0.5, '', 0, 1, '', true );
		$this->SetFillColor( 255, 255, 255  );
		
		$this->Celda( $tw[0], $lh, $td[0], 1, 0, 'R', true );
		for ( $i = 1; $i < count($td); $i++ ) {
	        $this->Celda( $tw[$i], $lh, $td[$i], 1, 0, $ta[$i], true );
		}
	    $this->Ln();
		$this->Ln(5);
	}
	
	
// ===============================================================================
// 	Funciones para setear bandera que crea una nueva pagina
// ===============================================================================
	
	public function AcceptPageBreak() {
		$this->pagina_nueva = true;
	    return false;
	}
	
	public function IsPageBreak() {
		return $this->pagina_nueva;
	}
	
	public function SetPageBreak( $bool ) {
		$this->pagina_nueva = $bool;
	}
	
// ================================================================================
// Imprime una Tabla con su Encabezado
// ================================================================================
	
	public function Tabla( $header, $data, $config, $ta, $contigua = 0, $col_spe = 0 ) {
		$this->op_actual 	= 'tabla';
		$this->tw = $config;
		
		if ( $contigua == 0 || $this->getY() > ($this->pageHeight) ) {
			$this->AddPage();
		}
		$this->pagina_nueva = false;
	    
		// Data
	    $this->SetFillColor(250,250,250);
	    $this->SetDrawColor(0,0,0);
	    $this->SetTextColor(0);
	    $this->SetFont('','',10);
	    $fill = false;
		
		if ($col_spe == 0)
			$col = 4;
		else
			$col = $col_spe;

		$xw = 0;
		// sumar ancho de columnas anteriores
		for ($c = 0; $c < $col; $c++)
			if (isset($this->tw[$c]))
				$xw += $this->tw[$c];
		
		$i = 0;
		foreach( $data as $row ) {
			if ( $this->getY() > ($this->pageHeight-20) ) {
				$this->Cell(array_sum($this->tw),0,'','T');
				$this->Ln();
				$this->AddPage();
				$y=$this->GetY();
				//$this->SetY($y+4);
				$this->TablaHeaderBM( $header, $config, true );
				$this->SetFont('','',10);
				$this->pagina_nueva = false;
				$fill = false;
			}
			$multi =  0;

			$y=$this->GetY();
			$x=$this->GetX();
			
			$x2 = $x + $xw;
			$this->SetX($x2);
			//$this->SetTextColor(255,0,0);
			$this->MultiCell( $this->tw[$col], 5, $this->capitalizar($row[$col]),1,$ta[$col]);
			$multi = $this->GetY();
			$multi_x = $this->GetX();
			$inter_y = $multi - $y;
			$this->SetY($y);
			$this->SetX($x);

			//$this->SetDrawColor( 200, 200, 200 );
			
			for ( $j = 0; $j < count($row); $j++ ) {	
				switch ($j) {
				case $col:
					$this->SetX($x2+$this->tw[$col]);
					break;
				default:
					$y=$this->GetY();
					$x=$this->GetX();
					$this->MultiCell( $this->tw[$j], $inter_y, $row[$j],1,$ta[$j]); // ,$fill)
					$this->SetY($y);
					$this->SetX($x+$this->tw[$j]);
				}
			}
			
			if ($multi>0)
				$this->SetY($multi);
			else
				$this->Ln();
			$fill=!$fill;
			$i++;
		}
		
	    $this->Celda(array_sum($this->tw),0,'','T');
		$this->Ln();
		$this->op_actual = '';
	}

// ===============================================================================
// 	Encabezado para el Formulario B.M.1
// ===============================================================================
	
	public function EncabezadoFBM1() {	
		$fs = 10;
		$ancho = 256;
		$this->SetFont('Arial','',$fs);
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		
		$text = 'Página '.$this->PageNo().' de {nb}';
		$this->SetFont('Arial','',8);
		$this->Celda(100, 6, 'C.M.S.= U.B.M. - 07(09-08-2010)', 0, 0, '');
			
		$this->SetFont('Arial','',$fs);
		$this->Celda(156, 6, $text, 0, 1, 'R', true);
		$y1 = $this->getY();
		$x1 = $this->getX();
		$this->Celda(80, 23, '', 1, 0, '', true);
		$y2 = $this->getY();
		$x2 = $this->getX();
		$this->Celda($ancho-80, 23, '', 1, 1, '', true);
		$this->setY($y1);
		$this->setX($x1);
		$this->Image( 'images/logo_medium.png', 21, 17, 68 );
		$this->setY($y2+5);
		$this->setX($x2+1);
		$this->Formato( 'Helvetica', 'B', 11 );
		$this->Celda($ancho-84, 6, 'FORMULARIO B.M.1', 0, 1, 'C', true);
		$this->Formato( 'Helvetica', '', 9 );
		$this->setX($x2+1);
		$this->Celda($ancho-84, 8, 'INVENTARIO DE BIENES MUEBLES', 0, 1, 'C', true);
		
		$fs = 8;
		$this->SetFont('Arial','',$fs);
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		$this->Ln(6);
		
		$y = $this->getY();
		$x = $this->getX();
		$this->Celda(256, 28, '', 1, 1, '', true);
		$y2 = $this->getY();
		$this->setY($y+1);
		$this->setX($x+1);
		$this->Celda(30, 5, '1. Entidad Propietaria: ', 0, 0, '', true);
		$this->Celda(215, 5, 'MUNICIPIO SUCRE', 'B', 1, '', true);
		$yt = $this->getY();
		$this->setX($yt+1);
		$this->setX($x+1);
		$this->Celda(20, 5, '2. Servicio: ', 0, 0, '', true);
		$this->Celda(225, 5, $this->capitalizar($this->header['servicio']), 'B', 1, '', true);
		$yt = $this->getY();
		$this->setX($yt+1);
		$this->setX($x+1);
		$this->Celda(50, 5, '3. Unidad de Trabajo o Dependencia: ', 0, 0, '', true);
		$this->Celda(195, 5, $this->capitalizar($this->header['dependencia']), 'B', 1, '', true);
		$yt = $this->getY();
		$this->setX($yt+1);
		$this->setX($x+1);
		$this->Celda(20, 5, '4. Estado: ', 0, 0, '', true);
		$this->Celda(120, 5, $this->capitalizar($this->header['estado']), 'B', 0, '', true);
		$this->Celda(20, 5, '5. Municipio: ', 0, 0, '', true);
		$this->Celda(85, 5, $this->capitalizar($this->header['municipio']), 'B', 1, '', true);
		$yt = $this->getY();
		$this->setX($yt+1);
		$this->setX($x+1);
		$this->Celda(30, 5, '6. Direccion o Lugar: ', 0, 0, '', true);
		$this->Celda(110, 5, $this->capitalizar($this->header['direccion']), 'B', 0, '', true);
		$this->Celda(20, 5, '7. Fecha: ', 0, 0, '', true);
		$this->Celda(85, 5, $this->capitalizar($this->header['fecha']), 'B', 0, '', true);
		$this->setY($y2);
	}	

	public function EncabezadoFBM1_Info() {	
		$fs = 12;
		$ancho = 256;
		$this->SetFont('Arial','',$fs);
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		
		$text = 'Página '.$this->PageNo().' de {nb}';
		$this->SetFont('Arial','',$fs);
		$this->Celda($ancho, 10, 'INVENTARIO DE BIENES MUEBLES', 0, 1, 'L', true);
		
		$fs = 8;
		$this->SetFont('Arial','',$fs);
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		
		$this->Celda(25, 5, 'Dependencia: ', 0, 0, '', true);
		$this->Celda(195, 5, $this->capitalizar($this->header['dependencia']), 'B', 1, '', true);
		$this->Celda(25, 5, 'Fecha: ', 0, 0, '', true);
		$this->Celda(95, 5, $this->capitalizar($this->header['fecha']), 'B', 1, '', true);
		$this->Ln(6);
	}
	
// ===============================================================================
// 	Encabezado para el Formulario B.M.2
// ===============================================================================
	
	public function EncabezadoFBM2() {	
		$ancho = 256;
		$fs = 10;
		$this->SetFont('Arial','',$fs);
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		
		$text = 'Página '.$this->PageNo().' de {nb}';
		$this->SetFont('Arial','',8);
		$this->Celda(100, 6, "C.M.S.= U.B.M. - 14(17-12-2007)", 0, 0, '');
		$this->Celda($ancho-100, 6, $text, 0, 1, 'R', true);
		$y1 = $this->getY();
		$x1 = $this->getX();
		$this->Celda(80, 25, '', 1, 0, '', true);
		$y2 = $this->getY();
		$x2 = $this->getX();
		$this->Celda($ancho-80, 25, '', 1, 1, '', true);
		$this->setY($y1);
		$this->setX($x1);
		$this->Image( 'images/logo_medium.png', 21, 17, 78 );
		$this->setY($y2+5);
		$this->setX($x2+1);
		$this->Formato( 'Helvetica', 'B', 11 );
		$this->Celda($ancho-85, 6, 'Formulario B.M.2', 0, 1, 'C', true);
		$this->Formato( 'Helvetica', '', 9 );
		$this->setX($x2+1);
		$this->Celda($ancho-85, 8, 'Relación de Movimiento de Bienes', 0, 1, 'C', true);
		
		$this->Ln(8);
		$y = $this->getY();
		$x = $this->getX();
		$this->Celda($ancho, 26, '', 1, 1, '', true);
		$y2 = $this->getY();
		$this->setY($y+1);
		$this->setX($x+1);
		$this->Celda(20, 5, '1. Estado: ', 0, 0, '', true);
		$this->Celda($ancho-25, 5, $this->capitalizar($this->header['estado']), 'B', 1, '', true);
		$yt = $this->getY();
		$this->setY($yt+1);
		$this->setX($x+1);
		$this->Celda(20, 5, '2. Municipio: ', 0, 0, '', true);
		$this->Celda(50, 5, strtoupper($this->header['municipio']), 'B', 0, '', true);
		$this->Celda(56, 5, '3. Unidad de Trabajo o Dependencia: ', 0, 0, '', true);
		$this->Celda(126, 5, $this->capitalizar($this->header['dependencia']), 'B', 1, '', true);
		$yt = $this->getY();
		$this->setY($yt+1);
		$this->setX($x+1);
		$this->Celda(20, 5, '4. Servicio: ', 0, 0, '', true);
		$this->Celda(100, 5, 'CONTRALORIA MUNICIPAL DE SUCRE', 'B', 0, '', true);
		$this->Celda(35, 5, '5. Periodo de la cuenta: ', 0, 0, '', true);
		$this->Celda(96, 5, $this->capitalizar($this->header['fecha']), 'B', 1, '', true);
		$yt = $this->getY();
		$this->setY($yt+1);
		$this->setX($x+1);
		$this->Celda(30, 5, '6. Direccion o Lugar: ', 0, 0, '', true);
		$this->Celda(221, 5, $this->capitalizar($this->header['direccion']), 'B', 0, '', true);
		$this->setY($y2);
	}
	
// ===============================================================================
// 	Encabezado para el Formulario B.M.3
// ===============================================================================
	
	public function EncabezadoFBM3() {	
		$ancho = 256;
		$fs = 10;
		$this->SetFont('Arial','',$fs);
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		
		//$text = 'Página '.$this->PageNo().' de {nb}';
		$this->SetFont('Arial','',8);
		$this->Celda(100, 6, "C.M.S.= U.B.M. - 14(17-12-2007)", 0, 1, '');
		//$this->Celda($ancho-100, 6, $text, 0, 1, 'R', true);
		$y1 = $this->getY();
		$x1 = $this->getX();
		$this->Celda(80, 25, '', 1, 0, '', true);
		$y2 = $this->getY();
		$x2 = $this->getX();
		$this->Celda($ancho-108, 25, '', 1, 0, '', true);
		$y3 = $this->getY();
		$x3 = $this->getX();
		$this->Celda(28, 25, '', 1, 1, '', true);
		$y4 = $this->getY();
		$x4 = $this->getX();
			
		$this->setY($y1);
		$this->setX($x1);
		$this->Image( 'images/logo_medium.png', 21, 17, 78 );
		$this->setY($y2+5);
		$this->setX($x2+1);
		$this->Formato( 'Helvetica', 'B', 11 );
		$this->Celda($ancho-115, 6, 'Formulario B.M.3', 0, 1, 'C', true);
		$this->Formato( 'Helvetica', '', 9 );
		$this->setX($x2+1);
		$this->Celda($ancho-115, 8, 'RELACION DE BIENES MUEBLES FALTANTES', 0, 1, 'C', true);
		$this->setY($y3);
		$this->setX($x3);
		$this->Celda(28, 8, 'HOJA Nro.', 1, 1, 'C', true);
		$this->setX($x3);
		$this->Celda(28, 17, $this->PageNo(), 1, 1, 'C', true);
		$this->setY($y4);
		$this->setX($x4);
		
		$this->Ln(2);
		$y = $this->getY();
		$x = $this->getX();
		$this->Celda($ancho, 26, '', 1, 1, '', true);
		$y2 = $this->getY();
		$this->setY($y+1);
		$this->setX($x+1);
		$this->Celda(20, 10, '1. Entidad:', 0, 0, '', true);
		$xt = $this->getX();
		$this->Celda(20, 5, 'Estado ', 0, 0, '', true);
		$this->Celda($ancho-111, 5, $this->capitalizar($this->header['estado']), 'B', 1, '', true);
		$this->setX($xt);
		$this->Celda(20, 5, 'Municipio ', 0, 0, '', true);
		$this->Celda($ancho-110, 5, strtoupper($this->header['municipio']), 'B', 0, '', true);
		$xt = $this->getX();
		$this->Ln();
		$yt = $this->getY();
		
		$this->setY($y);
		$this->setX($xt);
		$this->Celda(69, 6, '4. Identificación del Comprobante', 1, 1, 'C', true);
		$this->setX($xt);
		$this->Celda(44, 6.5, 'Codigo Concepto Movimiento', 1, 0, '', true);
		$this->Celda(25, 6.5, '60', 1, 1, 'C', true);
		$this->setX($xt);
		$this->Celda(44, 6.75, 'Numero de Comprobante', 1, 0, '', true);
		$this->Celda(25, 6.75, $this->header['comprobante'], 1, 1, 'C', true);
		$this->setX($xt);
		$this->Celda(44, 6.75, 'Fecha de la Operacion', 1, 0, '', true);
		$this->Celda(25, 6.75, $this->header['fecha'], 1, 1, 'C', true);
		
		$this->setY($yt+1);
		$this->setX($x+1);
		$this->Celda(40, 5, '2. Unidad de Trabajo: ', 0, 0, '', true);
		$this->Celda($ancho-111, 5, $this->capitalizar($this->header['dependencia']), 'B', 1, '', true);
		$yt = $this->getY();
		$this->setY($yt+1);
		$this->setX($x+1);
		$this->Celda(40, 5, '3. Unidad Administrativa: ', 0, 0, '', true);
		$this->Celda($ancho-111, 5, $this->capitalizar($this->header['adm']), 'B', 1, '', true);
		$this->Ln();
	}

// ===============================================================================
// 	Encabezado para el Formulario B.M.5
// ===============================================================================
	
	public function EncabezadoFBM5() {	
		$ancho = 256;
		$fs = 10;
		$this->SetFont('Arial','',$fs);
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		
		$text = 'Página '.$this->PageNo().' de {nb}';
		$this->SetFont('Arial','',8);
		//$this->Celda(100, 6, "C.M.S.= U.B.M. - 14(17-12-2007)", 0, 0, '');
		$this->Celda($ancho, 6, $text, 0, 1, 'R', true);
		$y1 = $this->getY();
		$x1 = $this->getX();
		$this->Celda(80, 25, '', 1, 0, '', true);
		$y2 = $this->getY();
		$x2 = $this->getX();
		$this->Celda($ancho-80, 25, '', 1, 1, '', true);
		$this->setY($y1);
		$this->setX($x1);
		//$this->Image( 'images/logo_medium.png', 21, 17, 78 );
		$this->setY($y2+5);
		$this->setX($x2+1);
		$this->Formato( 'Helvetica', 'B', 11 );
		$this->Celda($ancho-85, 6, $this->header['title'], 0, 1, 'C', true);
		$this->Formato( 'Helvetica', '', 9 );
		$this->setX($x2+1);
		$this->Celda($ancho-85, 8, $this->header['title2'], 0, 1, 'C', true);
	}		
// ===============================================================================
// 	Imprime un Grid en el PDF
// ===============================================================================
	
	public function Grid( $gd, $gw ) {
		$this->SetTextColor( 0 );
		
	    $this->Formato( 'Helvetica', 'B' );
		$align = 'R';
		
		for( $j = 0; $j < count($gd); $j++ ) {
	        $this->Celda( $gw[$j], 10, $gd[$j], 0, 0, $align );
			if ($j > 0) $align = 'C';
		}
		$this->Ln();
	    //$this->Cell(array_sum($gw),0,'','T');
	}
	
	
//=================================================================================
// 	Imprime un Grid Simple en el PDF
//================================================================================
	
	public function GridSimple( $gd, $gw, $s = 0 ) {
		$this->SetTextColor( 0 );
		$familia = 'Helvetica';
		$fs = 10;
	    $this->Formato( $familia, 'B', $fs );
		
		for( $i = 0; $i < sizeof($gd); $i++ ) {
			$this->Formato( $familia, 'B', $fs );
			$this->Celda( $gw[0], 8, $gd[$i][0], 0, 0, 'R' );
			$this->Formato( $familia, '', $fs );
			$this->Celda( $s, 8, '', 0, 0, 'R' );
			for( $j = 1; $j < sizeof($gw); $j++ ) {
		        $this->Celda( $gw[$j], 8, $gd[$i][$j], 0, 0, 'L' );
			}
			$this->Ln();
		}
	}
	
	// ==========================================================================================
	// 	Salva los valores pasados como parametro en el Espacio de Impresion
	// ==========================================================================================
	
	public function saveFont() {
		$saved = array();
		
		$saved[ 'family' ] 	= $this->FontFamily;
		$saved[ 'style' ] 	= $this->FontStyle;
		$saved[ 'sizePt' ] 	= $this->FontSizePt;
		$saved[ 'size' ] 	= $this->FontSize;
		$saved[ 'curr' ] 	=& $this->CurrentFont;
		
		return $saved;
	}
	
	
	// ==========================================================================================
	// 	Reinicia los valores pasados como parametro en el Espacio de Impresion
	// ==========================================================================================
	
	public function restoreFont( $saved ) {
		$this->FontFamily 	= $saved[ 'family' ];
		$this->FontStyle 	= $saved[ 'style' ];
		$this->FontSizePt 	= $saved[ 'sizePt' ];
		$this->FontSize 	= $saved[ 'size' ];
		$this->CurrentFont 	=& $saved[ 'curr' ];
		
		if ( $this->page > 0 ) {
			$this->_out( sprintf( 'BT /F%d %.2F Tf ET', $this->CurrentFont[ 'i' ], $this->FontSizePt ) );
		}
	}
	
	
	// ==========================================================================================
	// 	Crea un nuevo Espacio de Impresion con unos parametros por defecto
	// ==========================================================================================
	
	public function newFlowingBlock( $w, $h, $b = 0, $a = 'J', $f = 0 ) {
		// Ancho de los Puntos
		$this->flowingBlockAttr[ 'width' ] = $w * $this->k;
		
		// Altura seteada
		$this->flowingBlockAttr[ 'height' ] = $h;
		
		$this->flowingBlockAttr[ 'lineCount' ] = 0;
		
		$this->flowingBlockAttr[ 'border' ] = $b;
		$this->flowingBlockAttr[ 'align' ] = $a;
		$this->flowingBlockAttr[ 'fill' ] = $f;
		
		$this->flowingBlockAttr[ 'font' ] = array();
		$this->flowingBlockAttr[ 'content' ] = array();
		$this->flowingBlockAttr[ 'contentWidth' ] = 0;
	}
	
	
	// ==========================================================================================
	// 	Cierra el Espacio de Impresion
	// ==========================================================================================
	
	public function finishFlowingBlock() {
		$maxWidth 	=& $this->flowingBlockAttr[ 'width' ];
		
		$lineHeight =& $this->flowingBlockAttr[ 'height' ];
		
		$border 	=& $this->flowingBlockAttr[ 'border' ];
		$align 		=& $this->flowingBlockAttr[ 'align' ];
		$fill 		=& $this->flowingBlockAttr[ 'fill' ];
		
		$content 	=& $this->flowingBlockAttr[ 'content' ];
		$font 		=& $this->flowingBlockAttr[ 'font' ];
		
		// Seteamos el espacio Normal
		$this->_out( sprintf( '%.3F Tw', 0 ) );
		
		// La cantidad de espacio ocupado hasta ahora en las unidades de usuario
		$usedWidth = 0;
		
		foreach ( $content as $k => $chunk ) {
			$b = '';
			
			if ( is_int( strpos( $border, 'B' ) ) ) {
				$b .= 'B';
			}
			if ( $k == 0 && is_int( strpos( $border, 'L' ) ) ) {
				$b .= 'L';
			}
			if ( $k == count( $content ) - 1 && is_int( strpos( $border, 'R' ) ) ) {
				$b .= 'R';
			}
			
			$this->restoreFont( $font[ $k ] );
			
			// Si es la ultima parte de la Linea se mueve a la Siguiente
			if ( $k == count( $content ) - 1 ) {
				$this->Cell( ( $maxWidth / $this->k ) - $usedWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 1, $align, $fill );
			} else {
				$this->Cell( $this->GetStringWidth( $chunk ), $lineHeight, $chunk, $b, 0, $align, $fill );
			}
			
			$usedWidth += $this->GetStringWidth( $chunk );
		}
	}
	
	
	// ==========================================================================================
	// 	Escribe el texto en el Espacio de Impresion segun los parametros seleccionados
	// ==========================================================================================
	
	public function WriteFlowingBlock( $s ) {
		// Ancho de todo el contenido hasta ahora en los puntos
		$contentWidth =& $this->flowingBlockAttr[ 'contentWidth' ];
		
		// Ancho maximo de la celda
		$maxWidth =& $this->flowingBlockAttr[ 'width' ];
		
		$lineCount =& $this->flowingBlockAttr[ 'lineCount' ];
		
		$lineHeight =& $this->flowingBlockAttr[ 'height' ];
		
		$border =& $this->flowingBlockAttr[ 'border' ];
		$align =& $this->flowingBlockAttr[ 'align' ];
		$fill =& $this->flowingBlockAttr[ 'fill' ];
		
		$content =& $this->flowingBlockAttr[ 'content' ];
		$font =& $this->flowingBlockAttr[ 'font' ];
		
		$font[] = $this->saveFont();
		$content[] = '';
		
		$currContent =& $content[ count( $content ) - 1 ];
		
		// Corte de la Linea si es que se justifica
		$cutoffWidth = $contentWidth;
		
		// Para cada carácter en la cadena
		for ( $i = 0; $i < strlen( $s ); $i++ ) {
			// Extraer el carácter actual
			$c = $s[ $i ];
			
			// Obtener el ancho del carácter en los puntos
			$cw = $this->CurrentFont[ 'cw' ][ $c ] * ( $this->FontSizePt / 1000 );
			
			if ( $c == ' ' ) {
				$currContent .= ' ';
				$cutoffWidth = $contentWidth;
				$contentWidth += $cw;
				continue;
			}
			
			// Intentar añadir otra palabra
			if ( $contentWidth + $cw > $maxWidth ) {
				$lineCount++;
				
				// Contiene todo el contenido que no lo hacen en esta impresión
				$savedContent = '';
				$savedFont = array();
				
				// En primer lugar, cortamos y guardamos cualquier palabras parciales al final de la cadena
				$words = explode( ' ', $currContent );
				
				// Si parece que no terminó ninguna de las palabras de este trozo
				if ( count( $words ) == 1 ) {
					// Ahorrar y recortar los contenidos actualmente en la pila
					$savedContent = array_pop( $content );
					$savedFont = array_pop( $font );
					
					// Recortar los espacios finales de la última parte del contenido
					$currContent =& $content[ count( $content ) - 1 ];
					$currContent = rtrim( $currContent );
					
				// De lo contrario, tenemos que encontrar algo que cortar
				} else {
					$lastContent = '';
					
					for ( $w = 0; $w < count( $words ) - 1; $w++) {
						$lastContent .= "{$words[ $w ]} ";
					}
					
					$savedContent = $words[ count( $words ) - 1 ];
					$savedFont = $this->saveFont();
					
					// Reemplazamos el contenido actual con la version procesada
					$currContent = rtrim( $lastContent );
				}
				
				// Actualizamos $contentWidth y $cutoffWidth
				$contentWidth = 0;
				
				foreach ( $content as $k => $chunk ) {
					$this->restoreFont( $font[ $k ] );
					$contentWidth += $this->GetStringWidth( $chunk ) * $this->k;
				}
				
				$cutoffWidth = $contentWidth;
				
				// Si la Alineacion es Justificada, buscamos los espacios en el Texto
				if( $align == 'J' ) {
					// Contamos cuantos espacios hay en el Texto
					$numSpaces = 0;
					
					foreach ( $content as $chunk ) {
						$numSpaces += substr_count( $chunk, ' ' );
					}
					
					// Si hay mas de un Espacio, buscamos palabras espaciadas en Puntos
					if ( $numSpaces > 0 ) {
						$this->ws = ( $maxWidth - $cutoffWidth ) / $numSpaces;
					} else {
						$this->ws = 0;
					}
					$this->_out( sprintf( '%.3F Tw', $this->ws ) );
					
				// Ademas, necesitamso los espacios normales
				} else {
					$this->_out( sprintf( '%.3F Tw', 0 ) );
				}
				
				// Imprimimos cada Salida
				$usedWidth = 0;
				
				foreach ( $content as $k => $chunk ) {
					$this->restoreFont( $font[ $k ] );
					
					$stringWidth = $this->GetStringWidth( $chunk ) + ( $this->ws * substr_count( $chunk, ' ' ) / $this->k );
					
					// Determina cual borde debe ser usado
					$b = '';
					
					if ( $lineCount == 1 && is_int( strpos( $border, 'T' ) ) ) {
						$b .= 'T';
					}
					if ( $k == 0 && is_int( strpos( $border, 'L' ) ) ) {
						$b .= 'L';
					}
					if ( $k == count( $content ) - 1 && is_int( strpos( $border, 'R' ) ) ) {
						$b .= 'R';
					}
					
					// Si este ultimo texto completa la linea, entonces salta a la Siguiente
					if ( $k == count( $content ) - 1 ) {
						$this->Cell( ( $maxWidth / $this->k ) - $usedWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 1, $align, $fill );
					} else {
						$this->Cell( $stringWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 0, $align, $fill );
						$this->x -= 2 * $this->cMargin;
					}
					$usedWidth += $stringWidth;
				}
				
				// Se mueve a la siguiente Linea, Reinicia las variables, Salva el contenido y Actualiza el Texto
				$this->restoreFont( $savedFont );
				
				$font 			= array( $savedFont );
				$content 		= array( $savedContent . $s[ $i ] );
				
				$currContent 	=& $content[ 0 ];
				
				$contentWidth 	= $this->GetStringWidth( $currContent ) * $this->k;
				$cutoffWidth 	= $contentWidth;
				
			// Este caracter se ajusta, entonces se añade
			} else {
				$contentWidth += $cw;
				$currContent .= $s[ $i ];
			}
		}
	}
	
	public function capitalizar( $str ) 
	{
		$str_new = strtoupper($str);
		$str_new = utf8_decode($str_new);
		$str_new = str_replace('á', 'Á', $str_new);
		$str_new = str_replace('é', 'É', $str_new);
		$str_new = str_replace('í', 'Í', $str_new);
		$str_new = str_replace('ó', 'Ó', $str_new);
		$str_new = str_replace('ú', 'Ú', $str_new);
		$str_new = str_replace('ñ', 'Ñ', $str_new);	
		return $str_new;
	}


// ================================================================================
// 	Constructor
//  @ or = orientation
// ================================================================================
	
	public function __construct( $or='Portrait', $unit='mm', $fmt='A4', $header = null ) {
	    parent::__construct( $or );
		
		$this->orientation = $or;
		if ($this->orientation == 'Portrait') 
			$this->pageHeight = 215;
		else {
			$this->pageHeight = 175;
			$this->ancho = 266.7;
		}
			
		$this->header = $header;
		if (isset($this->header))
			$this->plantilla = $header['formulario'];
	}	
}
?>
