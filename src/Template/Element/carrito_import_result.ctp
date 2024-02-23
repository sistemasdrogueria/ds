<div class="articulos index large-10 medium-9 columns">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>	
<th rowspan="2">Cant.</th>
<th rowspan="2">Pack</th>
<th rowspan="2"><?= $this->Paginator->sort('stock') ?></th>

<th rowspan="2"><?= $this->Paginator->sort('descripcion_pag','Descripción') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('precio_publico','P.Publico') ?></th>
<!-- th rowspan="2"><?php // $this->Paginator->sort('precio_publico','P.Farmacia *') ?></th -->
<th rowspan="2"><?= $this->Paginator->sort('precio_publico','P.C/ Dto') ?></th>
<th rowspan="2">Dto</th>
<th colspan="3" align="center"><?= h('Ofertas') ?></th>
<th rowspan="2">Ref.</th>
<th rowspan="2"></th>
</tr>
<tr>

<th><div id="th-sub-tabla">U.Min</div></th>
<th><div id="th-sub-tabla">Plazo</div></th>
<th><div id="th-sub-tabla">Tipo Of.</div></th>
</tr>
</thead>
<tbody>
<div id="flotante"></div>
<?php $indice=0; $cat = $categorias; $lab = $laboratorios; 
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');
$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));

$condiciongeneralcf = 100*(1-($descuento_pf *1.0248* (1-$condicion/100)));

$condiciongeneralaz = 100*(1-($descuento_pf *0.892));

$indice=0;
$cat = $categorias;
$lab = $laboratorios; 

?>
<?= $this->Form->create('CarritosTemps',['url'=>['controller'=>'Carritos','action'=>'carritotempaddall'],'id'=>'formaddcart','onsubmit'=>'return validaragregar()']); ?>
<?php 	
foreach ($articulos as $articulo):
$indice+=1;
$encabezado = $indice.'.';
?>
<tr>
<?php
if (count($articulo['carritos_temps'])>1)
{
foreach ($articulo['carritos_temps'] as $carrito_temp): 
if ($carrito_temp['cliente_id']=$this->request->session()->read('Auth.User.cliente_id'))
{
$cantidad_unidades=intval($carrito_temp['cantidad']);
$descuent = $carrito_temp['descuento'];
echo $this->Form->input($encabezado.'carrito_temp_id',['type'=>'hidden','value'=> $carrito_temp['id']]);
}
endforeach; 
}
else
{
$descuent = $articulo['carritos_temps'][0]['descuento'];
$cantidad_unidades=intval($articulo['carritos_temps'][0]['cantidad']);
echo $this->Form->input($encabezado.'carrito_temp_id',['type'=>'hidden','value'=> $articulo['carritos_temps'][0]['id']]);
}	
?>
<td class='formcartcanttd'>
<?php
echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'value' =>$cantidad_unidades ,'class'=>'formcartcante','onchange'=>'javascript:document.confirmInput.submit();','autocomplete'=>'off']);
echo $this->Form->input($encabezado.'articulo_id',['type'=>'hidden','value'=>$articulo['id']]);
echo $this->Form->input($encabezado.'precio_publico',['type'=>'hidden','value'=>$articulo['precio_publico']]);
echo $this->Form->input($encabezado.'categoria_id',['type'=>'hidden','value'=>$articulo['categoria_id']]);
echo $this->Form->input($encabezado.'descripcion',['type'=>'hidden','value'=>$articulo['descripcion_pag']]);
echo $this->Form->input($encabezado.'compra_max',['type'=>'hidden','value'=>$articulo['compra_max']]);
if ($descuent !=0){	
	
	if ($articulo['carritos_temps'][0]['tipo_oferta']!='TH')
	{
		echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$articulo['carritos_temps'][0]['descuento']]); 	
	}
	else
	{
		$descuento_off=$articulo['carritos_temps'][0]['descuento']+$condiciongeneral;
		echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$descuento_off]); 	
	}
	
	
//echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$articulo['carritos_temps'][0]['descuento']]); 	
echo $this->Form->input($encabezado.'descuento_id',['type'=>'hidden','value'=>$articulo['carritos_temps'][0]['descuento_id']]); 
echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>$articulo['carritos_temps'][0]['plazoley_dcto']]); 	
echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>$articulo['carritos_temps'][0]['unidad_minima']]); 	
echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>$articulo['carritos_temps'][0]['tipo_oferta']]); 
echo $this->Form->input($encabezado.'tipo_oferta_elegida',['type'=>'hidden','value'=>$articulo['carritos_temps'][0]['tipo_oferta_elegida']]); 
echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>$articulo['carritos_temps'][0]['tipo_oferta_elegida']]); 
}
else
{			
echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>0]); 	
echo $this->Form->input($encabezado.'descuento_id',['type'=>'hidden','value'=>0]); 
echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>'HABITUAL']); 	
echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>1]); 	
echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_oferta_elegida',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
}
?>
</td>
<td class='colstock'> 
<?php if ($articulo['venta_paq']>0)
	  if ($articulo['paq']>1)
		echo $articulo['paq'];
?>
</td>
<td class='colstock'><?php
switch ($articulo['stock']) {
case 'B':echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );break;
case 'F':echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);break;
case 'S':echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);break;
case 'R':echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);break;
case 'D':echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);break;
}	
?></td>
<td class='masinfoband'>
<div 
onmouseover="showdiv(event,'<?php 
echo str_replace('"', '', $articulo['descripcion_pag']).'</br>'; 
echo 'Laboratorio: '.$lab[$articulo['laboratorio_id']].'</br>';
echo 'Categoría: '.$cat[$articulo['categoria_id']].'</br>';
echo 'Troquel: '.$articulo['troquel'].'</br>';
echo 'EAN: '.$articulo['codigo_barras'].'</br>';
if ($articulo['descuentos'] !=null && $articulo['stock']!='F')
{
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
echo 'Oferta: '.$articulo['descuentos'][0]['dto_drogueria'].'% por '.$articulo['descuentos'][0]['uni_min'].'unidad(es)</br>';
echo 'Plazo: '. $articulo['descuentos'][0]['plazo'].'</br>';
echo 'Tipo de oferta: '. $articulo['descuentos'][0]['tipo_oferta'].'</br>';
}
else
if (count($articulo['descuentos'])>1)
{
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
echo 'Oferta: '.$articulo['descuentos'][1]['dto_drogueria'].'% por '.$articulo['descuentos'][1]['uni_min'].'unidad(es)</br>';
echo 'Plazo: '. $articulo['descuentos'][1]['plazo'].'</br>';
echo 'Tipo de oferta: '. $articulo['descuentos'][1]['tipo_oferta'].'</br>';
}
}
}
?>
','<?php echo $articulo['iva'];?>'
,'<?php echo $articulo['trazable'];?>'
,'<?php echo $articulo['cadena_frio'];?>'
,'<?php echo $articulo['categoria_id'];?>'
,'<?php echo $articulo['pack'];?>
');" onMouseOut='hiddenDiv()' 
style='display:table;'>
<?php 
echo $articulo['descripcion_pag']; 
if ($articulo['compra_min']>1)
{echo ' (Vta.Min. '.$articulo['compra_min'],')';}
if ($articulo['compra_multiplo']>1)
{echo ' (Multiplo. '.$articulo['compra_multiplo'],')';}
if ($articulo['fv_cerca']==1) { echo $this->Html->image('fv.png',['title' => 'Vencimiento Cercano']);	}
if ($articulo['pack'] !=null)
echo ' <font color="red">PACK</font>';
if ($articulo['descuentos']!=null){ 
if ($articulo['descuentos'][0]['tipo_venta']=='D' and $articulo['stock']!='F')
{
echo ' '.$this->Html->image('oferta.png',['title' => 'Oferta']);
}	
else
{	
if (count($articulo['descuentos'])>1)
{
if ($articulo['descuentos'][1]['tipo_venta']=='D' and $articulo['stock']!='F')
echo ' '.$this->Html->image('oferta.png',['title' => 'Oferta']);
}
}
}
?>	
</div>				
</td>
<td class='colprecio'>
<?php echo $this->element('precio_publico',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf] );?>
</td>
<!-- td class='colprecio'>
<?php //echo $this->element('precio_farmacia',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef] );?>
</td -->
<td class='colprecio'>
<?php echo $this->element('precio_con_descuento',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef,'condiciongeneral'=>$condiciongeneral] );?>
</td>

<td class="td-sub-tabla" style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<?php 
if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
if ($articulo['descuentos'][0]['tipo_venta']=='D' )	
if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
else {
//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral.'% '.'</font>'; 
echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
}	

//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')	
if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
else {
//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral.'% '.'</font>'; 
echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][1]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
}	

//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
else
{
	if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)
	{
		if ($articulo['msd']==0)
		{
		if ($articulo['cadena_frio']==0 )
		{
			if ($articulo['laboratorio_id']==15) 
				echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
			else
			{
				if ($articulo['mcdp']==0)
				echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
				else
				echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

			}
				
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
			if ($articulo['laboratorio_id']==15) 
				echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
			else
			if ($articulo['mcdp']==0)
			echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
			else
			echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";
		}
	}
}
else
{
	if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)
	{
		if ($articulo['msd']==0)
		{
		if ($articulo['cadena_frio']==0 )
		{
			if ($articulo['laboratorio_id']==15) 
				echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
			else
			{
				if ($articulo['mcdp']==0)
				echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
				else
				echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

			}
				
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
			if ($articulo['laboratorio_id']==15) 
				echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
			else
			if ($articulo['mcdp']==0)
			echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
			else
			echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";
		}
	}

}
}	
else
{
	if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)
	{
		if ($articulo['msd']==0)
		{
		if ($articulo['cadena_frio']==0 )
		{
			if ($articulo['laboratorio_id']==15) 
				echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
			else
			{
				if ($articulo['mcdp']==0)
				echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
				else
				echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

			}
				
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
			if ($articulo['laboratorio_id']==15) 
				echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
			else
			if ($articulo['mcdp']==0)
			echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
			else
			echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";
		}
	}
}
?>
</td>
<td class="td-sub-tabla">
<?php 
if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
if ($articulo['descuentos'][0]['tipo_venta']=='D')
echo $articulo['descuentos'][0]['uni_min'];
else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')
echo $articulo['descuentos'][1]['uni_min'];
}
?>
</td>
<td class="td-sub-tabla">
<?php 
if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
if ($articulo['descuentos'][0]['tipo_venta']=='D')
echo $articulo['descuentos'][0]['plazo'];
else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')
echo $articulo['descuentos'][1]['plazo'];
}
?>
</td>
<td class="td-sub-tabla">
<?php 
if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
echo $articulo['descuentos'][0]['tipo_oferta'];
}
else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
echo $articulo['descuentos'][1]['tipo_oferta'];
}
}
?>
</td>
<td class='coliva'>
<?php 
if ($articulo['iva']==1) { echo $this->Html->image('iva.png',['title' => 'IVA']); }
if ($articulo['trazable']==1) { echo $this->Html->image('trazable.png',['title' => 'Trazable']); } 
if ($articulo['cadena_frio']==1) { echo $this->Html->image('cadenafrio.png',['title' => 'cadena de frio']); }
if ($articulo['categoria_id']==7) { echo $this->Html->image('valeoficial.png',['title' => 'Vale Oficial']); }
if ($articulo['categoria_id']==6) { echo $this->Html->image('psi.png',['title' => 'Psicotropicos']); }
if ($articulo['pack']==1) { echo $this->Html->image('pack.png',['title' => 'Pack']); }
if ($articulo['nuevo']==1){ echo $this->Html->image('nuevo.png',['title' => 'Producto Nuevo']);	}
if ($articulo['msd']==1 and $articulo['categoria_id']=1){ echo $this->Html->image('msd.png',['title' => 'Medicamento Sin descuento']);	}
?>
</td> 
<td class="actions">
<?php
$articulo_id= $articulo['carritos_temps'][0]['id'];
echo $this->Html->link($this->Html->image("delete_ico.png", ["alt" => "Quitar del carro"]),"/carritos/delete_temp/".$articulo_id,['escape' => false]);
?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="paginatorimport">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?php echo $totalitemstemp.' Items'; ?> </span></div>
<div class="pagination_count"><span><?php echo $totalunidadestemp.' Unid.'; ?> </span></div>
<div class="pagination_count"><span><?php echo 'Total $ '.number_format($totalcarritotemp,2,',','.'); ?> </span></div>
</ul>

<div class="importconfirm3">	
<div class="button-holder3">

<?=
$this->Html->link(
'Confirmar',
['controller' => 'Carritos', 'action' => 'importconfirm'],
['confirm' => 'Esta importar los articulos en esta lista']
)
?>
</div>
<div class="button-holder6">
<?=
$this->Html->link('Vaciar',['controller' => 'Carritos', 'action' => 'vaciarimport'],['confirm' => 'Esta seguro de vaciar esta lista de articulos importados'])
?>
</div>
<div class="button-holder3">
<?php echo $this->Form->submit('Modificar Seleccionados',['class'=>'btn_agregarvarios']);?>	
</div>	
</div>	
<?= $this->Form->end() ?>	
<p>* Precio con la condición del cliente incluido</p>
</div>

</div>
<script type="text/javascript">
$("tr").not(':first').hover(
function () {
$(this).css("background","#8FA800");
$(this).css("color","#000");
$(this).css("font-weight","");
}, 
function () {
$(this).css("background","");
$(this).css("color","#464646");
$(this).css("font-weight","");
}
);
/** Funcion que muestra el div en la posicion del mouse*/
function showdiv(event,text,iva,traza,frio,categ,pack)
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
document.getElementById('flotante').innerHTML=text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg;
// Posicionamos la capa flotante
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
</script>