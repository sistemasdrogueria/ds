<?php 
$precio_con_dcto =0;
if (($articulo['articulo']['categoria_id'] !=5) && ($articulo['articulo']['categoria_id'] !=4)  && ($articulo['articulo']['categoria_id'] !=3) &&($articulo['articulo']['categoria_id'] !=2))
{
	if ($articulo['articulo']['categoria_id'] ===1)	$coef2 =1;
	else $coef2 = $coef;
	//if ($articulo['laboratorio_id']==15) $coef2 = 0.892; 

	if ($articulo['articulo']['preventas']!=null){ 				
	if ($articulo['articulo']['preventas'][0]['tipo_venta']=='D')
	{
		if ($articulo['articulo']['preventas'][0]['tipo_precio']=='P')
		{
			if ($articulo['articulo']['preventas'][0]['tipo_oferta']!='TH')

			if(!empty($articulo['descuento'])){
				$descuentooferta = $articulo['descuento'];
			}else{

$descuentooferta = $articulo['articulo']['preventas'][0]['dto_drogueria'];

			}
		     	
				
			else 
			if(!empty($articulo['descuento'])){
				$descuentooferta = $articulo['descuento']+$condiciongeneral;
			}else{

				$descuentooferta = $articulo['articulo']['preventas'][0]['dto_drogueria']+$condiciongeneral;

			}
				
			
			
			$precio  = $articulo['articulo']['precio_publico'];
			$precio -= $precio * $descuentooferta/100;
		}
		if ($articulo['articulo']['preventas'][0]['tipo_precio']=='F')
		{
			if ($articulo['iva'] ==1)
					$precio = $articulo['articulo']['precio_publico']/(1.21);
				else
					$precio = $articulo['articulo']['precio_publico'];
					if(!empty($articulo['descuento'])){
						$descuentooferta = $articulo['descuento'];
					}else{
		
						$descuentooferta = $articulo['articulo']['preventas'][0]['dto_drogueria'];
		
					}
			$precio  = $precio*$descuento_pf;
			$precio -= $precio*$condicion/100;
			$precio -= $precio*$descuentooferta/100;
		}
		$precio_con_dcto  = $precio;
	}
	else
		{
				$precio = $articulo['articulo']['precio_publico'];
				$precio = $precio *$descuento_pf*$coef2;
				if ($articulo['msd']!=1){
						$precio -= $precio*$condicion/100;
					}	
				

				if ($articulo['mcdp']==1)
					{
						$precio = $articulo['articulo']['precio_publico'];
						$precio -= $precio*($condiciongeneral-1)/100;
					}
				$precio_con_dcto = $precio; 
					
			
		/*if ($articulo['msd']!=1){
			$precio = $articulo['articulo']['precio_publico']*$descuento_pf;
			if ($condicion >0 ) $precio -= $precio*$condicion/100;
			$precio_con_dcto  = $precio;
		}
		else
		{	//echo 'OK';
		}*/
		}
	}
	else 
	{
			$precio = $articulo['articulo']['precio_publico'];
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
						$precio = $articulo['articulo']['precio_publico'];
						$precio -= $precio*($condiciongeneral-1)/100;
						$precio_con_dcto = $precio;
					}
			
	}

	if ($precio_con_dcto!=0 && $articulo['articulo']['cadena_frio']==1 && $articulo['articulo']['categoria_id']!=10)
	$precio_con_dcto = $precio_con_dcto*1.0248;
}
else
{
if ($articulo['articulo']['preventas']!=null){ 				
if ($articulo['articulo']['preventas'][0]['tipo_venta']=='D')
{
	if(!empty($articulo['descuento'])){
		$descuentooferta = $articulo['descuento'];
	}else{

		$descuentooferta = $articulo['articulo']['preventas'][0]['dto_drogueria'];

	}
	$precio = $articulo['articulo']['precio_publico'];
	if ($articulo['articulo']['preventas'][0]['tipo_precio']=='P')
	{
		if ($articulo['articulo']['preventas'][0]['tipo_oferta']!='TH')
		$descuentooferta = $articulo['articulo']['preventas'][0]['dto_drogueria'];
	else 
	if(!empty($articulo['descuento'])){
		$descuentooferta = $articulo['descuento']+$condiciongeneral;
	}else{

		$descuentooferta = $articulo['articulo']['preventas'][0]['dto_drogueria']+$condiciongeneral;

	}
		$precio -=$precio*$descuentooferta/100;
	}
	if ($articulo['articulo']['preventas'][0]['tipo_precio']=='F')
	{
		if ($articulo['articulo_id']>27338 && $articulo['articulo_id']<27345)
		$descuento_pf =0.807;
		$precio = $precio*$descuento_pf;
		//$precio -= $precio*$condicion/100;
		$precio -=$precio*$descuentooferta/100;
	}	
	$precio_con_dcto = $precio;
}
else
{
	if ($articulo['articulo_id']>27338 && $articulo['id']<27345)
		$descuento_pf =0.807;

	$precio = $articulo['articulo']['precio_publico']*$descuento_pf;
	if ($coef !=1)	$precio = $precio*$coef;
	$precio_con_dcto = $precio;

}	
}
else
{
	if ($articulo['articulo_id']>27338 && $articulo['articulo_id']<27345)
	$descuento_pf =0.807;

	$precio = $articulo['articulo']['precio_publico']*$descuento_pf;
	if ($coef !=1)	$precio = $precio*$coef;
	$precio_con_dcto = $precio;
	
}

}
if ($precio_con_dcto!=0)

	echo $precio_con_dcto;
	

?>