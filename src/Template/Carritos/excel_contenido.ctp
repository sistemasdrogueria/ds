<?php 
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur S.A."); //autor
$objPHPExcel->getProperties()->setTitle("CONTENIDO CARRITO"); //titulo
 
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
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');
$coef_pyf = $this->request->session()->read('Auth.User.coef_pyf');
$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
$condiciongeneralmsd= 100*(1-($descuento_pf));
$condiciongeneralcf = 100*(1-($descuento_pf *1.0248* (1-$condicion/100)));
$condiciongeneralaz = 100*(1-($descuento_pf *0.892));
 
//titulos de columnas
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Cant.');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'EAN');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'Descripción');
		
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'P.Publico');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'P.c/ Dto');
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'DTO');
		$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'U.MIN.');
		/*$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'PLAZO');*/
		
		$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'Ref.');
		$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'TROQUEL');
		$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", 'Cargado');
			
$filas = "A$fila:J$fila"; 
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita
	$descuento_pf =$this->request->session()->read('Auth.User.pf_dcto');
	foreach ($carritos as $carrito):
			$articulo = $carrito['articulo'];
			
			
			//$descuent = $carrito['descuento'];
			$cantidad_unidades=intval($carrito['cantidad']);
			$descuent =0; 
			$unidad_minima =0;

			if (!empty($articulo['descuentos']))
			{
				if ($articulo['descuentos'][0]['tipo_venta'] =='D')
				{
				
				$descuent = $articulo['descuentos'][0]['dto_drogueria'];
				$unidad_minima=$articulo['descuentos'][0]['uni_min'];
				}
				else
				{
					if (count($articulo['descuentos'])>1)
					{
						if ($articulo['descuentos'][1]['tipo_venta'] =='D')
						{
						//ok 
						$descuent = $articulo['descuentos'][1]['dto_drogueria'];
						$unidad_minima=$articulo['descuentos'][1]['uni_min'];
						}
							

					}				
				}
			}

			$fila+=1;
				// Cantidad Unidades
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $cantidad_unidades);	
				// Stock
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $articulo['codigo_barras']);	

				//Descripcion
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $articulo['descripcion_pag']);	
				
				//EAN
				//$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", str_pad($articulo['codigo_barras'], 13, "0", STR_PAD_LEFT));
				
				
				
				
				
				$vowels = ["$ ", "."];
				//Precio Publico		
				$precio_publico = $this->element('precio_publicox',['articulo'=>$articulo,'coef_pyf'=>$coef_pyf,'coef'=>$coef,'descuento_pf'=>$descuento_pf]);
				$precio_publico = str_replace($vowels,'',$precio_publico);
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila",str_replace(',','.',$precio_publico));
				
				
				
				
				//Precio farmacia		
				$precio_condescuento = $this->element('precio_condescuento',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef , 'condiciongeneral'=>$condiciongeneral] );
				$precio_condescuento = str_replace($vowels,'',$precio_condescuento);
				$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_replace(',','.',$precio_condescuento));
				
				
				
				// DESCUENTO
				$vowels2 = ['<font color="red" style="font-weight: bold;">', ' </font>', '%', ' '];
				$porcentaje_descuento = $this->element('precio_descuento_porcentaje',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef , 'condiciongeneral'=>$condiciongeneral, 'condiciongeneralmsd'=>$condiciongeneralmsd,'condiciongeneralcf'=>$condiciongeneralcf] );
				$porcentaje_descuento = str_replace($vowels2,'',$porcentaje_descuento);
				

				$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", str_replace(',','.',$porcentaje_descuento));	
				if ($descuent !=0){		
				$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $unidad_minima);	
				//$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $articulo['carritos'][0]['plazoley_dcto']);
				//$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $articulo['carritos'][0]['tipo_oferta']);					
				}
				if 	($articulo['iva'])
				{
					$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'IVA');
				}
				$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $articulo['troquel']);
				if (is_null($carrito['user_id']))
				$usuario = ""; 
				else
				$usuario = $users[$carrito['user_id']];
				$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $usuario);
		
    	$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:J$fila");
		$objPHPExcel->getActiveSheet()->getStyle("B$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		
		
		endforeach;	
$fila+=1;
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $totalunidadesexcel);	
			$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'ITEMS: '.$totalitemsexcel);	
			
//			$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'TOTAL');	
			//$objPHPExcel->getActiveSheet()->SetCellValue("E$fila",str_replace(',','',number_format($totalcarritotemp,2)));
			//$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
			
			$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true);	
		
	$fila+=2;
	$objPHPExcel->getActiveSheet()->setCellValue("C$fila", "Generado:");
	
	$objPHPExcel->getActiveSheet()->setCellValue("D$fila", date('Y-m-d H:i:s'));
	$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYMINUS);
	$objPHPExcel->getActiveSheet()->mergeCells("D$fila:H$fila"); //unir celdas
	
	$fila+=2;
	$objPHPExcel->getActiveSheet()->setCellValue("C$fila", "Drogueria Sur S.A.");
	$objPHPExcel->getActiveSheet()->mergeCells("C$fila:H$fila"); //unir celdas

	//recorrer las columnas
foreach (range('A', 'J') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
 
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
 
 
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo

$namefile= '"Carritos - '.$this->request->session()->read('Auth.User.codigo').'.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');