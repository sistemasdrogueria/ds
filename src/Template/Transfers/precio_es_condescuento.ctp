<?php 
$precio_con_dcto =0;
if ($articulo['preventas']!=null){ 				
if ($articulo['preventas'][0]['tipo_venta']=='D')
{
	$descuentooferta = $articulo['preventas'][0]['dto_drogueria'];
	$precio = $articulo['precio_publico'];
	if ($articulo['preventas'][0]['tipo_precio']=='P')
	{
		$precio -=$precio*$descuentooferta/100;
	}
	if ($articulo['preventas'][0]['tipo_precio']=='F')
	{
		$precio = $precio*$descuento_pf;
		//$precio -= $precio*$condicion/100;
		$precio -=$precio*$descuentooferta/100;
	}	
	$precio_con_dcto = $precio;
}	
}

if ($precio_con_dcto!=0)
{
	$precio_con_dcto = $precio_con_dcto*1.21;
	echo '$ '.number_format(round($precio_con_dcto, 3),2,',','.'); 
}
?>