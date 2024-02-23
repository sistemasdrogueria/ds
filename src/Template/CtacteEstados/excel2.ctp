<?php 
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur S.A."); //autor
$objPHPExcel->getProperties()->setTitle("Estado de las Cuentas Corrientes"); //titulo
 
//inicio estilos
$titulo = new PHPExcel_Style(); //nuevo estilo
$titulo->applyFromArray(
  array('alignment' => array( //alineacion
      'wrap' => false,
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ),
    'font' => array( //fuente
      'bold' => true,
      'size' => 16
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
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT);
 
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
// $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);
 
$fila=1;

$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "Estado de la Cuenta Corrientes - ".$this->request->session()->read('Auth.User.codigo'));
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:E$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:E$fila"); //establecer estilo
 
//titulos de columnas
$fila+=2;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Fecha de Venc.');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'Detalle');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'Fecha de Compra');
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'Importe');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'Subtotal');

			
$filas = "A$fila:E$fila"; 
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita
 
	$tiporegistros = $ctactetiporegistros->toArray();
	$total =0;
	foreach ($ctacteEstados as $ctacteestado): 
  //foreach ($facturasCabeceras as $facturasCabecera):
		$fila+=1;	
		// Fecha Vencimiento
		if (date_format($ctacteestado->fecha_vencimiento,'d-m-Y')!="01-01-0101")
					$objPHPExcel->getActiveSheet()->setCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel( $ctacteestado->fecha_vencimiento ));
				else
					$objPHPExcel->getActiveSheet()->setCellValue("A$fila", "");
		// Detalle
		if ($ctacteestado['ctacte_tipo_registros_id']==1 && $ctacteestado->importe == $totaltarjetacredito)
							$detalle = 'Tarjetas de Credito';
					  else
						    if ($ctacteestado->signo==0 && $ctacteestado->ctacte_tipo_registros_id==4)
									$detalle= 'Nota de Debito';
								else
									
									$detalle= $tiporegistros[$ctacteestado['ctacte_tipo_registros_id']]; 							
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $detalle);		
		// Fecha Compra
		if (date_format($ctacteestado->fecha_compra,'d-m-Y')!="01-01-0101" && date_format($ctacteestado->fecha_compra,'d-m-Y')!="01-01-1970")
			{
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", PHPExcel_Shared_Date::PHPToExcel( $ctacteestado->fecha_compra));	
			}
			else
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", "");	
		// importe	
		if ($ctacteestado->signo==1)
				$importe = -1 * $ctacteestado->importe; 
			else
				$importe = 	$ctacteestado->importe;
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", str_replace(',','',number_format($importe,2)));
		// total
		if ($ctacteestado->signo==1)
				$total = $total - $ctacteestado->importe;
			else
				$total = $total + $ctacteestado->importe;
        $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_replace(',','', number_format($total,2)));
    	$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:E$fila");
		$objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
		 $objPHPExcel->getActiveSheet()->getStyle("C$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
		$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		
		//$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		//$objPHPExcel->getActiveSheet()->getStyle("A$fila:E$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		//$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		//$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

			
			

			
			
			
	endforeach; 
		
	$fila+=2;
	$objPHPExcel->getActiveSheet()->setCellValue("A$fila", "Generado:");
	
	$objPHPExcel->getActiveSheet()->setCellValue("B$fila", date('Y-m-d H:i:s'));
	$objPHPExcel->getActiveSheet()->getStyle("B$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYMINUS);
	$fila+=2;
	$objPHPExcel->getActiveSheet()->setCellValue("A$fila", "Drogueria Sur S.A.");
	$objPHPExcel->getActiveSheet()->mergeCells("A$fila:E$fila"); //unir celdas
//recorrer las columnas
foreach (range('A', 'E') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
 
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
 
 
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo

$namefile= '"CtaCte_'.$this->request->session()->read('Auth.User.codigo').'.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');