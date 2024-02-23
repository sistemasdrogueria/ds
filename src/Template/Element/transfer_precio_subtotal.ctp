<?php 
$cant_carrito=$carrito['cantidad'];
$subtotal = 0;
//MEDICAMENTOS
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3) &&($articulo['categoria_id'] !=2))
{
	if ($articulo['categoria_id'] ===1)	  $coef2 = 1; else $coef2 = $coef; 
	if ($articulo['laboratorio_id']===15) $coef2 = 0.892; 
	

		//TIPO_VENTA=D
		if ($carrito['tipo_venta']=='D')
		{
		$cant_uni_min = $carrito['uni_min'];
		//TIPO_PRECIO P
		if ($carrito['tipo_precio']=='P')
		{
			
			 if ($cant_carrito>=$cant_uni_min)
			 { 
				 $descuento_dro=$carrito['descuentos'] ;
				 if($carrito['tipo_oferta']=='TH')

				 {
					$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
					$descuento_dro+= $condiciongeneral;
				 }
				 
				 
				if ($descuento_dro == $carrito['descuento'])
				$descuentooferta = $descuento_dro;
				else
				if (count($articulo['descuentos'])>1)
					$descuentooferta = $carrito['descuento'];
					else
					$descuentooferta=0;
				
				if ($articulo['laboratorio_id']===15) $coef2 = $coef;
				$precio = $articulo['precio_publico']*$coef2;
				

				$precio -=$precio*$descuentooferta/100;
				$subtotal = $precio * $cant_carrito;
			 }
			 else
			 {
				$precio  = $articulo['precio_publico'];
				$precio  = $precio*$descuento_pf*$coef2;
				if ($articulo['msd']!=1)
				$precio -= $precio*$condicion/100;
				$subtotal = $precio*$cant_carrito; 
			 }
		}
		
		else
		{
		//TIPO_PRECIO F
			if ($carrito['tipo_precio']=='F')
			{
				$precio = $articulo['precio_publico']/(1.21);
					
				if ($cant_carrito>=$cant_uni_min)
				{
				
				$descuentooferta = $carrito['descuento'];
			

					$precio  = $precio*$descuento_pf * $coef2;
					$precio -= $precio*$condicion/100;
					$precio -= $precio*$descuentooferta/100;
					$subtotal = $precio**$cant_carrito;
				}
				else
					$subtotal = $articulo['precio_publico']*$descuento_pf*$coef2*$cant_carrito; 
			}
		}
		}
		else
		{
			$precio = $articulo['precio_publico']*$descuento_pf*$coef2;
			if ($articulo['msd']!=1){
				$precio -= $precio*$condicion/100;
			}			
			$subtotal = $precio * $cant_carrito;
			//echo 'ok1';
		}

	
	if ($subtotal!=0 && $articulo['cadena_frio']==1 && $articulo['subcategoria_id']!=10)
		$subtotal = $subtotal*1.0248;
}
else
{
	if ($articulo['descuentos']!=null){ 				
	if ($carrito['tipo_venta']=='D')
	{
		$cant_uni_min = $carrito['uni_min'];
		if ($cant_carrito>=$cant_uni_min)
		{
			if ($carrito['descuento'] == $carrito['descuento'])
				$descuentooferta = $carrito['descuento'];
				else
				if (count($articulo['descuentos'])>1)
					$descuentooferta = $carrito['descuento'];
			//$descuentooferta = $carrito['descuento'];
			$precio = $articulo['precio_publico'];
			if ($carrito['tipo_precio']=='P')
			{
				$precio -=$precio*$descuentooferta/100;
			}
			if ($carrito['tipo_precio']=='F')
			{
				if ($articulo['id']>27338 && $articulo['id']<27345)
				$descuento_pf =0.807;
				else
				$descuento_pf= $descuento_pf;

				$precio = $precio*$descuento_pf;
				//$precio -= $precio*$condicion/100;
				$precio -=$precio*$descuentooferta/100;
			}	
				$subtotal = $precio * $cant_carrito;
		}
		else
		{
			$precio = $articulo['precio_publico']*$descuento_pf;
			if ($coef !=1)	$precio = $precio*$coef;
				$subtotal = $precio * $cant_carrito;
		}
			
	}
	else
	{
		$precio = $articulo['precio_publico']*$descuento_pf;
			if ($coef !=1)	$precio = $precio*$coef;
				$subtotal = $precio * $cant_carrito;

				if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420) 
				{
					$subtotal = $subtotal*$articulo['tf_coef'];
				}
			
		
	}
	}
	else
	{
			$precio = $articulo['precio_publico']*$descuento_pf;
			if ($coef !=1)	$precio = $precio*$coef;
				$subtotal = $precio * $cant_carrito;
				if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420)
				{
					
					$subtotal = $subtotal*$articulo['tf_coef'];
				}

	}
		
}
if ($subtotal!=0)
	echo '$ '.number_format(round($subtotal, 3),2,',','.'); 	
?>