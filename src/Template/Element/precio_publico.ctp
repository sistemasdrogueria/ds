<?php 
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3))
{
	if ($articulo['iva']==0) 
	echo '$ '.number_format($articulo['precio_publico'],2,',','.'); 

}
else
	{
	/*
	if ($articulo['id']>27338 && $articulo['id']<27345)
	$descuento_pf =0.807;

	$precio = $articulo['precio_publico']*$descuento_pf;
	if ($coef !=1)	$precio = $precio*$coef;
	$precio_con_dcto = $precio *1.21* $coef_pyf;
	if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420) 				
	{
		$precio_con_dcto = $precio_con_dcto *$articulo['tf_coef'];
		
	}
	echo '$ '.number_format($precio_con_dcto,2,',','.'); 
	*/
	} 

?>