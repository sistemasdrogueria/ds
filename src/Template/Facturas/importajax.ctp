<?php 
 ini_set('memory_limit', '1024M');
//ajuntar la libreria excel
require_once ROOT.DS.'vendor'.DS.'phpexcel'.DS.'PHPExcel.php';
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("Drogueria Sur S.A"); //autor
$objPHPExcel->getProperties()->setTitle("Detalle de INGRESARON"); //titulo
 
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
$filas = "A$fila:P$fila"; 
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "LISTADO INGRESARON");
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:P$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, $filas); //establecer estilo
 
//titulos de columnas
$fila+=1;
$filas = "A$fila:P$fila"; 
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'FECHA');
$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'CANTIDAD FACTURADA');
$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'PEDIDO DS');
$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'TROQUEL');
$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'DESCRIPCION SIST');
$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'CATEGORIA');
$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'CODIGO BARRAS.');
$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'DESCUENTO.');
$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'PRECIO TOTAL.');
$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", 'PORCENTAJE.');
$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", 'LABORATORIO.');
$objPHPExcel->getActiveSheet()->SetCellValue("L$fila", 'CODIGO.');
$objPHPExcel->getActiveSheet()->SetCellValue("M$fila", 'RAZON SOCIAL.');
$objPHPExcel->getActiveSheet()->SetCellValue("N$fila", 'CODIGO POSTAL.');
$objPHPExcel->getActiveSheet()->SetCellValue("O$fila", 'PROVINCIA.');
$objPHPExcel->getActiveSheet()->SetCellValue("P$fila", 'CUIT.');
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas);
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true); 

if(isset($combinados)){

$resultados = $combinados;

 }else{
 if(isset($resultadobarras)){
$resultados =$resultadobarras;

 }else{

$resultados =$resultadoamp;
 }



 }

 
  foreach ($resultados as $pv):

	$porcentaje = (($pv['precio_total'])*($pv['descuento']))/100;
	
			$fila+=1;
			$filas = "A$fila:P$fila"; 
			$objPHPExcel->getActiveSheet()->setCellValue("A$fila", PHPExcel_Shared_Date::PHPToExcel($pv['facturas_cabecera']['fecha']));
			$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $pv['cantidad_facturada']);		
			$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $pv['pedido_ds']);		
			$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $pv['articulo']['troquel']);	
			$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $pv['articulo']['descripcion_sist']);
			$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $pv['articulo']['categoria_id']);
            $objPHPExcel->getActiveSheet()->setCellValue("G$fila", $pv['articulo']['codigo_barras']);
			$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $pv['descuento']);		
			$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $pv['precio_total']);		
			$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $porcentaje);	// aca va un calculo
			$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", $laboratorios[$pv['articulo']['laboratorio_id']]);
			$objPHPExcel->getActiveSheet()->SetCellValue("L$fila", $pv['facturas_cabecera']['cliente']['codigo']);
            $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", $pv['facturas_cabecera']['cliente']['razon_social']);	
			$objPHPExcel->getActiveSheet()->SetCellValue("N$fila", $pv['facturas_cabecera']['cliente']['codigo_postal']);
			$objPHPExcel->getActiveSheet()->SetCellValue("O$fila",  $provincias[$pv['facturas_cabecera']['cliente']['provincia_id']]);
            $objPHPExcel->getActiveSheet()->SetCellValue("P$fila", $pv['facturas_cabecera']['cliente']['cuit']);

			$objPHPExcel->getActiveSheet()->setSharedStyle($bordes,  $filas);
            $objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
          $objPHPExcel->getActiveSheet()->getStyle("G$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			//$objPHPExcel->getActiveSheet()->getStyle("C$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
	
			
		
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

$namefile= '"ingresaron.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename='.$namefile);
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');