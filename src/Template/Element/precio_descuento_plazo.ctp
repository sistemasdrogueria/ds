<?php 
if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
if ($articulo['descuentos'][0]['tipo_venta']=='D')
echo $articulo['descuentos'][0]['plazo'];
else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')
echo $articulo['descuentos'][1]['plazo'];
}
?>