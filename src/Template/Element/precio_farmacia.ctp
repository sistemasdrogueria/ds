<?php 
$precio_farmacia =0;
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3) &&($articulo['categoria_id'] !=2))
{
	if ($articulo['categoria_id'] ===1)	$coef2 =1;
	else $coef2 = $coef;
	if ($articulo['laboratorio_id']==15) $coef2 = 0.892; 
	if ($articulo['descuentos']!=null)
	{ 
		$precio = $articulo['precio_publico'];
			if ($articulo['iva'] ==1)
					$precio = $precio/(1.21);
		if ($articulo['descuentos'][0]['tipo_venta']=='D' && $articulo['descuentos'][0]['tipo_precio']=='F')
		{	
				$precio = $precio *$descuento_pf*$coef2;
				if ($articulo['msd']!=1){
					$precio -= $precio*$condicion/100;
				}			
				$precio_farmacia = $precio ;
			//echo '$ '.number_format($articulo['precio_publico'],2,',','.'); 
		}	
		else
		{	
		if ($articulo['descuentos'][0]['tipo_venta']=='D')
			{
				$precio = $precio *$descuento_pf*$coef2;
				if ($articulo['msd']!=1){
					$precio -= $precio*$condicion/100;
				}			
				$precio_farmacia = $precio ;
				
				//echo '$ '.number_format($articulo['precio_publico'],2,',','.'); 
			}	
		else
			{
				$precio = $precio *$descuento_pf*$coef2;
				if ($articulo['msd']!=1){
						$precio -= $precio*$condicion/100;
					}	
				$precio_farmacia = $precio; 
			}
		}
	}
	else 
	{
			$precio = $articulo['precio_publico'];
			if ($articulo['iva'] ==1)
					$precio = $precio/(1.21);
				
			if ($articulo['msd']!=1){
				$precio = $precio*$descuento_pf*$coef2;
				if ($condicion >0 ) $precio -= $precio*$condicion/100;
					$precio_farmacia = $precio;
			}
			else
			{
				$precio_farmacia = $precio*$descuento_pf*$coef2;
			}		
	}
	if ($precio_farmacia!=0 && $articulo['cadena_frio']==1 && $articulo['subcategoria_id']!=10)
	$precio_farmacia = $precio_farmacia*1.0248;
}
else
{
	if ($articulo['id']>27338 && $articulo['id']<27345)
		$descuento_pf =0.807;

	$precio = $articulo['precio_publico']*$descuento_pf;
	if ($coef !=1)	$precio = $precio*$coef;
	$precio_farmacia = $precio;
}
if ($precio_farmacia!=0)
	echo '$ '.number_format(round($precio_farmacia, 3),2,',','.'); 

?>