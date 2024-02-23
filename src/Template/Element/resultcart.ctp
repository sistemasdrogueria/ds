<div class="articulos index large-10 medium-9 columns">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>	
<th rowspan="2">Cant.</th>
<th rowspan="2">Stock</th>
<th rowspan="2"><?= $this->Paginator->sort('troquel','troquel') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('descripcion_pag','Descripción') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('precio_publico','P.Pub.') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('precio_farmacia','P.Farm.') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('precio_publico','P.c/ Dto') ?></th>
<th colspan="4" align="center">Ofertas</th>
<th rowspan="2">SubTotal</th>
<th rowspan="2"></th>
</tr>
<tr>
<th><div id="th-sub-tabla">Dto</div></td>
<th><div id="th-sub-tabla">U.Min</div></td>
<th><div id="th-sub-tabla">Plazo</div></td>
<th><div id="th-sub-tabla">Tipo Of.</div></td>
</tr>
</thead>
<tbody>
<div id="flotante"></div>
<?php $indice=0;
$cat = $categorias;
$lab = $laboratorios; 
$descuento_pf =$this->request->session()->read('Auth.User.pf_dcto');
?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddall'],'id'=>'formaddcart','onsubmit'=>'return validaragregar()']); ?>
<?php foreach ($articulos as $articulo): ?>
<tr>
<?php $indice+=1;
$encabezado = $indice.'.';$indice+=1;
?>
<td class='formcartcanttd'>
<?php
if ($articulo['carritos'] !=null )
{
$cantidadencarrito = $articulo['carritos'][0]['cantidad'];
echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'value' =>$cantidadencarrito ,'class'=>'formcartcant','target'=>'_blank','onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;','autocomplete'=>'off']);
}
else 
echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'class'=>'formcartcant','target'=>'_blank',  'onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;', 'autocomplete'=>'off']);
	
echo $this->Form->input($encabezado.'cliente_id',['type'=>'hidden','value'=>$this->request->session()->read('Auth.User.cliente_id')]);
echo $this->Form->input($encabezado.'articulo_id',['type'=>'hidden','value'=>$articulo['id']]);
echo $this->Form->input($encabezado.'categoria_id',['type'=>'hidden','value'=>$articulo['categoria_id']]);	
echo $this->Form->input($encabezado.'precio_publico',['type'=>'hidden','value'=>$articulo['precio_publico']]);
echo $this->Form->input($encabezado.'descripcion',['type'=>'hidden','value'=>$articulo['descripcion_pag']]);
if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){	
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$articulo['descuentos'][0]['dto_drogueria']]); 	
echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>$articulo['descuentos'][0]['plazo']]); 	
echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>$articulo['descuentos'][0]['uni_min']]); 	
echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_oferta']]); 
echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_venta']]); 
echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_precio']]); 
}
else
{
if (count($articulo['descuentos'])>1)
{
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$articulo['descuentos'][1]['dto_drogueria']]); 	
echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>$articulo['descuentos'][1]['plazo']]); 	
echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>$articulo['descuentos'][1]['uni_min']]); 	
echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>$articulo['descuentos'][1]['tipo_oferta']]); 
echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>$articulo['descuentos'][1]['tipo_venta']]); 
echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>$articulo['descuentos'][1]['tipo_precio']]); 
}
else
{
echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
}
}
else
{
echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
}
}
}
else
{			
echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
}
?>
</td>
<td class='colstock'><?php
switch ($articulo['stock']) {
case 'B':echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );break;
case 'F':echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);break;
case 'S':echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);break;
case 'R':echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);break;
case 'D':echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);break;
}?></td>
<td> <?php echo $articulo['troquel'];?></td>
<td class='masinfoband'>
<div onmouseover="showdiv(event,'<?php 
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
','<?php echo $articulo['iva'];?>','<?php echo $articulo['trazable'];?>','<?php echo $articulo['cadena_frio'];?>'
,'<?php echo $articulo['categoria_id'];?>','<?php echo $articulo['pack'];?>','<?php echo $articulo['fv_cerca'];?>'
,'<?php echo $articulo['fv'];?>')" onMouseOut='hiddenDiv()' 
style='display:table;'>
<?php 
echo $articulo['descripcion_pag']; 
if ($articulo['fv_cerca']==1) { echo $this->Html->image('fv.png',['title' => 'Vencimiento Cercano']);	}
?>
<?php
if ($articulo['pack'] !=null){
echo ' <font color="red" >PACK</font>';
}
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
<?php 
if (($articulo['categoria_id'] !=6) && ($articulo['categoria_id'] !=5)  && ($articulo['categoria_id'] !=4))
{
if ($articulo['iva']==0)
echo '$ '.number_format($articulo['precio_publico'],2,',','.'); 
}
?>
</td>
<td class='colprecio'>
<?php 
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3))
{
if ($articulo['descuentos']!=null){ 
if ($articulo['descuentos'][0]['tipo_venta']=='D' && $articulo['descuentos'][0]['tipo_precio']=='F')
{
echo '$ '.number_format(round(h($articulo['precio_publico'])*$descuento_pf, 3),2,',','.'); 
}	
else
{	
if ($articulo['descuentos'][0]['tipo_venta']=='L')
{
echo '$ '.number_format(round(h($articulo['precio_publico'])*$descuento_pf, 3),2,',','.'); 
}
else
echo '$ '.number_format($articulo['precio_publico'],2,',','.'); 
}		
}
else
echo '$ '.number_format(round(h($articulo['precio_publico'])*$descuento_pf, 3),2,',','.'); 
}
else
{
$coef = $this->request->session()->read('Auth.User.coef');
$precio = $articulo['precio_publico']*$descuento_pf;
if ($coef >1)
$precio += $precio*$coef/100;
echo '$ '.number_format(round($precio, 3),2,',','.'); 
}
?>
</td>
<td class='colprecio'>
<?php 
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3) &&($articulo['categoria_id'] !=2))
{
if ($articulo['descuentos']!=null){ 				
if ($articulo['descuentos'][0]['tipo_venta']=='L')
{
if ($articulo['msd']!=1)
{$condicion = $this->request->session()->read('Auth.User.condicion');
	
$coef = $this->request->session()->read('Auth.User.coef');
$precio = $articulo['precio_publico']*$descuento_pf;
if ($condicion >0 )
	$precio -= $precio*$condicion/100;
echo '$ '.number_format(round($precio, 3),2,',','.'); }
}
}
else
{
if ($articulo['msd']!=1)
{$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');
$precio = $articulo['precio_publico']*$descuento_pf;
if ($condicion >0 )
$precio -= $precio*$condicion/100;
echo '$ '.number_format(round($precio, 3),2,',','.'); }
}
}
else
{
}
?>
</td>
<td class="td-sub-tabla">
<?php 
if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
if ($articulo['descuentos'][0]['tipo_venta']=='D' )	
{
echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
}
else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')	
echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
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
<td class='colprecio'>
<?php 

if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3))
{
if ($articulo['categoria_id'] ===1)
$coef =1;
else
$coef = $this->request->session()->read('Auth.User.coef');

if ($articulo['laboratorio_id']==15)
$coef = 0.892; 
if ($articulo['descuentos']!=null){ 
if ($articulo['descuentos'][0]['tipo_venta']=='D' && $articulo['descuentos'][0]['tipo_precio']=='F')
{
echo '$ '.number_format(round(h($articulo['precio_publico'])*$descuento_pf*$coef*$cantidadencarrito, 3),2,',','.'); 
}	
else
{	
if ($articulo['descuentos'][0]['tipo_venta']=='L')
{
echo '$ '.number_format(round(h($articulo['precio_publico'])*$descuento_pf*$coef*$cantidadencarrito, 3),2,',','.'); 
}
else
echo '$ '.number_format($articulo['precio_publico']*$cantidadencarrito,2,',','.'); 
}				
}
else
echo '$ '.number_format(round(h($articulo['precio_publico'])*$descuento_pf*$coef*$cantidadencarrito, 3),2,',','.'); 
}
else
{
$coef = $this->request->session()->read('Auth.User.coef');
$precio = $articulo['precio_publico']*$descuento_pf*$cantidadencarrito;
if ($coef !=1)
$precio = $precio*$coef;
echo '$ '.number_format(round($precio, 3),2,',','.'); 
}
?>
</td>
<td class="actions">
<?php
$articulo_id= $articulo['carritos'][0]['id'];
	echo $this->Html->link(
$this->Html->image("delete_ico.png", ["alt" => "Quitar del carro"]),
"/carritos/delete/".$articulo_id,
['escape' => false]
);
?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<p>El IVA y las Ofertas se aplicaran en la factura.</p>	
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>
<div class="importconfirm2">	
<div class="button-holder5">
<?php echo $this->Form->submit('Modificar Seleccionados',['class'=>'btn_agregarvarios']);?>	
</div>	
</div>	
<?= $this->Form->end() ?>	
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
/**
* Funcion que muestra el div en la posicion del mouse
*/
function showdiv(event,text,iva,traza,frio,categ,pack,fv,fv_cerca)
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
}else{ 
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
var fvcerca='';
if (iva==1)
{ivaimg = '<?php echo $this->Html->image('iva.png',['title' => 'IVA']);?>';}
if (traza==1)
{trazaimg = '<?php echo $this->Html->image('trazable.png',['title' => 'Trazable']);?>';}
if (frio==1)
{cadenaimg = '<?php echo $this->Html->image('cadenafrio.png',['title' => 'Cadena de Frio']);?>';}
if (categ==7)
{valeoficialimg = '<?php echo $this->Html->image('valeoficial.png',['title' => 'Vale Oficial']);?>';}	 
if (categ==6)
{psiimg = '<?php echo $this->Html->image('psi.png',['title' => 'Psicotropicos']);?>';}	 
if (pack==1) 
{psiimg = '<?php echo $this->Html->image('pack.png',['title' => 'Pack']);?>';}	
if (fv_cerca==1) 
{fvimg = '<?php echo $this->Html->image('fv.png',['title' => 'Vencimiento Cercano']);?>';
fvcerca = 'Vencimiento: ';fvcerca = fvcerca.concat(fv);}				
document.getElementById('flotante').innerHTML=text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg+fvimg+fvcerca;
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
<script>
function myFunction() {
document.getElementById("formaddcart").submit();
}
</script>