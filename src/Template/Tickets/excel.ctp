<?php 
 ini_set('memory_limit', '-1');
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
$objPHPExcel = new PHPExcel(); //nueva instancia
$objPHPExcel->getProperties()->setCreator("Drogueria Sur S.A."); //autor
$objPHPExcel->getProperties()->setTitle("Listado de TICKETS"); //titulo
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
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "LISTADO DE TICKETS");
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:P$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:P$fila"); //establecer estilo
//titulos de columnas
$fila+=1;
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'N° COD');
$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'FECHA ING');
$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'COD. CLIENTE');
$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'RAZON SOCIAL');
//$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'CLIENTE');
$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'N° FACTURA.');
$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'FECHA FACTURA');
$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'N° PEDIDO');
$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'MOTIVO');
$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'ESTADO');
$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", 'PRODUCTO');
$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", 'EAN');
$objPHPExcel->getActiveSheet()->SetCellValue("L$fila", 'TROQUEL');
$objPHPExcel->getActiveSheet()->SetCellValue("M$fila", 'CANTIDAD');
$objPHPExcel->getActiveSheet()->SetCellValue("N$fila", 'LOTE');
$objPHPExcel->getActiveSheet()->SetCellValue("O$fila", 'SERIE');
$objPHPExcel->getActiveSheet()->SetCellValue("P$fila", 'F_VENC.');

$filas = "A$fila:P$fila"; 
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita
foreach ($reclamos as $ticket):
	$fila+=1;

	foreach ($ticket["reclamos_items"] as $item ):
	$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $ticket['id']);	
	$objPHPExcel->getActiveSheet()->setCellValue("B$fila", PHPExcel_Shared_Date::PHPToExcel( $ticket['creado'] ));
	$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $ticket['cliente']['codigo']);
	$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $ticket['cliente']['razon_social']);
	$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_pad($ticket['factura_seccion'], 4, "0", STR_PAD_LEFT).'-'. str_pad($ticket['factura_numero'] , 8, "0", STR_PAD_LEFT));
	$objPHPExcel->getActiveSheet()->setCellValue("F$fila", PHPExcel_Shared_Date::PHPToExcel( $ticket['fecha_recepcion'] ));
	$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $ticket['pedido_numero']);	
	$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $ticket['reclamos_tipo']['nombre']); 
	$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $ticket['reclamos_estado']['nombre']); 
	
	$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $item['articulo']['descripcion_sist']);	
	
	$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", $item['articulo']['codigo_barras']);
	$objPHPExcel->getActiveSheet()->SetCellValue("L$fila", $item['articulo']['troquel']);
	$objPHPExcel->getActiveSheet()->SetCellValue("M$fila", $item['cantidad']);
	$objPHPExcel->getActiveSheet()->SetCellValue("N$fila", $item['lote']); 
	$objPHPExcel->getActiveSheet()->SetCellValue("O$fila", $item['serie']); 
	if ($item['fecha_vencimiento']!=null)
	$objPHPExcel->getActiveSheet()->SetCellValue("P$fila",PHPExcel_Shared_Date::PHPToExcel( $item['fecha_vencimiento'])); 
	

	endforeach; 





	$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:P$fila");
	
	$objPHPExcel->getActiveSheet()->getStyle("B$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
	$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
	$objPHPExcel->getActiveSheet()->getStyle("P$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
	$objPHPExcel->getActiveSheet()->getStyle("K$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
	$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
	$objPHPExcel->getActiveSheet()->getStyle("A$fila:P$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
	//$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
	//$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
endforeach; 
//recorrer las columnas
foreach (range('A', 'P') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo
$namefile= '"TICKETS.xlsx"';/*$cliente['codigo'].*/
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);//.$namefile);
//**********************************************************************
//forzar a descarga por el navegador
$objWriter->save('php://output');