<?php
ini_set('memory_limit', '5120M');
//ajuntar la libreria excel
require_once ROOT . DS . 'vendor' . DS . 'phpexcel' . DS . 'PHPExcel.php';

$objPHPExcel = new PHPExcel(); //nueva instancia

$objPHPExcel->getProperties()->setCreator("Drogueria Sur"); //autor
$objPHPExcel->getProperties()->setTitle("Listado Productos"); //titulo

//inicio estilos
$titulo = new PHPExcel_Style(); //nuevo estilo
$titulo->applyFromArray(
    array(
        'alignment' => array( //alineacion
            'wrap' => false,
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ),
        'font' => array( //fuente
            'bold' => true,
            'size' => 20
        )
    )
);

$subtitulo = new PHPExcel_Style();
$subtitulo2 = new PHPExcel_Style();
$subtitulo3 = new PHPExcel_Style(); //nuevo estilo
$separatorBorder = new PHPExcel_Style();

$subtitulo->applyFromArray(
    array(
        'fill' => array( //relleno de color
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

    )
);

$subtitulo2->applyFromArray(
    array(
        'fill' => array( //relleno de color
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'D8F2A5')
        ),

        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )

    )
);

$subtitulo3->applyFromArray(
    array(
        'fill' => array( //relleno de color
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'f8d7da')
        ),
        'borders' => array( // Asegúrate de incluir bordes
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'wrap' => false,
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )

    )
);

$separatorBorder->applyFromArray(
    array(
        'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM, // Borde más grueso para separación
                'color' => array('rgb' => '000000') // Color negro
            )
        )
    )
);



$bordes = new PHPExcel_Style(); //nuevo estilo
$bordes->applyFromArray(
    array(
        'borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )
    )
);

$celdascentradas = new PHPExcel_Style();
$celdascentradas->applyFromArray(
    array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    )
);


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

$fila = 1;
$filas = "A$fila:F$fila";
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'FECHA');
$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'DESCRIPCIÓN');
$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'DCTO');
$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'CANT FACTURADA');
$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'UNI MIN');
$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'CODIGO BARRAS');
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, $filas);
$objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true);


//$objPHPExcel->getActiveSheet()->getStyle($filas)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
foreach ($data as $articulos):


    $objPHPExcel->getActiveSheet()->setSharedStyle($separatorBorder, "A$fila:F$fila");
    $objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true);

                foreach ($articulos as $items):
        $fila += 1;
        $filas = "A$fila:F$fila";

        if ($items['dd']['id'] !== null && $items['dd']['dto_patagonia'] !== null) {
            $dto_patagonia = $items['dd']['dto_patagonia'];
            $unidades_minimas = $items['dd']['uni_min'];
        } else {
            $unidades_minimas = $items['d']['uni_min'];
            $dto_patagonia = $items['d']['dto_patagonia'];
        }
        $codigoBarras = (int) $items['a']['codigo_barras'];
        //$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", str_pad( $articulo['troquel'], 8, "", STR_PAD_LEFT));
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $items['fci']['creado']);
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $items['a']['descripcion_pag']);
        $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $dto_patagonia);
        $objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $items['fci']['cantidad_facturada']);
        $objPHPExcel->getActiveSheet()->SetCellValue("E$fila",  $unidades_minimas);
        $objPHPExcel->getActiveSheet()->SetCellValue("F$fila",$codigoBarras);

        $objPHPExcel->getActiveSheet()->getStyle("A$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
        $objPHPExcel->getActiveSheet()->getStyle("C$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $objPHPExcel->getActiveSheet()->getStyle("E$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
              $objPHPExcel->getActiveSheet()->getStyle("F$fila")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
       
        
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo3, $filas);
        $objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true);
    endforeach;
    $fila += 1;
    $objPHPExcel->getActiveSheet()->setSharedStyle($separatorBorder, "A$fila:F$fila");
    $objPHPExcel->getActiveSheet()->getStyle($filas)->getFont()->setBold(true);

endforeach;



//recorrer las columnas
foreach (range('A', 'E') as $columnID) {
    //autodimensionar las columnas
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

//establecer pie de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');


//****************Guardar como excel 2007*******************************
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo

$namefile = '"' . $this->request->session()->read('Auth.User.codigo') . '.xlsx"';
//// nombre del archivo
header('Content-Disposition: attachment; filename="PRODUCTOS.xlsx"'); //.$namefile);
//**********************************************************************

//forzar a descarga por el navegador
$objWriter->save('php://output');
$xlsData = ob_get_contents();
ob_end_clean();
$response =  array(
    'op' => 'ok',
    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
);

die(json_encode($response));
