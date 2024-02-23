<?php 
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur S.A."); //autor
$objPHPExcel->getProperties()->setTitle("Cta. Cte. Tarjetas"); //titulo
 
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
$subtitulo2 = new PHPExcel_Style(); //nuevo estilo
 
$subtitulo2->applyFromArray(
  array('fill' => array( //relleno de color
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => 'b0df6e')
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

$tarjetas = new PHPExcel_Style(); //nuevo estilo
 
$tarjetas->applyFromArray(
  array(
    'borders' => array( //bordes
      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
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
 
//establecer titulos de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);
 
$fila=1;

$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "TARJETAS DE CREDITO - ".$this->request->session()->read('Auth.User.codigo'));
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:F$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:F$fila"); //establecer estilo
 
//titulos de columnas
	
	$filas = "A$fila:F$fila";  
	$tiporegistros = $ctactetiporegistros->toArray();
	
		$fila+=1;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Fecha Acreditación');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'Detalle');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'N° Cupón');
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'Fecha Ingreso');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'N° Nota');
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'Importe');
		$filas = "A$fila:F$fila"; 
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo2, $filas); //establecer estilo
		$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita
			//$totalt=0;
			foreach ($ctacteestadostarjetacredito as $ctactetarjeta): 
				$fila+=1;
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel($ctactetarjeta['fecha_acreditacion']));	
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $ctactetarjeta['detalle'] );		
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $ctactetarjeta['nro_liquidacion']);		
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", PHPExcel_Shared_Date::PHPToExcel($ctactetarjeta['fecha_ingreso']));	
				$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $ctactetarjeta['nro_nota_credito'] );		
				$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", str_replace(',','',number_format($ctactetarjeta['importe'],2)));
				$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:F$fila");
				
				$filas = "A$fila:F$fila"; 
				$objPHPExcel->getActiveSheet()->setSharedStyle($tarjetas, $filas);
				
				$objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
				$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
				$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);	
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

$namefile= '"CtaCte_Tarjetas_'.$this->request->session()->read('Auth.User.codigo').'.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');