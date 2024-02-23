<?php 
$cant_carrito=$articulo['carritos'][0]['cantidad'];
$subtotal = 0;
//MEDICAMENTOS
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3) &&($articulo['categoria_id'] !=2))
{
	if ($articulo['categoria_id'] ===1)	  $coef2 = 1; else $coef2 = $coef; 
	//if ($articulo['laboratorio_id']===15) $coef2 = 0.892; 
	
	//DESCUENTOS
	if ($articulo['descuentos']!=null)
	{
		//TIPO_VENTA=D
		if ($articulo['descuentos'][0]['tipo_venta']=='D')
		{
		$cant_uni_min = $articulo['descuentos'][0]['uni_min'];
		//TIPO_PRECIO P
		if ($articulo['descuentos'][0]['tipo_precio']=='P')
		{
			
			 if ($cant_carrito>=$cant_uni_min)
			 {
				
				if ($articulo['descuentos'][0]['dto_drogueria'] == $articulo['carritos'][0]['descuento'])
					$descuentooferta = $articulo['descuentos'][0]['dto_drogueria'];
					else
						if (count($articulo['descuentos'])>1)
							$descuentooferta = $articulo['descuentos'][1]['dto_drogueria'];
							else
							$descuentooferta =$articulo['carritos'][0]['descuento'];


				if ($articulo['descuentos'][0]['tipo_oferta']=='TH')
					$descuentooferta = $articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral; 
				
				$precio = $articulo['precio_publico'];
				if ($articulo['iva'] ==1)
					if ($this->request->session()->read('Auth.User.codigo_postal')!=9410 && $this->request->session()->read('Auth.User.codigo_postal')!=9420) 	
					{					
						$precio = $articulo['precio_publico']/(1.21);
					}
				

				//$precio = $articulo['precio_publico']*$coef2;
				$precio = $precio*$coef2;

				$precio -=$precio*$descuentooferta/100;
				$subtotal = $precio * $cant_carrito;
			 }
			 else
			 {
				$precio = $articulo['precio_publico']; 
				if ($articulo['iva'] ==1)
				if ($this->request->session()->read('Auth.User.codigo_postal')!=9410 && $this->request->session()->read('Auth.User.codigo_postal')!=9420) 	
					{					
						$precio = $articulo['precio_publico']/(1.21);
					}

				//$precio  = $articulo['precio_publico'];
				$precio  = $precio*$descuento_pf*$coef2;
				if ($articulo['msd']!=1)
				$precio -= $precio*$condicion/100;
				
				if ($articulo['mcdp']==1)
					{
						$precio = $articulo['precio_publico'];
						$precio -= $precio*($condiciongeneral-1)/100;
					}
				

				$subtotal = $precio*$cant_carrito; 
			 }
		}
		
		else
		{
		//TIPO_PRECIO F
			if ($articulo['descuentos'][0]['tipo_precio']=='F')
			{
				$precio = $articulo['precio_publico'];
				if ($articulo['iva'] ==1)
				if ($this->request->session()->read('Auth.User.codigo_postal')!=9410 && $this->request->session()->read('Auth.User.codigo_postal')!=9420) 	
					{					
						$precio = $articulo['precio_publico']/(1.21);
					}
				//$precio = $articulo['precio_publico']/(1.21);
				
				
				if ($articulo['descuentos'][0]['dto_drogueria'] == $articulo['carritos'][0]['descuento'])
					$descuentooferta = $articulo['descuentos'][0]['dto_drogueria'];
					else
						if (count($articulo['descuentos'])>1)
							$descuentooferta = $articulo['descuentos'][1]['dto_drogueria'];
							else
							$descuentooferta =$articulo['carritos'][0]['descuento'];

				if ($cant_carrito>=$cant_uni_min)
				{
					//$descuentooferta = $articulo['descuentos'][0]['dto_drogueria'];
					$precio  = $precio*$descuento_pf * $coef2;
					if ($articulo['msd']!=1)
					$precio -= $precio*$condicion/100;
					$precio -= $precio*$descuentooferta/100;
					$subtotal = $precio*$cant_carrito;
				}
				else
				{
					$subtotal = $precio*$descuento_pf*$coef2*$cant_carrito; 
					if ($articulo['iva'] ==1)
					{
						//$descuentooferta = $articulo['descuentos'][0]['dto_drogueria'];
						$precio  = $precio*$descuento_pf * $coef2;
						if ($articulo['msd']!=1)
						$precio -= $precio*$condicion/100;
						//$precio -= $precio*$descuentooferta/100;
						$subtotal = $precio*$cant_carrito;
					}


					if ($articulo['mcdp']==1)
					{
						$precio = $articulo['precio_publico'];
						$precio -= $precio*($condiciongeneral-1)/100;
						$subtotal = $precio * $cant_carrito;
					}
					
				}
			}
		}
		}
		else
		{
			$precio = $articulo['precio_publico'];
			if ($articulo['iva'] ==1)
			if ($this->request->session()->read('Auth.User.codigo_postal')!=9410 && $this->request->session()->read('Auth.User.codigo_postal')!=9420) 	
					{					
						$precio = $articulo['precio_publico']/(1.21);
					}


			$precio = $precio*$descuento_pf*$coef2;
			if ($articulo['msd']!=1){
				$precio -= $precio*$condicion/100;
			}	
			if ($articulo['mcdp']==1)
					{
						$precio = $articulo['precio_publico'];
						$precio -= $precio*($condiciongeneral-1)/100;
					}		
			$subtotal = $precio * $cant_carrito;
			//echo 'ok1';
		}
	}
	else
	{
			$precio = $articulo['precio_publico']*$descuento_pf*$coef2;
			if ($articulo['msd']!=1){
				$precio -= $precio*$condicion/100;
			}	
			if ($articulo['mcdp']==1)
					{
						$precio = $articulo['precio_publico'];
						$precio -= $precio*($condiciongeneral-1)/100;
					}			
			$subtotal = $precio * $cant_carrito;
			//echo 'ok2';
	}
	if ($subtotal!=0 && $articulo['cadena_frio']==1 && $articulo['subcategoria_id']!=10)
		$subtotal = $subtotal*1.0248;
}
else
{
	if ($articulo['descuentos']!=null){ 				
	if ($articulo['descuentos'][0]['tipo_venta']=='D')
	{
		$cant_uni_min = $articulo['descuentos'][0]['uni_min'];
		if ($cant_carrito>=$cant_uni_min)
		{

			
			if ($articulo['descuentos'][0]['dto_drogueria'] == $articulo['carritos'][0]['descuento'])
			$descuentooferta = $articulo['descuentos'][0]['dto_drogueria'];
			else
				if (count($articulo['descuentos'])>1)
					$descuentooferta = $articulo['descuentos'][1]['dto_drogueria'];
					else
					$descuentooferta =$articulo['carritos'][0]['descuento'];



			if ($articulo['descuentos'][0]['tipo_oferta']=='TH')
				
					$descuentooferta = $articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral; 
					
			$precio = $articulo['precio_publico'];
			if ($articulo['descuentos'][0]['tipo_precio']=='P')
			{
				$precio -=$precio*$descuentooferta/100;
			}
			if ($articulo['descuentos'][0]['tipo_precio']=='F')
			{
				if ($articulo['id']>27338 && $articulo['id']<27345)
				$descuento_pf2 =0.807;
				else
				$descuento_pf2= $descuento_pf;
				$precio = $precio*$descuento_pf2;
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
		if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420) 				
				{
					$subtotal = $subtotal *$articulo['tf_coef'];
					
				}
	}
	else
	{
		$precio = $articulo['precio_publico']*$descuento_pf;
			if ($coef !=1)	$precio = $precio*$coef;
				$subtotal = $precio * $cant_carrito;
				if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420) 				
				{
					$subtotal = $subtotal *$articulo['tf_coef'];
					
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
					$subtotal = $subtotal *$articulo['tf_coef'];
					
				}
			
	}
		
}
if ($subtotal!=0)
	echo '$ '.number_format(round($subtotal, 3),2,',','.'); 	
?>