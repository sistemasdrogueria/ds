<div class="resultpatmed"  >
<div id="flotante"></div>
<?php $indice=0; 
$cat = $categorias; $titulolab=0; $preciot=""; 
if (!empty($articulos))
	$articulos2 = $articulos->toArray();
else
	$articulos2=null;
?>
<?= $this->Form->create('Transfers',['url'=>['controller'=>'Transfers','action'=>'carritoaddall'],'id'=>'formaddcart','onsubmit'=>'return validaragregar()']); ?>
<div class ="col-md-x" >
<table class='tablasearch' cellpadding="0" cellspacing="0">
<tbody>
<?php 
$cliente = $this->request->session()->read('cliente');
$descuento_pf = $cliente->preciofarmacia_descuento;
$condicion = $cliente->condicion_descuento ;
$coef = $cliente->coeficiente;
$max2 = sizeof($articulos2);
$max = $max2/2;
$max1= round($max, 0, PHP_ROUND_HALF_DOWN);
$first =0;
$unidades=0;
$subtotal =0;
for($i = 0; $i < $max1;$i++)
{
	$articulo =  $articulos2[$i];
	if ($articulo['preventas'][0]['combo']!= $titulolab || $first ==0 )
		{
		
		if ( $articulo['preventas'][0]['combo']!= $titulolab && $first !=0)
		{
			echo '<tr><td class="formcartcanttd">'.$unidades .' </td><td colspan="2"></td><td colspan="4" style =" text-align: center; background: #fff";></td></tr>';
			$subtotal =0;
			//echo 'UNIDADES :'.$unidades;
			$unidades = 0;
		}
		if ($first !=0)
		{
			echo '<tr><td colspan="7" style =" text-align: center; background: #fff";></td></tr>';
		
		}
		$first =1;
		$titulolab = $articulo['preventas'][0]['combo'];
		$preciot= $articulo['preventas'][0]['tipo_precio'];
	
		echo '<tr><td colspan="7" align="center" style =" text-align: center; background: #ebebeb; font-weight: bold;">'.$articulo['preventas'][0]['combo'].'  </td></tr>';
		echo '<tr><th>Cant.</th><th>Dcto.</th><th>Descripción</th><th>P.F.</th><th>P.C/ D.</th><th>Plazo</th><th>U.M.</th></tr>';
		$unidades=0;
		}
?>
<tr>
<td class='formcartcanttd' >
<?php
$encabezado = $indice.'.';	$indice=$i+1;
if (!empty($articulo['carritos_preventas']))
{
	$cantidadencarrito = $articulo['carritos_preventas'][0]['cantidad'];
	$unidades += $cantidadencarrito;
	$subtotal =0;
	echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'value' =>$cantidadencarrito ,'class'=>'formcartcant','target'=>'_blank','onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;','autocomplete'=>'off', 'style'=>'padding: 1px 1px; width:35px;']);
}
else	
{
	echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'class'=>'formcartcant','target'=>'_blank',  'onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;', 'autocomplete'=>'off' , 'style'=>'padding: 1px 1px; width:35px;']);
}
echo $this->Form->input($encabezado.'articulo_id',['type'=>'hidden','value'=>$articulo['id']]);
echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>$articulo['preventas'][0]['plazo']]); 	
echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>$articulo['preventas'][0]['uni_min']]); 	
echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>$articulo['preventas'][0]['tipo_oferta']]); 
echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>$articulo['preventas'][0]['tipo_venta']]); 
echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>$articulo['preventas'][0]['tipo_precio']]); 
?>
</td>
<td class='formcartcanttd' >
<?php 
if (!empty($articulo['carritos_preventas']) )
$descuentoencarrito = $articulo['carritos_preventas'][0]['descuento'];

else
$descuentoencarrito =$articulo['preventas'][0]['dto_drogueria'];

echo $this->Form->input($encabezado.'descuento',['class'=>'formcartcant','value'=>$descuentoencarrito,'style'=>'padding: 1px 1px; width:35px;' ]); 	?>
</td>
<td class='masinfoband'>
<div onmouseover="showdiv(event,'<?php 
echo str_replace('"', '', $articulo['descripcion_pag']).'</br>'; 
echo 'Laboratorio: '.$articulo['laboratorio']['nombre'].'</br>';
echo 'Categoría: '.$cat[$articulo['categoria_id']].'</br>';
echo 'Troquel: '.$articulo['troquel'].'</br>';
echo 'EAN: '.$articulo['codigo_barras'].'</br>';
?>','<?php echo $articulo['iva'];?>','<?php echo $articulo['trazable'];?>','<?php echo $articulo['cadena_frio'];?>'
,'<?php echo $articulo['categoria_id'];?>','<?php echo $articulo['pack'];?>','<?php echo $articulo['fv_cerca'];?>'
,'<?php echo $articulo['fv'];?>','<?php echo $articulo['imagen'];?>');" onMouseOut='hiddenDiv()' style='display:table;'>
<?php 
echo $articulo['descripcion_pag']; 
if ($articulo['pack'] !=null){ echo ' <font color="red" >PACK</font>';}
?>	
</div>				
</td>
<td class='colprecio' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">

<div style= "text-decoration:line-through; color:#999">
<?php echo $this->element('precio_es_farmacia',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef] );?></br>
</div>
</td>
<td class='colprecio' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<div style="font-weight: bold;">
<?php echo $this->element('precio_es_condescuento',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef] );?>
</div>
</td>
<!-- td class="td-sub-tabla">
<?php 
// echo ' <font color="red" style="font-weight: bold;">'.$articulo['preventas'][0]['dto_drogueria'].'% '.'</font>'; 

?>
</td-->
<td class="td-sub-tabla">
<?php echo $articulo['preventas'][0]['plazo'];?>
</td>
<td class="td-sub-tabla">
<?php echo $articulo['preventas'][0]['uni_min'];?>
</td>
</tr>		
<?php }	?>
</tbody>
</table>
</div>
<div class ="col-md-x">
<table class='tablasearch' cellpadding="0" cellspacing="0">	
<tbody>
<?php 
/*$max2 = sizeof($articulos2);
$max = $max2/2;*/
$first =0;
$indicej=$max1;
for($j = $max1; $j < $max2; $j++)
{
$articuloj =  $articulos2[$j];
if ($articuloj['preventas'][0]['combo']!= $titulolab || $first ==0 )
{

if ( $articuloj['preventas'][0]['combo']!= $titulolab)
{
	echo '<tr><td class="formcartcanttd">'.$unidades .' </td><td colspan="6" style =" text-align: center; background: #fff";></td></tr>';
	//echo 'UNIDADES :'.$unidades;
	$unidades = 0;
}
if ($first !=0)
{
	echo '<tr><td colspan="7" style =" text-align: center; background: #fff";></td></tr>';
}
	

$first =1;
$titulolab = $articuloj['preventas'][0]['combo'];
$preciot= $articuloj['preventas'][0]['tipo_precio'];
echo '<tr><th colspan="7" align="center" style =" text-align: center; background: #ebebeb; font-weight: bold;">'.$articuloj['preventas'][0]['combo'].'</th></tr>';
echo '<tr><th>Cant.</th><th>Dto.</th><th>Descripción</th><th>P.F.</th><th>P.C/ D.</th><th>Plazo</th><th>U.M.</th></tr>';
}

?>

<tr>
<td class='formcartcanttd' >
<?php
//$encabezado = $indice.'.';	$indice=$i;
$encabezadoj = $indicej.'.';	$indicej=$j + 1 ;

if (!empty($articuloj['carritos_preventas']) )
	{$cantidadencarrito = $articuloj['carritos_preventas'][0]['cantidad'];
		$unidades += $cantidadencarrito;
	}
else
	$cantidadencarrito ="";
echo $this->Form->input($encabezadoj.'cantidad',['tabindex'=>$indicej,'value' =>$cantidadencarrito ,'class'=>'formcartcant','target'=>'_blank','onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;','autocomplete'=>'off', 'style'=>'padding: 1px 1px; width:35px;']);

		
echo $this->Form->input($encabezadoj.'articulo_id',['type'=>'hidden','value'=>$articuloj['id']]);
//echo $this->Form->input($encabezadoj.'descuento',['type'=>'hidden','value'=>$articuloj['preventas'][0]['dto_drogueria']]); 	
echo $this->Form->input($encabezadoj.'plazoley_dcto',['type'=>'hidden','value'=>$articuloj['preventas'][0]['plazo']]); 	
echo $this->Form->input($encabezadoj.'unidad_minima',['type'=>'hidden','value'=>$articuloj['preventas'][0]['uni_min']]); 	
echo $this->Form->input($encabezadoj.'tipo_oferta',['type'=>'hidden','value'=>$articuloj['preventas'][0]['tipo_oferta']]); 
echo $this->Form->input($encabezadoj.'tipo_venta',['type'=>'hidden','value'=>$articuloj['preventas'][0]['tipo_venta']]); 
echo $this->Form->input($encabezadoj.'tipo_precio',['type'=>'hidden','value'=>$articuloj['preventas'][0]['tipo_precio']]); 

?>
</td>
<td class='formcartcanttd' >
<?php 
if (!empty($articuloj['carritos_preventas']) )
$descuentoencarrito = $articuloj['carritos_preventas'][0]['descuento'];
else
$descuentoencarrito = $articuloj['preventas'][0]['dto_drogueria'];
echo $this->Form->input($encabezadoj.'descuento',['value'=>$descuentoencarrito,'style'=>'padding: 1px 1px; width:35px;']); 	?>
</td>
<td class='masinfoband'>
<div onmouseover="showdiv(event,'<?php 
echo str_replace('"', '', $articuloj['descripcion_pag']).'</br>'; 
echo 'Laboratorio: '.$articuloj['laboratorio']['nombre'].'</br>';
echo 'Categoría: '.$cat[$articuloj['categoria_id']].'</br>';
echo 'Troquel: '.$articuloj['troquel'].'</br>';
echo 'EAN: '.$articuloj['codigo_barras'].'</br>';
?>','<?php echo $articuloj['iva'];?>','<?php echo $articuloj['trazable'];?>','<?php echo $articuloj['cadena_frio'];?>'
,'<?php echo $articuloj['categoria_id'];?>','<?php echo $articuloj['pack'];?>','<?php echo $articuloj['fv_cerca'];?>'
,'<?php echo $articuloj['fv'];?>','<?php echo $articuloj['imagen'];?>');" onMouseOut='hiddenDiv()' style='display:table;'>
<?php 
echo $articuloj['descripcion_pag']; 
if ($articuloj['pack'] !=null){ echo ' <font color="red" >PACK</font>';}
?>	
</div>				
</td>
<td class='colprecio' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<div style= "text-decoration:line-through; color:#999">
<?php echo $this->element('precio_es_farmacia',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef] );?></br>
</div>
</td>
<td class='colprecio' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<div style="font-weight: bold;">
<?php echo $this->element('precio_es_condescuento',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef] );?>
</div>
</td>
<!--td class="td-sub-tabla">
<?php //echo ' <font color="red" style="font-weight: bold;">'.$articuloj['preventas'][0]['dto_drogueria'].'% '.'</font>'; ?>
</td -->
<td class="td-sub-tabla">
<?php echo $articuloj['preventas'][0]['plazo'];?>
</td>
<td class="td-sub-tabla">
<?php echo $articuloj['preventas'][0]['uni_min'];?>
</td>
</tr>
<?php	}	?>
</tbody>
</table>
</div>
<div class ="col-md-12">
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >') ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>
<div class="importconfirm2">	
<div class="button-holder5">
<?php echo $this->Form->submit('Agregar Seleccionados',['class'=>'btn_agregarvarios']);?>	
</div>	
</div>	
<?= $this->Form->end() ?>	
</div>
</div>
</div>
<script type="text/javascript">
/** Funcion que muestra el div en la posicion del mouse */
function showdiv(event,text,iva,traza,frio,categ,pack,fv_cerca,fv,ean)
{	
//determina un margen de pixels del div al raton
margin=0;
//La variable IE determina si estamos utilizando IE
var IE = document.all?true:false;
var tempX = 0;
var tempY = 0;
//document.body.clientHeight = devuelve la altura del body
if(IE)
{ //para IE
IE6=navigator.userAgent.toLowerCase().indexOf('msie 6');
IE7=navigator.userAgent.toLowerCase().indexOf('msie 7');
if(IE6>0 || IE7>0)
{
tempX = event.x
tempY = event.y
if(window.pageYOffset){
tempY=(tempY+window.pageYOffset);
tempX=(tempX+window.pageXOffset);
}else{
tempY=(tempY+Math.max(document.body.scrollTop,document.documentElement.scrollTop));
tempX=(tempX+Math.max(document.body.scrollLeft,document.documentElement.scrollLeft));
}
}else{
//IE8
tempX = event.x
tempY = event.y
}
}else{ //para netscape
//window.pageYOffset = devuelve el tamaño en pixels de la parte superior no visible (scroll) de la pagina
//document.captureEvents(Event);
tempX = event.pageX;
tempY = event.pageY;
}
if (tempX < 0){tempX = 0;}
if (tempY < 0){tempY = 0;}
// Modificamos el contenido de la capa  
var trazaimg='';
var cadenaimg='';
var psiimg='';
var valeoficialimg='';
var ivaimg='';
var fvimg='';
var fvcerca ='';
if (iva==1)
{
ivaimg = '<?php echo $this->Html->image('iva.png',['title' => 'IVA']);?>';
}
if (traza==1)
{
trazaimg = '<?php echo $this->Html->image('trazable.png',['title' => 'Trazable']);?>';
}
if (frio==1)
{
cadenaimg = '<?php echo $this->Html->image('cadenafrio.png',['title' => 'Cadena de Frio']);?>';
}
if (categ==7)
{
valeoficialimg = '<?php echo $this->Html->image('valeoficial.png',['title' => 'Vale Oficial']);?>';
}	 
if (categ==6)
{
psiimg = '<?php echo $this->Html->image('psi.png',['title' => 'Psicotropicos']);?>';
}	 
if (pack==1) 
{
psiimg = '<?php echo $this->Html->image('pack.png',['title' => 'Pack']);?>';
}	
if (fv_cerca==1) 
{ 
fvimg = '<?php echo $this->Html->image('fv.png',['title' => 'Vencimiento Cercano']);?>';
fvcerca= 'Vencimiento: ';
fvcerca= fvcerca.concat(fv);			 
}	
eanimg ='<img src="http://www.drogueriasur.com.ar/ds/webroot/img/productos/'+ean+'" alt="'+ean+'" width="200px">';
//document.getElementById('flotante').innerHTML=text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg+fvimg+fvcerca;
// Posicionamos la capa flotante
document.getElementById('flotante').innerHTML="<div id='flotante_text'>"+text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg+fvimg+fvcerca+"</div><div id='flotante_img' >"+eanimg+"</div>";
document.getElementById('flotante').style.top = (tempY-120)+"px";
document.getElementById('flotante').style.left = (tempX-10)+"px";
document.getElementById('flotante').style.display='block';
return;
}
/**
* Funcion para esconder el div
*/
function hiddenDiv()
{
document.getElementById('flotante').style.display='none';
}
function myFunction() {
/*document.confirmInput.submit();*/
document.getElementById("formaddcart").submit();
}
</script>