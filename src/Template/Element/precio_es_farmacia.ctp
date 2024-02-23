<?php 
$precio_farmacia =0;
$precio = $articulo['precio_publico']*$descuento_pf;
if ($coef !=1)	$precio = $precio*$coef;
$precio_farmacia = $precio;
if ($precio_farmacia!=0)
{
	$precio_farmacia = $precio_farmacia*1.21;
echo '$ '.number_format(round($precio_farmacia, 3),2,',','.'); 
}
?>