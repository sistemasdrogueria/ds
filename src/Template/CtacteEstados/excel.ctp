<?php 
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur S.A."); //autor
$objPHPExcel->getProperties()->setTitle("Cta. Cte. Estado"); //titulo

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
//$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);
 
$fila=1;

$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "Estado de la Cuenta Corrientes - ".$clientes[$this->request->session()->read('cliente_id')]);
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
	$tiposobras = $obrasociales->toArray();
	$total =0;
	$primero =0;
	foreach ($ctacteEstados as $ctacteestado): 
		$fila+=1;
		
		//detalle obra social	
		$primerao =0;
		if (count($ctacteestado['ctacte_obras_sociales'])==0)
			{   
				// A - Fecha Vencimiento
				if (date_format($ctacteestado->fecha_vencimiento,'d-m-Y')!="01-01-0101")
					$objPHPExcel->getActiveSheet()->setCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel( $ctacteestado->fecha_vencimiento ));
				else
					$objPHPExcel->getActiveSheet()->setCellValue("A$fila", "");
				// B - detalle
				if ($ctacteestado['ctacte_tipo_registros_id']==1 && $ctacteestado->importe == $totaltarjetacredito)
								$detalle = 'Tarjetas de Credito';
						  else
								if ($ctacteestado->signo==0 && $ctacteestado->ctacte_tipo_registros_id==4)
										$detalle= 'Nota de Debito';
									else
										$detalle= $tiporegistros[$ctacteestado['ctacte_tipo_registros_id']]; 	
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $detalle);	
				// C - fecha compra
				if (date_format($ctacteestado->fecha_compra,'d-m-Y')!="01-01-0101" && date_format($ctacteestado->fecha_compra,'d-m-Y')!="01-01-1970")
					$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", PHPExcel_Shared_Date::PHPToExcel( $ctacteestado->fecha_compra));	
				else
					$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", "");	
				// D - importe
				if ($ctacteestado->signo==1)
					$importe = -1 * $ctacteestado->importe; 
				else
					$importe = 	$ctacteestado->importe;
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", str_replace(',','',number_format($importe,2)));
				// E - total
				if ($ctacteestado->signo==1)
						$total = $total - $ctacteestado->importe;
					else
						$total = $total + $ctacteestado->importe;
				$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_replace(',','', number_format($total,2)));
			}
			else
			{
				// Registro Obra Social
				if (count($ctacteestado['ctacte_obras_sociales'])==1) 
				{
					foreach ($ctacteestado['ctacte_obras_sociales'] as $ctacteObrasSociale):
						
						$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel($ctacteObrasSociale['fecha']));
						
						$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'O. Social - '.$tiposobras[$ctacteObrasSociale['obra_social_id']] );			
						$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $ctacteObrasSociale['nro_nota'] );	
						if ($ctacteestado->signo==1)
								$importe = -1 * $ctacteestado->importe;
							else
								$importe =  $ctacteestado->importe;
						
						$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", str_replace(',','',number_format($importe,2)));	
						if ($ctacteestado->signo==1)
							$total = $total - $ctacteestado->importe;
						else
							$total = $total + $ctacteestado->importe;
						$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_replace(',','', number_format($total,2)));
					endforeach; 
				}
				else
				{
					$primerao =0;
					
					foreach ($ctacteestado['ctacte_obras_sociales'] as $ctacteObrasSociale):
						
					    if ($primerao==0)
						{
							
							if ($ctacteestado->signo==1)
								$total = $total - $ctacteestado->importe;
							else
								$total = $total + $ctacteestado->importe;
							$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_replace(',','', number_format($total,2)));	
							$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel($ctacteObrasSociale['fecha']));
							$primerao=1;
						}
						
						else
							$fila+=1;
						if ($ctacteestado->signo==1)
								$importe =  -1 * $ctacteObrasSociale['importe'];
							else
								$importe =  $ctacteObrasSociale['importe'];
						$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'O. Social - '.$tiposobras[$ctacteObrasSociale['obra_social_id']] );			
						$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $ctacteObrasSociale['nro_nota'] );		
						$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", str_replace(',','',number_format($importe,2)));
						$filas = "B$fila:D$fila"; 
						
						
						//$objPHPExcel->getActiveSheet()->setSharedStyle($tarjetas, $filas);
						$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:E$fila");
						$objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
						$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
						$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
	
					endforeach; 
					
					
				}
			}
		
    	$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:E$fila");
		$objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
		if (count($ctacteestado['ctacte_obras_sociales'])==0)
			{ 
		$objPHPExcel->getActiveSheet()->getStyle("C$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
			}
		$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
			
		$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
	
	//detalle Tarjeta	
	if ($primero ==0 and $ctacteestado['ctacte_tipo_registros_id'] ==1) 
	{
		
		$fila+=1;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Fecha');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'Detalle');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'N° Cupón');
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'Importe');
		//$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'Subtotal Tarj.');
		$filas = "A$fila:E$fila"; 
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo2, $filas); //establecer estilo
		$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita
			//$totalt=0;
			foreach ($ctacteestadostarjetacredito as $ctactetarjeta): 
				$fila+=1;
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel($ctactetarjeta['fecha_ingreso']));	
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $ctactetarjeta['detalle'] );		
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $ctactetarjeta['nro_liquidacion']);		
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", str_replace(',','',number_format($ctactetarjeta['importe'],2)));
				//$totalt = $totalt + $ctactetarjeta['importe'];
				//$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", str_replace(',','', number_format($totalt,2)));
				
				$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:E$fila");
				
				$filas = "A$fila:D$fila"; 
				$objPHPExcel->getActiveSheet()->setSharedStyle($tarjetas, $filas);
				
				$objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
				$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);	
				//$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
			endforeach;
	}
	$primero =1;


	
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

$namefile= '"CtaCte_'.$clientes[$this->request->session()->read('cliente_id')].'.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');