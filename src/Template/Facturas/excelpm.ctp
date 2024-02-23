<?php 
 ini_set('memory_limit', '2048M');
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur"); //autor
$objPHPExcel->getProperties()->setTitle("Listado con descuentos otorgados"); //titulo
 
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
 
$fila=1;
$filas = "A$fila:L$fila"; 
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'CLIENTE');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'RAZON SOCIAL');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'FECHA FC.');
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'N PEDIDO');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'N FACTURA');
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'EAN');
		$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'PRODUCTO');
		
		$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'LABORATORIO ');
		$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'UNID.');
		$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", 'DTO.');
		$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", 'N TRANSFER');
    $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", 'CATEGORIA');
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas);
		$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true);
		//$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		
  foreach ($facturascabeceras as $facturasCabecera):
		foreach ($facturasCabecera['facturas_cuerpos_items'] as $fci): 
		
			//if ($fci['descuento']>0)
			if ($fci['cantidad_facturada']>0)
			{
			$fila+=1;


			$filas = "A$fila:L$fila"; 
			$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $facturasCabecera['cliente']['codigo']);
			$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $facturasCabecera['cliente']['nombre']);
			$objPHPExcel->getActiveSheet()->setCellValue("C$fila", PHPExcel_Shared_Date::PHPToExcel( $facturasCabecera['fecha'] ));
			$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $fci['pedido_ds']);	
			$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_pad($facturasCabecera['comprobante']['seccion'], 4, "0", STR_PAD_LEFT)
			.'-'. str_pad($facturasCabecera['comprobante']['numero'] , 8, "0", STR_PAD_LEFT));
			
						
			$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", str_pad($fci['articulo']['codigo_barras'], 13, "0", STR_PAD_LEFT));
			$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $fci['articulo']['descripcion_sist']);
			$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $fci['articulo']['laboratorio']['nombre']);
			$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $fci['cantidad_facturada']);
			$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $fci['descuento']);
			$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", $facturasCabecera['transfer']);	
      $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", $fci['articulo']['categoria_id']);
			     
			$objPHPExcel->getActiveSheet()->setSharedStyle($bordes,  $filas);
			$objPHPExcel->getActiveSheet()->getStyle("C$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
			$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			//
			

			//$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
			}
			endforeach; 	
			
		
	endforeach; 



	

//recorrer las columnas
foreach (range('A', 'L') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
 
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
 
 
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo

$namefile= '"Facturas_descuentos_'.$this->request->session()->read('Auth.User.codigo').'.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);//.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');