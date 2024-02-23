<?php 
if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
if ($articulo['descuentos'][0]['tipo_oferta']=='TH')
{
echo 'TD';
}	
if ($articulo['descuentos'][0]['dto_drogueria'] == $articulo['carritos'][0]['descuento'])
{
if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
{
echo $articulo['descuentos'][0]['tipo_oferta'];
}
else
{
echo 'TD';
}	
}
else
{
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
{
echo $articulo['descuentos'][1]['tipo_oferta'];
}
else
{
echo 'TD';
}


}

}
}
else
{

if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
{
echo $articulo['descuentos'][1]['tipo_oferta'];
}
else
{
echo 'TD';
}

}
}
}
?>