<?php 
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur"); //autor
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

//$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "LISTADO DE COMPROBANTES");
//$objPHPExcel->getActiveSheet()->mergeCells("A$fila:L$fila"); //unir celdas
//$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:L$fila"); //establecer estilo
 
//fp.id, f.nombre, fp.detalle, a.troquel, a.descripcion_sist, a.categoria_id, a.precio_publico

//titulos de columnas
//$fila+=1;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'ID');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'NOMBRE');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'DETALLE');
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'TROQUEL');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'Descripcion Sist.');
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'CATEGORIA');
		$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'PRECIO');
	
$filas = "A$fila:G$fila"; 
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita
 
 
  foreach ($fraganciaspresentaciones as $fp):
		$fila+=1;	
		$objPHPExcel->getActiveSheet()->setCellValue("A$fila", $fp['id'] );
				
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $fp['Fragancias']['nombre']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $fp['detalle']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $fp['Articulos']['troquel']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $fp['Articulos']['descripcion_sist']);	
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $fp['Articulos']['categoria_id']);
				
	    $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", str_replace(',','',number_format($fp['Articulos']['precio_publico'],2))); 
	
    	 $objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:G$fila");
		 
		 
		$objPHPExcel->getActiveSheet()->getStyle("G$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$objPHPExcel->getActiveSheet()->getStyle("A$fila:G$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		//$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		//$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		
	endforeach; 
	

//recorrer las columnas
foreach (range('A', 'G') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
 
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
 
 
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo
$namefile= '"Fragancias.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);//.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');