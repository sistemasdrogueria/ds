<?php 
 ini_set('memory_limit', '4096M');
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur S.A."); //autor
$objPHPExcel->getProperties()->setTitle("Listado de Comprobantes"); //titulo
 
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
$bordes = new PHPExcel_Style(); //nuevo estilo
$bordes->applyFromArray(
array('borders' => array(
'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
)
));
//fin estilos
 
$objPHPExcel->createSheet(0); //crear hoja
$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora
$objPHPExcel->getActiveSheet()->setTitle("Listado"); //establecer titulo de hoja
 
//orientacion hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
 
//tipo papel
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
 
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
 
//establecer titulos de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);
 
$fila=1;

$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:M$fila"); //establecer estilo
$client = $this->request->session()->read('client');
//titulos de columnas

$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'FECHA');
$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'TIPO');
$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'N° NOTA');
$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'CLIENTE');
$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'LETRA COMP.');
$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'N° COMP.');
$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'T. EXENTO');
$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'T. GRAVADO');
$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'I.V.A.');
$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", 'PERC. I.V.A.');
$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", 'PERC. I.BRUTOS');
$objPHPExcel->getActiveSheet()->SetCellValue("L$fila", 'TOTAL');
$objPHPExcel->getActiveSheet()->SetCellValue("M$fila", 'MOTIVO');
	
$filas = "A$fila:M$fila"; 
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita
 
 $facturasCabeceras = $this->request->session()->read('facturasCabeceras');
  foreach ($facturasCabeceras as $facturasCabecera):
		$fila+=1;	
		$objPHPExcel->getActiveSheet()->setCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel( $facturasCabecera['fecha'] ));
				
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $facturasCabecera['pedido_tipo']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $facturasCabecera['pedido_ds']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $facturasCabecera['cliente']['codigo']);
		//$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $client['codigo']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $facturasCabecera['letra']);
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", str_pad($facturasCabecera['comprobante']['seccion'], 4, "0", STR_PAD_LEFT)
		.'-'. str_pad($facturasCabecera['comprobante']['numero'] , 8, "0", STR_PAD_LEFT));
		
	    $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", str_replace(',','',number_format($facturasCabecera['imp_exento'],2))); 
		$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", str_replace(',','',number_format($facturasCabecera['imp_gravado'],2))); 
		$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", str_replace(',','',number_format($facturasCabecera['imp_iva'],2))); 
		$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", str_replace(',','',number_format($facturasCabecera['imp_rg3337'],2)));
		$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", str_replace(',','',number_format($facturasCabecera['imp_ingreso_bruto'],2)));
        $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", str_replace(',','', number_format($facturasCabecera['total'],2)));
		 $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", "FACTURA");
    	 $objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:M$fila");
		 $objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
		 
		$objPHPExcel->getActiveSheet()->getStyle("G$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("H$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("I$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("J$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("K$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("L$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$objPHPExcel->getActiveSheet()->getStyle("A$fila:F$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		//$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		//$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		
	endforeach; 
	
	//$notasCabeceras = $this->request->session()->read('notasCabeceras');
	  foreach ($notasCabeceras as $notasCabecera):
		$fila+=1;	
		$objPHPExcel->getActiveSheet()->setCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel( $notasCabecera['fecha'] ));
		$tipo = $notasCabecera['tipo'];
		if 	($notasCabecera['obrasocial']>0)
			$tipo = $tipo . ' OS';		
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $tipo);	
		
		
			
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $notasCabecera['nota']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $notasCabecera['cliente']['codigo']);
		//$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $client['codigo']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $notasCabecera['letra']);
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", str_pad($notasCabecera['comprobante']['seccion'], 4, "0", STR_PAD_LEFT)
		.'-'. str_pad($notasCabecera['comprobante']['numero'] , 8, "0", STR_PAD_LEFT));
		
	    $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", str_replace(',','',number_format($notasCabecera['imp_exento'],2))); 
		$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", str_replace(',','',number_format($notasCabecera['imp_gravado'],2))); 
		$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", str_replace(',','',number_format($notasCabecera['imp_iva'],2))); 
		$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", str_replace(',','',number_format($notasCabecera['imp_rg3337'],2)));
		$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", str_replace(',','',number_format($notasCabecera['imp_ingreso_bruto'],2)));
       $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", str_replace(',','', number_format($notasCabecera['total'],2)));
    	
		 if ($tipo !="RC")
		 {
			 if (!empty($notasCabecera['notas_cuerpos_items']))
			 {
				 foreach ($notasCabecera['notas_cuerpos_items'] as $item):
				 if ($item['descripcion']!="                            " && $item['descripcion']!=".                           ")
					 $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", $item['descripcion']);
				 endforeach; 
			 }
			 else
			 $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", "");
		 }	
		 else
			 $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", "RECIBO");
		 $objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:M$fila");
		 $objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
		 
		$objPHPExcel->getActiveSheet()->getStyle("G$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("H$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("I$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("J$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("K$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("L$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$objPHPExcel->getActiveSheet()->getStyle("A$fila:F$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		//$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		//$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		
	endforeach; 	
//recorrer las columnas
foreach (range('A', 'M') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo
//// nombre del archivo
header('Content-Disposition: attachment; filename="comprobantes.xlsx"');
//header('Content-Disposition: attachment; filename='.$namefile);//.$namefile);
//forzar a descarga por el navegador
$objWriter->save('php://output');