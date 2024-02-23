<?php 
 ini_set('memory_limit', '1024M');
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur S.A"); //autor
$objPHPExcel->getProperties()->setTitle("Detalle de TRANSFER"); //titulo
 
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
 
//incluir una imagen
/*$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setPath('img/logo.png'); //ruta
$objDrawing->setHeight(75); //altura
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); //incluir la imagen
//fin: incluir una imagen
 */
//establecer titulos de impresion en cada hoja
//$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);
 
$fila=1;
$filas = "A$fila:K$fila"; 
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "LISTADO TRANSFER");
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:K$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, $filas); //establecer estilo
 
//titulos de columnas

  foreach ($pvs as $pv):
		$fila+=1;
		$filas = "A$fila:F$fila"; 
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'FECHA');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'N TRANSFER');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'CLIENTE');
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'CODIGO');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'DIRECCION');
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'CODIGO POSTAL.');

		

		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
		/*$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		*/
		$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita
		$fila+=1;
		$cliente= $pv['cliente'];
		$objPHPExcel->getActiveSheet()->setCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel( $pv['creado'] ));
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $pv['id']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $cliente['nombre']);		
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $cliente['codigo']);	
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $cliente['domicilio']);
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $cliente['codigo_postal']);
		

     
		
		$objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
		$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
			
		if (count($pv['pedidos_preventas_items'])>0)
		{
			$fila+=1;
			$filas = "A$fila:I$fila";
			$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'DESCRIPCION');
			$objPHPExcel->getActiveSheet()->mergeCells("B$fila:D$fila");
			$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'EAN');
			$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'TROQUEL');
			$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'CANTIDAD');
			$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'DESCUENTO');
			$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'PLAZO');
			
			//$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, $filas);
			$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo2, $filas); //establecer estilo
			$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita

		}
		foreach ($pv['pedidos_preventas_items'] as $pvi): 
			$fila+=1;
			$filas = "A$fila:I$fila"; 
			$articulo = $pvi['articulo'];
			$objPHPExcel->getActiveSheet()->SetCellValue("B$fila",$articulo['descripcion_sist']);
			$objPHPExcel->getActiveSheet()->mergeCells("B$fila:D$fila");
			$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_pad($articulo['codigo_barras'], 13, "0", STR_PAD_LEFT));
			$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $articulo['troquel']);
			$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $pvi['cantidad']);
			$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $pvi['descuento']); 
			$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $pvi['plazoley_dcto']); 
			
			$objPHPExcel->getActiveSheet()->setSharedStyle($bordes,  $filas);
			$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		
			endforeach; 	
			
		$fila+=1;
	endforeach; 
	

//recorrer las columnas
foreach (range('A', 'J') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
 
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
 
 
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo

$namefile= '"TRANSFER_'.$this->request->session()->read('Auth.User.codigo').'.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');