<?php 
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur S.A."); //autor
$objPHPExcel->getProperties()->setTitle("Listado de productos importados"); //titulo
 
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

$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "Importación de archivo - Productos Reconocidos - ".$this->request->session()->read('Auth.User.codigo'));
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:E$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:E$fila"); //establecer estilo
 
//titulos de columnas
$fila+=2;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Cant.');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'Stock');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'Descripción');
		
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'P.Publico');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'P.Farmacia');
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'DTO');
		$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'U.MIN.');
		/*$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'PLAZO');
		$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'TIPO OF.');*/
		$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'Ref.');
			
$filas = "A$fila:H$fila"; 
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita
	$descuento_pf =$this->request->session()->read('Auth.User.pf_dcto');
	foreach ($articulos as $articulo):
		
			if (count($articulo['carritos_temps'])>1)
			{
				foreach ($articulo['carritos_temps'] as $carrito_temp): 
				if ($carrito_temp['cliente_id']=$this->request->session()->read('Auth.User.cliente_id'))
				{
					$cantidad_unidades=intval($carrito_temp['cantidad']);
					$descuent = $carrito_temp['descuento'];
				
				}
				endforeach; 
			}
			else
			{
				$descuent = $articulo['carritos_temps'][0]['descuento'];
				$cantidad_unidades=intval($articulo['carritos_temps'][0]['cantidad']);
			}
				
			$fila+=1;
				// Cantidad Unidades
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $cantidad_unidades);	
				// Stock
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $articulo['stock']);	

				//Descripcion
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $articulo['descripcion_pag']);	
				
				//EAN
				//$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", str_pad($articulo['codigo_barras'], 13, "0", STR_PAD_LEFT));
				
				//Precio Publico		
				if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3))
					$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", str_replace(',','',number_format($articulo['precio_publico'],2)));	
				else
					$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 0);	
			
				
				//Precio farmacia		
				if ($descuent !=0)
					$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_replace(',','',number_format($articulo['precio_publico'],2)));
				else
					$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_replace(',','',number_format($articulo['precio_publico']*$descuento_pf,2)));

				// DESCUENTO
				if ($descuent !=0){		
				$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $articulo['carritos_temps'][0]['descuento'] );	
				$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $articulo['carritos_temps'][0]['unidad_minima']);	
				//$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $articulo['carritos_temps'][0]['plazoley_dcto']);
				//$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $articulo['carritos_temps'][0]['tipo_oferta']);					
				}
				if 	($articulo['iva'])
				{
					$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'IVA');
				}
				
		//$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", '' );		
    	$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:H$fila");
		$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		//$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
endforeach;	
$fila+=1;
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $totalunidadestemp);	
			$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'ITEMS: '.$totalitemstemp);	
			
			$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'TOTAL');	
			$objPHPExcel->getActiveSheet()->SetCellValue("E$fila",str_replace(',','',number_format($totalcarritotemp,2)));
			$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
			
			$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true);
$fila+=2;

$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Importación de archivo - Productos No Encontrados.');
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:E$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:E$fila"); //establecer estilo

	$fila+=2;
	$noimportados=$this->request->session()->read('noimportados');
		
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Cant.');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'Descripción');
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'EAN');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'Linea Completa');
		$objPHPExcel->getActiveSheet()->mergeCells("E$fila:H$fila");
			
$filas = "A$fila:H$fila"; 
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita

		foreach ($noimportados as $noimportado):
		
							
			$fila+=1;
				// Cantidad Unidades
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $noimportado[0]);	
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $noimportado[3]);	
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", str_pad($noimportado[2], 13, "0", STR_PAD_LEFT));
				$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $noimportado[1]);
				$objPHPExcel->getActiveSheet()->mergeCells("E$fila:H$fila"); //unir celdas
				
			$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:H$fila");
			$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		endforeach;		
		
		
	$fila+=2;
	$objPHPExcel->getActiveSheet()->setCellValue("C$fila", "Generado:");
	
	$objPHPExcel->getActiveSheet()->setCellValue("D$fila", date('Y-m-d H:i:s'));
	$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYMINUS);
	$objPHPExcel->getActiveSheet()->mergeCells("D$fila:H$fila"); //unir celdas
	
	$fila+=2;
	$objPHPExcel->getActiveSheet()->setCellValue("C$fila", "Drogueria Sur S.A.");
	$objPHPExcel->getActiveSheet()->mergeCells("C$fila:H$fila"); //unir celdas

	//recorrer las columnas
foreach (range('A', 'H') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
 
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
 
 
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo

$namefile= '"Importacion - '.$this->request->session()->read('Auth.User.codigo').'.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');