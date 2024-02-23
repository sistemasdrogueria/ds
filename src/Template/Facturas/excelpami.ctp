<?php 
 ini_set('memory_limit', '1024M');
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("CHELO"); //autor
$objPHPExcel->getProperties()->setTitle("Prueba para generar excel"); //titulo
 
//inicio estilos
$titulo = new PHPExcel_Style(); //nuevo estilo
$titulo->applyFromArray(
  array('alignment' => array( //alineacion
      'wrap' => false,
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ),
    'font' => array( //fuente
      'bold' => true,
      'size' => 20
    )
));
 
$subtitulo = new PHPExcel_Style(); //nuevo estilo
 
$subtitulo->applyFromArray(
  array('fill' => array( //relleno de color
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => '2ac5ff')
    ),
    'borders' => array( //bordes
      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    ),
	'alignment' => array(
			'wrap' => false,
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
	
));
$subtitulo2 = new PHPExcel_Style(); //nuevo estilo
 
$subtitulo2->applyFromArray(
  array('fill' => array( //relleno de color
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => 'D8F2A5')
    ),
    'borders' => array( //bordes
      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
	
));
 
$bordes = new PHPExcel_Style(); //nuevo estilo
 
$bordes->applyFromArray(
  array('borders' => array(
      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    )
));

$celdascentradas = new PHPExcel_Style();
$celdascentradas->applyFromArray(
	 array('alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    ));


//fin estilos
 
$objPHPExcel->createSheet(0); //crear hoja
$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora
$objPHPExcel->getActiveSheet()->setTitle("Listado"); //establecer titulo de hoja
 
//orientacion hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
 
//tipo papel
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
 
//establecer impresion a pagina completa
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
//fin: establecer impresion a pagina completa
 
//establecer margenes
$margin = 0.5 / 2.54; // 0.5 centimetros
$marginBottom = 1.2 / 2.54; //1.2 centimetros
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
//fin: establecer margenes
 
//incluir una imagen
/*$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setPath('img/logo.png'); //ruta
$objDrawing->setHeight(75); //altura
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); //incluir la imagen
//fin: incluir una imagen
 */
//establecer titulos de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);
 
$fila=1;
$filas = "A$fila:K$fila"; 
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "LISTADO FACTURA");
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:K$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, $filas); //establecer estilo
 
//titulos de columnas

  foreach ($facturascabeceras as $facturasCabecera):
		$fila+=1;
		$filas = "A$fila:K$fila"; 
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'FECHA');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'N PEDIDO');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'CLIENTE');
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'LETRA COMP.');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'NÚMERO COMP.');
		
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'T. EXENTO');
		$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'T. GRAVADO');
		$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'I.V.A.');
		$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'PERC. I.V.A.');
		$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", 'PERC. I.BRUTOS');
		$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", 'TOTAL');
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
		/*$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		*/
		$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita
		$fila+=1;

		$objPHPExcel->getActiveSheet()->setCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel( $facturasCabecera['fecha'] ));
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $facturasCabecera['pedido_ds']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $this->request->session()->read('Auth.User.cliente_id'));		
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $facturasCabecera['letra']);
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_pad($facturasCabecera['comprobante']['seccion'], 4, "0", STR_PAD_LEFT)
		.'-'. str_pad($facturasCabecera['comprobante']['numero'] , 8, "0", STR_PAD_LEFT));
 		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", str_replace(',','',number_format($facturasCabecera['imp_exento'],2))); 
		$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", str_replace(',','',number_format($facturasCabecera['imp_gravado'],2))); 
		$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", str_replace(',','',number_format($facturasCabecera['imp_iva'],2))); 
		$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", str_replace(',','',number_format($facturasCabecera['imp_rg3337'],2)));
		$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", str_replace(',','',number_format($facturasCabecera['imp_ingreso_bruto'],2)));
        $objPHPExcel->getActiveSheet()->SetCellValue("K$fila", str_replace(',','', number_format($facturasCabecera['total'],2)));
     
		
		$objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
		$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("G$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("H$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("I$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("J$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("K$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
			
		if (count($facturasCabecera['facturas_cuerpos_items'])>0)
		{
			$fila+=1;
			$filas = "A$fila:K$fila";
			$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'DESCRIPCION');
			$objPHPExcel->getActiveSheet()->mergeCells("B$fila:D$fila");
			$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'EAN');
			$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'TROQUEL');
			$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'IVA');
			$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'CANTIDAD');
			$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'P.UNITARIO');
			$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", 'P.PUBLICO');
			$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", 'P.TOTAL');
			//$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, $filas);
			$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo2, $filas); //establecer estilo
			$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita

		}
		foreach ($facturasCabecera['facturas_cuerpos_items'] as $fci): 
			$fila+=1;
			$filas = "A$fila:K$fila"; 
			$objPHPExcel->getActiveSheet()->SetCellValue("B$fila",$fci['articulo']['descripcion_sist']);
			$objPHPExcel->getActiveSheet()->mergeCells("B$fila:D$fila");
			$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_pad($fci['articulo']['codigo_barras'], 13, "0", STR_PAD_LEFT));
			$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $fci['articulo']['troquel']);
			if ($fci['iva']) $itemart = '1'; else $itemart = '0';
			$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $itemart);
			$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $fci['cantidad_facturada']);
			$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", str_replace(',','',number_format($fci['precio_unitario'],2))); 
			$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", str_replace(',','',number_format($fci['precio_publico'],2))); 
			$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", str_replace(',','',number_format($fci['precio_total'],2))); 
			$objPHPExcel->getActiveSheet()->setSharedStyle($bordes,  $filas);
			$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			$objPHPExcel->getActiveSheet()->getStyle("I$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
			$objPHPExcel->getActiveSheet()->getStyle("J$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
			$objPHPExcel->getActiveSheet()->getStyle("K$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
			$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
			
			endforeach; 	
			
		$fila+=1;
	endforeach; 



	

//recorrer las columnas
foreach (range('A', 'K') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
 
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
 
 
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo

$namefile= '"'.$this->request->session()->read('Auth.User.cliente_id').'.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename="dettest2.xlsx"');//.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');