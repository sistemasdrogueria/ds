<?php 
 ini_set('memory_limit', '5120M');
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur"); //autor
$objPHPExcel->getProperties()->setTitle("Listado Productos"); //titulo
 
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
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'TROQUEL');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'DESCRIPCION');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'EAN');
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'EAN2');
		$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'EAN3');
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'CATEGORIA');
		
		$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'STOCK');
		$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'IVA');
    $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'P.C/ DTO');
		$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", 'LABORATORIO');
    $objPHPExcel->getActiveSheet()->SetCellValue("K$fila", 'ACT. DE PRECIO');
    $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", 'AMP');
    $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas);
		$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true);
		
		$lab = $laboratorios; 
		//$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
 
  $descuento_pf =$this->request->session()->read('Auth.User.pf_dcto');	
  
  $condicion = $this->request->session()->read('Auth.User.condicion');
  $coef = $this->request->session()->read('Auth.User.coef');	
  foreach ($articulos as $articulo):
			$fila+=1;
			$filas = "A$fila:L$fila"; 
			//$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", str_pad( $articulo['troquel'], 8, "", STR_PAD_LEFT));
			$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $articulo['troquel']);	
			$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $articulo['descripcion_sist']);
			$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $articulo['codigo_barras']);
			$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $articulo['codigo_barras2']);
			$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $articulo['codigo_barras3']);
			$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $articulo['categoria_id']);			
			
			$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $articulo['stock']);		
			if ($articulo['iva']) $itemart = '1'; else $itemart = '0';			
      $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $itemart);	
      $precio_con_dcto =0;
      if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3) &&($articulo['categoria_id'] !=2))
      {
            if ($articulo['categoria_id'] ===1)	$coef2 =1;
            else $coef2 = $coef;
            if ($articulo['laboratorio_id']==15) $coef2 = 0.892; 
                $precio = $articulo['precio_publico'];
            if ($articulo['iva'] ==1)
                $precio = $precio/(1.21);
              
            if ($articulo['msd']!=1){
              $precio = $precio*$descuento_pf*$coef2;
              if ($condicion >0 ) $precio -= $precio*$condicion/100;
                $precio_con_dcto = $precio;
            }
            else
            {
              $precio_con_dcto = $precio*$descuento_pf*$coef2;
            }
            if ($articulo['mcdp']==1)
                {
                  $precio = $articulo['precio_publico'];
                  $precio -= $precio*($condiciongeneral-1)/100;
                  $precio_con_dcto = $precio;
                }
      
        if ($precio_con_dcto!=0 && $articulo['cadena_frio']==1 && $articulo['subcategoria_id']!=10)
        $precio_con_dcto = $precio_con_dcto*1.0248;
      }
      else
      {
        if ($articulo['id']>27338 && $articulo['id']<27345)
        $descuento_pf =0.807;
        $precio = $articulo['precio_publico']*$descuento_pf;
        if ($coef !=1)	$precio = $precio*$coef;
        $precio_con_dcto = $precio;
      
      }  



			$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", str_replace(',','', number_format(round($precio_con_dcto, 3),2)));
			$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $lab[$articulo['laboratorio_id']]);	
 		
			$objPHPExcel->getActiveSheet()->setCellValue("K$fila", PHPExcel_Shared_Date::PHPToExcel( $articulo['precio_actualizacion'] ));
      $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", $articulo['clave_amp']);	
			$objPHPExcel->getActiveSheet()->setSharedStyle($bordes,  $filas);
			
			$objPHPExcel->getActiveSheet()->getStyle("C$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			$objPHPExcel->getActiveSheet()->getStyle("D$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			$objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			$objPHPExcel->getActiveSheet()->getStyle("A$fila:B$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
			$objPHPExcel->getActiveSheet()->getStyle("C$fila:F$fila")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
      $objPHPExcel->getActiveSheet()->getStyle("K$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
		
			//$objPHPExcel->getActiveSheet()->getStyle("F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			$objPHPExcel->getActiveSheet()->getStyle("I$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
	
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

$namefile= '"'.$this->request->session()->read('Auth.User.codigo').'.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename="PRODUCTOS.xlsx"');//.$namefile);
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