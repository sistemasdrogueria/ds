<?php if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
if ($articulo['descuentos'][0]['tipo_venta']=='D' )	
{
	if ($articulo['descuentos'][0]['tipo_oferta']=='TH')

	echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
	
if ($articulo['descuentos'][0]['dto_drogueria'] == $articulo['carritos'][0]['descuento'])
{
if ($articulo['descuentos'][0]['tipo_precio']=='P')
	if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
	echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
	else {
	echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
	}		
else
{
	if ($articulo['iva']==0)
	{$condiciongeneralfinal = 100*(1-($descuento_pf * (1-$condicion/100)*(1-$articulo['descuentos'][0]['dto_drogueria']/100)));
	echo ' <font color="red" style="font-weight: bold;">';
	echo number_format(round($condiciongeneralfinal, 3),2,',','.'). '% </font>'; }
	else
	echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 

}

}
else
{
	if (count($articulo['descuentos'])>1)
	{ 

	if ($articulo['descuentos'][1]['tipo_precio']=='P')
	if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
	echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
	else {
	echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
	}		
	else
	{
	if ($articulo['iva']==0)
	{$condiciongeneralfinal = 100*(1-($descuento_pf * (1-$condicion/100)*(1-$articulo['descuentos'][1]['dto_drogueria']/100)));
	echo ' <font color="red" style="font-weight: bold;">';
	echo number_format(round($condiciongeneralfinal, 3),2,',','.'). '% </font>'; }
	else
	echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 

	}
	}
}

}
else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')	
if ($articulo['descuentos'][1]['tipo_precio']=='P')
		if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
		echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
		else {
		echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria']+$condiciongeneral.'% '.'</font>'; 
		}	
	else
	{
		if ($articulo['iva']==0)
		{$condiciongeneralfinal = 100*(1-($descuento_pf * (1-$condicion/100)*(1-$articulo['descuentos'][1]['dto_drogueria']/100)));
		echo ' <font color="red" style="font-weight: bold;">';
		echo number_format(round($condiciongeneralfinal, 3),2,',','.'). '% </font>'; }
		else
		echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 

	}


else
{
  if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)

	if ($articulo['msd']==0)
		{
		if ($articulo['cadena_frio']==0 )
		{
	
			if ($articulo['mcdp']==0)
			echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
			else
			echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

		}
		
		else
		if  ($articulo['subcategoria_id']<10)
			echo number_format(round($condiciongeneralcf, 3),2,',','.'). "% ";
			else
			if ($articulo['mcdp']==0)
			echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
			else
			echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

		}
		else
		{
			echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";
		}
}
else
{
	if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)

	if ($articulo['msd']==0)
	{
	if ($articulo['cadena_frio']==0 )
	{
		/*if ($articulo['laboratorio_id']==15) 
			echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
		else*/
		if ($articulo['mcdp']==0)
		echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
		else
		echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

	}
	
	else
	if  ($articulo['subcategoria_id']<10)
		echo number_format(round($condiciongeneralcf, 3),2,',','.'). "% ";
		else
		if ($articulo['mcdp']==0)
		echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
		else
		echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

	}
	else
	{
		/*if ($articulo['laboratorio_id']==15) 
			echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
		else*/
			echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";
	}
}
}	
else
{
  if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)

  if ($articulo['msd']==0)
  {
  if ($articulo['cadena_frio']==0 )
  {
	  /*if ($articulo['laboratorio_id']==15) 
		  echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
	  else*/
	  if ($articulo['mcdp']==0)
	  echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
	  else
	  echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

  }
  
  else
  if  ($articulo['subcategoria_id']<10)
	  echo number_format(round($condiciongeneralcf, 3),2,',','.'). "% ";
	  else
	  if ($articulo['mcdp']==0)
	  echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
	  else
	  echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

  }
  else
  {
	  /*if ($articulo['laboratorio_id']==15) 
		  echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
	  else*/
		  echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";
  }
}
?>