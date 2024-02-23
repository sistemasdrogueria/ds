<?php 
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur S.A."); //autor
$objPHPExcel->getProperties()->setTitle("Reporte de Unidades Minimas"); //titulo
 
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
  array('fill' => array( //relleno de color
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => 'DEDEDE')
    ),
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
//$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
 
$fila=1;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Código');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'Razón Social');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'Código Postal');
		
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'Items');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'Unidades');
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'Unidades Minimas');
		$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'Unidades Potenciales');
$filas = "A$fila:G$fila"; 
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita

	foreach ($items as $item):
				
			$fila+=1;
				
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $item['cl']['codigo']);
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $item['cl']['razon_social']);	
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $item['cl']['codigo_postal']);	
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $item['items']);	
				$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $item['unidades']);	
				$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $item['unidades_minimas']);	
				$opt = $item['unidades_minimas']-$item['unidades'];
				$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $opt);	

    	$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:G$fila");
		
endforeach;	
	
	$fila+=2;
	//$objPHPExcel->getActiveSheet()->setCellValue("C$fila", "Generado:");
	
	//$objPHPExcel->getActiveSheet()->setCellValue("D$fila", date('Y-m-d H:i:s'));
	//$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYMINUS);
	//$objPHPExcel->getActiveSheet()->mergeCells("D$fila:H$fila"); //unir celdas
	
	$fila+=2;
	//$objPHPExcel->getActiveSheet()->setCellValue("C$fila", "Drogueria Sur S.A.");
	//$objPHPExcel->getActiveSheet()->mergeCells("C$fila:G$fila"); //unir celdas

	//recorrer las columnas
foreach (range('A', 'G') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
 
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
 
 
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo

$namefile= '"reporte_carrito.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');