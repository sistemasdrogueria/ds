<?php 
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("CHELO"); //autor
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

$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "Estado de la Cuenta Corrientes - ".$this->request->session()->read('Auth.User.codigo'));
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:F$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:F$fila"); //establecer estilo
 
//titulos de columnas
		$fila+=1;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Fecha Fact..');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'Nro Fact');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'Nro Pedido');
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'Detalle');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'Importe');
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'Fecha Venc');
			
$filas = "A$fila:F$fila"; 
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); //negrita

foreach ($ctacteComprasSemanales as $ctacteComprasSemanale):
		$fila+=1;
		
		//detalle obra social	

		
			
				          	$objPHPExcel->getActiveSheet()->setCellValue("A$fila", date("d-m-Y",strtotime($ctacteComprasSemanale['fecha_factura'])));
                    $objPHPExcel->getActiveSheet()->setCellValue("B$fila", str_pad($ctacteComprasSemanale['ce']['seccion'], 4, "0", STR_PAD_LEFT).'-'.str_pad($ctacteComprasSemanale['ce']['numero'], 8, "0", STR_PAD_LEFT));
                    $objPHPExcel->getActiveSheet()->setCellValue("C$fila", $ctacteComprasSemanale['numero']);

                   	if ($ctacteComprasSemanale['tipo']==1)
				{
				 $objPHPExcel->getActiveSheet()->setCellValue("D$fila", "Factura Medicamentos");
               
				}
				if ($ctacteComprasSemanale['tipo']==2)
				{
                     $objPHPExcel->getActiveSheet()->setCellValue("D$fila", "Factura Perf y Accesorios");
				
				}
				if ($ctacteComprasSemanale['tipo']==3)
				{
                    $objPHPExcel->getActiveSheet()->setCellValue("D$fila", "Factura a Plazo");
			
				}
				if ($ctacteComprasSemanale['tipo']==4)
				{
                    $objPHPExcel->getActiveSheet()->setCellValue("D$fila", "Factura Transfer");
				
				}
				
                $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $ctacteComprasSemanale['importe']);

                $fechavencimiento =   date("d-m-Y",strtotime($ctacteComprasSemanale['fecha_vencimiento']));
			if ($fechavencimiento =='01-01-1970'){

                 $objPHPExcel->getActiveSheet()->setCellValue("F$fila", "Sin Cond.");
			
            }	else{

     $objPHPExcel->getActiveSheet()->setCellValue("F$fila", date("d-m-Y",strtotime($fechavencimiento)));
            }
		
    	$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:F$fila");
				
				$filas = "A$fila:F$fila"; 
      			$objPHPExcel->getActiveSheet()->setSharedStyle($tarjetas, $filas);
				
    	$objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYMINUS);
    	$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
      $objPHPExcel->getActiveSheet()->getStyle("F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYMINUS);
	
	
endforeach;	
	$fila+=2;
	$objPHPExcel->getActiveSheet()->setCellValue("A$fila", "Generado:");
	
	$objPHPExcel->getActiveSheet()->setCellValue("B$fila", date('Y-m-d H:i:s'));
	$objPHPExcel->getActiveSheet()->getStyle("B$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYMINUS);
	$fila+=2;
	$objPHPExcel->getActiveSheet()->setCellValue("A$fila", "Drogueria Sur S.A.");
	$objPHPExcel->getActiveSheet()->mergeCells("A$fila:F$fila"); //unir celdas
//recorrer las columnas
foreach (range('A', 'F') as $columnID) {
  //autodimensionar las columnas
  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
 
//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
 
 
//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo

$namefile= '"'.$this->request->session()->read('Auth.User.cliente_id').'.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename="ListadosdeFacturas.xlsx"');//.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');
$xlsData = ob_get_contents();
ob_end_clean();
$response =  array(
        'op' => 'ok',
        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
    );

die(json_encode($response));