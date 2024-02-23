<?php 
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3))
{
	if ($articulo['iva']==0) echo '$ '.number_format($articulo['precio_publico'],2,',','.'); 
}
?>