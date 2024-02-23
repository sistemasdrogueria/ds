<?php 
if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
if ($articulo['descuentos'][0]['tipo_venta']=='D')
if ($articulo['descuentos'][0]['tipo_oferta']=='TH')
		{
			echo $articulo['descuentos'][0]['uni_min'];			
		}
if ($articulo['descuentos'][0]['dto_drogueria'] == $articulo['carritos'][0]['descuento'])
{
echo $articulo['descuentos'][0]['uni_min'];
}
else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')
	echo $articulo['carritos'][0]['unidad_minima'];
else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')
	echo $articulo['descuentos'][1]['uni_min'];
}
?>