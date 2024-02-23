<div class="articulos index large-10 medium-9 columns">
<table class='tablasearch' id="formaddcart" cellpadding="0" cellspacing="0">
<thead id="ubicacion">
<tr>
<th rowspan="2">Cant.</th>
<th rowspan="2"><?= $this->Paginator->sort('stock') ?></th>
<th rowspan="2"><a href="#thead">Descripción</a>
<th rowspan="2"><?= $this->Paginator->sort('precio_publico', 'P.Publico') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('precio_publico', 'P.C/ Dto') ?></th>
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
<tbody class="import">
<div id="flotante"></div>
<?php
$indice = 0;
$cat = $categorias;
$lab = $laboratorios;
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');
$coef_pyf =$this->request->session()->read('Auth.User.coef_pyf');

$condiciongeneral = 100 * (1 - ($descuento_pf * (1 - $condicion / 100)));
$condiciongeneralmsd = 100 * (1 - ($descuento_pf));
$condiciongeneralcf = 100 * (1 - ($descuento_pf * 1.0248 * (1 - $condicion / 100)));
$indice = 0;
$cat = $categorias;
$lab = $laboratorios;
?>

<?= $this->Form->create('CarritosTemps', ['url' => ['controller' => 'Carritos', 'action' => 'carritotempaddall'], 'id' => 'formaddcart', 'onsubmit' => 'return false;']); ?>
<?php
foreach ($articulos as $articulo) :
$indice += 1;
$encabezado = $indice . '.'; ?>
<tr id="trimport<?php echo $articulo['id']; ?>">
<?php
if (count($articulo['carritos_temps']) > 1) {
foreach ($articulo['carritos_temps'] as $carrito_temp) :
if ($carrito_temp['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id')) {
$cantidad_unidades = intval($carrito_temp['cantidad']);
$descuent = $carrito_temp['descuento_id'];
echo $this->Form->input($encabezado . 'carrito_temp_id', ['type' => 'hidden', 'value' => $carrito_temp['id']]);
}
endforeach;
} else {
$descuent = $articulo['carritos_temps'][0]['descuento_id'];
$cantidad_unidades = intval($articulo['carritos_temps'][0]['cantidad']);
echo $this->Form->input($encabezado . 'carrito_temp_id', ['type' => 'hidden', 'value' => $articulo['carritos_temps'][0]['id']]);
}
?>
<td class='formcartcanttd1' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<div class=formcartcanttd_div > 
<button class="btn btn-sm" onclick="decrementImport(<?php echo $articulo['id']; ?>,<?php echo $descuent ?>,<?php echo $articulo['id']; ?>,<?php echo $articulo['carritos_temps'][0]['id'] ?>,<?php echo $articulo['carritos_temps'][0]['unidad_minima'] ?>,<?php echo $articulo['carritos_temps'][0]['descuento'] ?>);" return="false;">-</button>
<?php echo $this->Form->input($encabezado . 'cantidad', ['tabindex' => $indice, 'value' => $cantidad_unidades, 'class' => 'formcartcante', 'data-valor' => 'ca' . $articulo['id'], 'data-id' => $articulo['id'], 'data-um' => $articulo['carritos_temps'][0]['unidad_minima'],'data-pv-id' => $descuent,'data-dscto' => $articulo['carritos_temps'][0]['descuento'], 'onsubmit'=>'return return false;' ,'autocomplete' => 'off']); ?>
<button class="btn btn-sm" onclick="incrementImport(<?php echo $articulo['id']; ?>,<?php echo $descuent ?>,<?php echo $articulo['id']; ?>,<?php echo $articulo['carritos_temps'][0]['unidad_minima'] ?>,<?php echo $articulo['carritos_temps'][0]['descuento'] ?>);">+</button>
</div>
</td>
<td class='colstock' style=" border: solid #fff; border-width: 0px 1px 0px 1px;"><?php
switch ($articulo['stock']) {
case 'B':
echo $this->Html->image('bajo.png', ['title' => 'Stock Bajo, Consultar Operadora']);
break;
case 'F':
echo $this->Html->image('falta.png', ['title' => 'Producto en Falta']);
break;
case 'S':
echo $this->Html->image('alto.png', ['title' => 'Stock Habitual']);
break;
case 'R':
echo $this->Html->image('restrin.png', ['title' => 'Producto sujeto a stock']);
break;
case 'D':
echo $this->Html->image('descont.png', ['title' => 'Producto Discontinuo']);
break;
}?>
</td>
<td class='masinfoband' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<div onmouseover="showdiv(event,'<?php
echo str_replace('"', '', $articulo['descripcion_pag']) . '</br>';
echo 'Laboratorio: ' . $lab[$articulo['laboratorio_id']] . '</br>';
echo 'Categoría: ' . $cat[$articulo['categoria_id']] . '</br>';
echo 'Troquel: ' . $articulo['troquel'] . '</br>';
echo 'EAN: ' . $articulo['codigo_barras'] . '</br>';
if ($articulo['descuentos'] != null && $articulo['stock'] != 'F') {
if ($articulo['descuentos'][0]['tipo_venta'] == 'D') {
echo 'Oferta: ' . $articulo['descuentos'][0]['dto_drogueria'] . '% por ' . $articulo['descuentos'][0]['uni_min'] . 'unidad(es)</br>';
echo 'Plazo: ' . $articulo['descuentos'][0]['plazo'] . '</br>';
echo 'Tipo de oferta: ' . $articulo['descuentos'][0]['tipo_oferta'] . '</br>';
} else
if (count($articulo['descuentos']) > 1) {
if ($articulo['descuentos'][1]['tipo_venta'] == 'D') {
echo 'Oferta: ' . $articulo['descuentos'][1]['dto_drogueria'] . '% por ' . $articulo['descuentos'][1]['uni_min'] . 'unidad(es)</br>';
echo 'Plazo: ' . $articulo['descuentos'][1]['plazo'] . '</br>';
echo 'Tipo de oferta: ' . $articulo['descuentos'][1]['tipo_oferta'] . '</br>';
}}}?>
','<?php echo $articulo['iva']; ?>','<?php echo $articulo['trazable']; ?>','<?php echo $articulo['cadena_frio']; ?>','<?php echo $articulo['categoria_id']; ?>'
,'<?php echo $articulo['pack']; ?>');" onMouseOut='hiddenDiv()' style='display:table;'>
<?php
echo $articulo['descripcion_pag']; if ($descuent!= 0){ if ($articulo['carritos_temps'][0]['cantidad'] < $articulo['carritos_temps'][0]['unidad_minima']) 
{ echo $this->Html->image('oferta_perdida.png',['class'=>'off_perdida1 imgoferta1'.$articulo['carritos_temps'][0]['articulo_id'].'']); }
else
{ echo $this->Html->image('oferta_adquirida.png',['class'=>'off_perdida1 imgoferta1'.$articulo['carritos_temps'][0]['articulo_id'].'']); }
}
if ($articulo['compra_min'] > 1) {
echo ' (Vta.Min. ' . $articulo['compra_min'], ')';
}
if ($articulo['compra_multiplo'] > 1) {
echo ' (Multiplo. ' . $articulo['compra_multiplo'], ')';
}
if ($articulo['fv_cerca'] == 1) {
echo $this->Html->image('fv.png', ['title' => 'Vencimiento Cercano']);
}
if ($articulo['pack'] != null)
echo ' <font color="red">PACK</font>';
if ($articulo['descuentos'] != null) {
if ($articulo['descuentos'][0]['tipo_venta'] == 'D' and $articulo['stock'] != 'F') {
} else {
if (count($articulo['descuentos']) > 1) {
}
}
}
?>
</div>
</td>
<td class='colprecio' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<?php echo $this->element('precio_publico', ['articulo' => $articulo, 'descuento_pf' => $descuento_pf, 'condicion' => $condicion, 'coef' => $coef,'coef_pyf'=>$coef_pyf]); ?>
</td>
<td class='colprecio' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<?php echo $this->element('precio_con_descuento', ['articulo' => $articulo, 'descuento_pf' => $descuento_pf, 'condicion' => $condicion, 'coef' => $coef, 'condiciongeneral' => $condiciongeneral]); ?>
</td>
<td class="td-sub-tabla" style=" border: solid #fff; border-width: 0px 1px 0px 1px;">

<?php 
if ($articulo['descuentos'] !=null && $articulo['stock']!='F')
{
if ($articulo['descuentos'][0]['tipo_venta']=='D' )	
//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
if ($articulo['descuentos'][0]['tipo_precio']=='P')
{
if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
else {
echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 

}	
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

else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')	
if (  $articulo['descuentos'][1]['tipo_precio']=='P')
if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
else {

echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][1]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
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

//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
else
{
if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)
//echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
//if ($articulo['categoria_id']==1 && $articulo['iva']==0)
{
if ($articulo['msd']==0)
{
if ($articulo['cadena_frio']==0 )
{
/*
if ($articulo['laboratorio_id']==15) 
echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
else
{*/
if ($articulo['mcdp']==0)
echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
else
echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";

//}

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
/*
if ($articulo['laboratorio_id']==15) 
echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
else*/
if ($articulo['mcdp']==0)
echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
else
echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";
}
}

}
else
{
if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)
//echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
//if ($articulo['categoria_id']==1 && $articulo['iva']==0)
{
if ($articulo['msd']==0)
{
if ($articulo['cadena_frio']==0 )
{
/*
if ($articulo['laboratorio_id']==15) 
echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
else */
if ($articulo['mcdp']==0)
echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
else
echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

}

else
if  ($articulo['subcategoria_id']<10 && $articulo['subcategoria_id']>=0)
echo number_format(round($condiciongeneralcf, 3),2,',','.'). "% ";
else
if ($articulo['mcdp']==0)
echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
else
echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";

}
else
{
/*
if ($articulo['laboratorio_id']==15) 
echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
else*/
echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";
}

}
}
}	
else
{
if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)
// echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
//if ($articulo['categoria_id']==1 && $articulo['iva']==0)
{
if ($articulo['msd']==0)
{
if ($articulo['cadena_frio']==0 )

{
/*
if ($articulo['laboratorio_id']==15) 
echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
else*/
if ($articulo['mcdp']==0)
echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
else
echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";
}

else
if  ($articulo['subcategoria_id']<10 && $articulo['subcategoria_id']>=0)
echo number_format(round($condiciongeneralcf, 3),2,',','.'). "% ";
else
if ($articulo['mcdp']==0)
echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
else
echo number_format(round($condiciongenera-1, 3),2,',','.'). "% ";
}
else
{
/*
if ($articulo['laboratorio_id']==15) 
echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
else*/
echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";
}

}
}
?>

</td>
<td class="td-sub-tabla" style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<?php
if ($articulo['descuentos'] != null and $articulo['stock'] != 'F') {
if ($articulo['descuentos'][0]['tipo_venta'] == 'D')
echo $articulo['descuentos'][0]['uni_min'];
else
if (count($articulo['descuentos']) > 1)
if ($articulo['descuentos'][1]['tipo_venta'] == 'D')
echo $articulo['descuentos'][1]['uni_min'];
}
?>
</td>
<td class="td-sub-tabla" style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<?php
if ($articulo['descuentos'] != null and $articulo['stock'] != 'F') {
if ($articulo['descuentos'][0]['tipo_venta'] == 'D')
echo $articulo['descuentos'][0]['plazo'];
else
if (count($articulo['descuentos']) > 1)
if ($articulo['descuentos'][1]['tipo_venta'] == 'D')
echo $articulo['descuentos'][1]['plazo'];
}
?>
</td>
<td class="td-sub-tabla" style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<?php
if ($articulo['descuentos'] != null and $articulo['stock'] != 'F') {
if ($articulo['descuentos'][0]['tipo_venta'] == 'D') {
echo $articulo['descuentos'][0]['tipo_oferta'];
} else
if (count($articulo['descuentos']) > 1)
if ($articulo['descuentos'][1]['tipo_venta'] == 'D') {
echo $articulo['descuentos'][1]['tipo_oferta'];
}
}
?>
</td>
<td class='coliva'>
<?php
if ($articulo['iva'] == 1) {
echo $this->Html->image('iva.png', ['title' => 'IVA']);
}
if ($articulo['trazable'] == 1) {
echo $this->Html->image('trazable.png', ['title' => 'Trazable']);
}
if ($articulo['cadena_frio'] == 1) {
echo $this->Html->image('cadenafrio.png', ['title' => 'cadena de frio']);
}
if ($articulo['categoria_id'] == 7) {
echo $this->Html->image('valeoficial.png', ['title' => 'Vale Oficial']);
}
if ($articulo['categoria_id'] == 6) {
echo $this->Html->image('psi.png', ['title' => 'Psicotropicos']);
}
if ($articulo['pack'] == 1) {
echo $this->Html->image('pack.png', ['title' => 'Pack']);
}
if ($articulo['nuevo'] == 1) {
echo $this->Html->image('nuevo.png', ['title' => 'Producto Nuevo']);
}
if ($articulo['msd'] == 1 and $articulo['categoria_id'] = 1) {
echo $this->Html->image('msd.png', ['title' => 'Medicamento Sin descuento']);
}
?>
</td>
<td class="actions" style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<a href="#" onclick="preguntarSiNoMenosImport(<?php echo $articulo['carritos_temps'][0]['id'] ?>,<?php echo $articulo['id']; ?>)"><?php echo  $this->Html->image("delete_ico.png", ["alt" => "Quitar del carro"]);?></a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="paginatorimport">
<!--ul class="pagination">
<!?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<div class="pagination_count"><span id="number"></span></div>
<!?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span id="totalitemss"><?php //echo $totalitemstemp.' Items'; 
?> </span></div>
<div class="pagination_count"><span id="totalunidadess"><?php //echo $totalunidadestemp.' Unid.'; 
?> </span></div>
<div class="pagination_count"><span id="totaltall"><?php //echo 'Total $ '.number_format($totalcarritotemp,2,',','.'); 
?> </span></div>
</ul-->
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
</div>
<?= $this->Form->end() ?>
</div>
</div>
<script type="text/javascript">
$("tr").not(':first').hover(
function() {
$(this).css("background", "#8FA800");
$(this).css("color", "#000");
$(this).css("font-weight", "");
},
function() {
$(this).css("background", "");
$(this).css("color", "#464646");
$(this).css("font-weight", "");
}
);
/** Funcion que muestra el div en la posicion del mouse*/
function showdiv(event, text, iva, traza, frio, categ, pack) {
//determina un margen de pixels del div al raton
margin = 0;
//La variable IE determina si estamos utilizando IE
var IE = document.all ? true : false;
var tempX = 0;
var tempY = 0;
//document.body.clientHeight = devuelve la altura del body
if (IE) { //para IE
IE6 = navigator.userAgent.toLowerCase().indexOf('msie 6');
IE7 = navigator.userAgent.toLowerCase().indexOf('msie 7');
if (IE6 > 0 || IE7 > 0) {
tempX = event.x
tempY = event.y
if (window.pageYOffset) {
tempY = (tempY + window.pageYOffset);
tempX = (tempX + window.pageXOffset);
} else {
tempY = (tempY + Math.max(document.body.scrollTop, document.documentElement.scrollTop));
tempX = (tempX + Math.max(document.body.scrollLeft, document.documentElement.scrollLeft));
}
} else {
//IE8
tempX = event.x
tempY = event.y
}
} else { //para netscape
//window.pageYOffset = devuelve el tamaño en pixels de la parte superior no visible (scroll) de la pagina
//document.captureEvents(Event);
tempX = event.pageX;
tempY = event.pageY;
}
if (tempX < 0) {
tempX = 0;
}
if (tempY < 0) {
tempY = 0;
}
// Modificamos el contenido de la capa  
var trazaimg = '';
var cadenaimg = '';
var psiimg = '';
var valeoficialimg = '';
var ivaimg = '';
if (iva == 1) {
ivaimg = '<?php echo $this->Html->image('iva.png', ['title' => 'IVA']); ?>';
}
if (traza == 1) {
trazaimg = '<?php echo $this->Html->image('trazable.png', ['title' => 'Trazable']); ?>';
}
if (frio == 1) {
cadenaimg = '<?php echo $this->Html->image('cadenafrio.png', ['title' => 'Cadena de Frio']); ?>';
}
if (categ == 7) {
valeoficialimg = '<?php echo $this->Html->image('valeoficial.png', ['title' => 'Vale Oficial']); ?>';
}
if (categ == 6) {
psiimg = '<?php echo $this->Html->image('psi.png', ['title' => 'Psicotropicos']); ?>';
}
if (pack == 1) {
psiimg = '<?php echo $this->Html->image('pack.png', ['title' => 'Pack']); ?>';
}
document.getElementById('flotante').innerHTML = text + ivaimg + trazaimg + cadenaimg + psiimg + valeoficialimg;
// Posicionamos la capa flotante
document.getElementById('flotante').style.top = (tempY - 120) + "px";
document.getElementById('flotante').style.left = (tempX - 10) + "px";
document.getElementById('flotante').style.display = 'block';
return;
}
/**
* Funcion para esconder el div
*/
function hiddenDiv() {
document.getElementById('flotante').style.display = 'none';
}
</script>
<script>
window.onload = function() {
$('.page_cart1').remove();
$('table#formaddcart').each(function() {

var numero = <?php echo $totalcarritotemp ?>;
const noTruncarDecimales = {
maximumFractionDigits: 2,
minimumFractionDigits: 2
};
ptos = numero.toLocaleString('es', noTruncarDecimales)
var currentPage = 0;
var numPerPage = 200;
var $table = $(this);
var rowCount = $('table.tablasearch tbody tr td.formcartcanttd').length;
$table.bind('repaginate', function() {
$table.find('tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
});
$table.trigger('repaginate');
var numRows = $table.find('tbody tr').length;
var numPages = Math.ceil(numRows / numPerPage);
var $pager = $('<div class="page_cart1"></div>');
var $anterior = $('<li class="prev disabled anterior"><a disabled "href="#"onclick="anterior();">Anterior</a></li>');
var $case = $('<li class="prev"></li>');
var $siguiente = $('<li class="prev siguiente"><a onclick="siguiente();" onsubmit="return false;">Siguiente></a></li>');
var $total = $('<li class="pagination_count"><span id="totalitemss">' + <?php echo $totalitemstemp ?> + ' Articulos</span></li><li class="pagination_count"><span id="totalunidadess"> <?php echo $totalunidadestemp ?>Unid.</span></li><li class="pagination_count"><span id="totaltall">Total $ '+ ptos+'</span></li>');
var $ul = $('<ul id="uli" style="display: inline-flex;" class="pagination"></ul>');
$anterior.appendTo($ul);

for (var page = 0; page < numPages; page++) {
var $linum = $('<div class="page-number" id=pag' + (page + 1) + '><a></a></div>').text(page + 1).bind('click', {
newPage: page
}, function(event) {
currentPage = event.data['newPage'];
$table.trigger('repaginate');

$(this).addClass('active').siblings().removeClass('active');
}).appendTo($ul).addClass('clickeable');
}
$siguiente.appendTo($ul);

$total.appendTo($ul);
$ul.appendTo($pager);
$pager.insertAfter($table).find('div.page-number:first').addClass('active');
});

}
</script>
<script>

function vaciartableimport(){
$(".button").html("");


}
</script>