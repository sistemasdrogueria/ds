<?php 
$precio_con_dcto =0;
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3) &&($articulo['categoria_id'] !=2))
{
	if ($articulo['categoria_id'] ===1)	$coef2 =1;
	else $coef2 = $coef;
	//if ($articulo['laboratorio_id']==15) $coef2 = 0.892; 

				
	if ($carrito['tipo_venta']=='D')
	{
		//if ($carrito['descuentos'] ; == $articulo['carritos'][0]['descuento'])
		$descuentooferta = $carrito['descuentos'] ;
		/*else
		if (count($articulo['descuentos'])>1)
			$descuentooferta = $articulo['descuentos'][1]['dto_drogueria'];
			else
			$descuentooferta= $articulo['carritos'][0]['descuento'];
		*/
		if ($carrito['tipo_precio'] =='P')
		{
			if ($carrito['tipo_oferta']=='TH')
				$descuentooferta = $carrito['descuentos'] +$condiciongeneral;
			
			
			$precio  = $articulo['precio_publico'];
			$precio -= $precio * $descuentooferta/100;
		}
		if ($carrito['tipo_precio'] =='F')
		{
			if ($articulo['iva'] ==1)
					$precio = $articulo['precio_publico']/(1.21);
				else
					$precio = $articulo['precio_publico'];

			
			$precio  = $precio*$descuento_pf;
			$precio -= $precio*$condicion/100;
			$precio -= $precio*$descuentooferta/100;
		}
		$precio_con_dcto  = $precio;
	
	}
	else
		{
				$precio = $articulo['precio_publico'];
			  if ($articulo['iva'] == 1)
					$precio = $precio / (1.21);
				
				$precio = $precio *$descuento_pf*$coef2;
				if ($articulo['msd']!=1){
						$precio -= $precio*$condicion/100;
					}	
				

				if ($articulo['mcdp']==1)
					{
						$precio = $articulo['precio_publico'];
						$precio -= $precio*($condiciongeneral-1)/100;
					}
				$precio_con_dcto = $precio; 
					
			
		/*if ($articulo['msd']!=1){
			$precio = $articulo['precio_publico']*$descuento_pf;
			if ($condicion >0 ) $precio -= $precio*$condicion/100;
			$precio_con_dcto  = $precio;
		}
		else
		{	//echo 'OK';
		}*/
		}
	


	if ($precio_con_dcto!=0 && $articulo['cadena_frio']==1 && $articulo['subcategoria_id']!=10)
	$precio_con_dcto = $precio_con_dcto*1.0248;
}
else
{
				
if ($carrito['tipo_venta']=='D')
{
	/*
	if ($carrito['descuentos'] ; == $articulo['carritos'][0]['descuento'])
		$descuentooferta = $carrito['descuentos'] ;
		else
		if (count($articulo['descuentos'])>1)
			$descuentooferta = $articulo['descuentos'][1]['dto_drogueria'];
			else
			$descuentooferta = $articulo['carritos'][0]['descuento'];
	*/
	$descuentooferta = $carrito['descuentos'] ;

	
	$precio = $articulo['precio_publico'];
	if ($carrito['tipo_precio'] =='P')
	{
	if ($carrito['tipo_oferta']=='TH')

		$descuentooferta = $carrito['descuentos'] +$condiciongeneral;

		$precio -=$precio*$descuentooferta/100;
	}
	if ($carrito['tipo_precio'] =='F')
	{
		if ($articulo['id']>27338 && $articulo['id']<27345)
		$descuento_pf =0.807;
		$precio = $precio*$descuento_pf;
		//$precio -= $precio*$condicion/100;
		$precio -=$precio*$descuentooferta/100;
	}	
	$precio_con_dcto = $precio;
	/*if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420)
	{
		$precio_con_dcto = $precio_con_dcto*$articulo['tf_coef'];
	}
	*/

}
else
{
	if ($articulo['id']>27338 && $articulo['id']<27345)
		$descuento_pf =0.807;

	$precio = $articulo['precio_publico']*$descuento_pf;
	if ($coef !=1)	$precio = $precio*$coef;
	$precio_con_dcto = $precio;
	/*if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420)
	{
		$precio_con_dcto = $precio_con_dcto*$articulo['tf_coef'];
	}*/
}	



}
if ($precio_con_dcto!=0)
	echo '$ '.number_format(round($precio_con_dcto, 3),2,',','.'); 

?>