<div class="articulos index large-10 medium-10 columns">
<table class='tablasearch' id="tablaviewresult" cellpadding="0" cellspacing="0">
<thead>
		<tr>
				<th rowspan="2" style="    width: 90px;">Cant.</th>
				<th rowspan="2">Pack</th>
				<th rowspan="2"><a href="#tablasearch" onclick="sortTableviewp(14,'tablaviewresult','tbodyview');"onsubmit="return false">Stock</a></th>
				<th rowspan="2"><a href="#tablasearch"  onclick="sortTableviewp(3,'tablaviewresult','tbodyview');"onsubmit="return false">troquel</a></th>
				<th rowspan="2"><a href="#tablasearch" onclick="sort_descripcion(13,'tablaviewresult','tbodyview');" onsubmit="return false">Descripción</a></th>
				<th rowspan="2"><a href="#tablasearch" onclick="sortTableviewp(5,'tablaviewresult','tbodyview');" onsubmit="return false">P.Pub</a></th>
				<th rowspan="2"><a href="#tablasearch" onclick="sortTableviewp(6,'tablaviewresult','tbodyview');" onsubmit="return false">P.c/ Dto</a></th>
				<th rowspan="2">Dto</th>
				<th colspan="3" align="center">Ofertas</th>
				<th rowspan="2">SubTotal</th>
				<th rowspan="2"></th>
			</tr>
<tr>
<th><div id="th-sub-tabla">U.Min</div></td>
<th><div id="th-sub-tabla">Plazo</div></td>
<th><div id="th-sub-tabla">Tipo Of.</div></td>
</tr>
</thead>
	<tbody id="tbodyview">
<div id="flotante"></div>
<?php $indice=0;
$cat = $categorias;
$lab = $laboratorios; 
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');
$coef_pyf = $this->request->session()->read('Auth.User.coef_pyf');
$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
$condiciongeneralmsd= 100*(1-($descuento_pf));
$condiciongeneralcf = 100*(1-($descuento_pf *1.0248* (1-$condicion/100)));
$condiciongeneralaz = 100*(1-($descuento_pf *0.892));

?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'#'],'id'=>'formaddcart','onsubmit'=>'return false;']); ?>
<?php foreach ($articulos as $articulo): ?>
<?php if (isset($articulo['descuentos'][0]['id'])) {
if ($articulo['descuentos'][0]['tipo_venta']=='D')
	$descuento = $articulo['descuentos'][0]['id'];
	else if (isset($articulo['descuentos'][1]['id'])) {
		if ($articulo['descuentos'][1]['tipo_venta']=='D')
		{ $descuento = $articulo['descuentos'][1]['id'];}
		else
		$descuento =0;
	 }
	else{$descuento=0; }
}else{
$descuento=0;   
}
?>
<?php
if ($articulo['carritos'] != null) {
if ($articulo['carritos'][0]['cantidad'] < $articulo['carritos'][0]['unidad_minima']) {
echo '<tr id="trBody' .  $articulo['id'] .'" class =carrito_item_sinoferta >';
} else {
echo '<tr id="trBody' . $articulo['id'] . '">';
}
} else {
echo '<tr id="trBody' . $articulo['id'] . '">';
}
?>
<?php $indice+=1;
$encabezado = $indice.'.';
$indice+=1; ?>
<td  class='formcartcanttd1'>
<div class=formcartcanttd_div >   
<button class="btn btn-sm" onclick="decrementCarritoView('car'+<?php echo $articulo['id']; ?>,<?php echo $descuento ?>,<?php echo $articulo['id']; ?>,<?php echo $articulo['carritos'][0]['id'] ?>);" return="false;">-</button>
<?php
if ($articulo['carritos'] !=null )
$cantidadencarrito = $articulo['carritos'][0]['cantidad'];
else
$cantidadencarrito ="";
if ($articulo['descuentos'] !=null ){	
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
echo $this->Form->input($encabezado.'cantidad',['maxlength'=>"3", 'id'=>'tab'.$indice,'tabindex'=>$indice,'value'=>$cantidadencarrito, 'data-id-input'=>'tab'.$indice,'data-id'=>$articulo['id'],'data-cantidad-car'=>$cantidadencarrito,'data-pv-id'=> $articulo['descuentos'][0]['id'] ,'class'=>'formcartcantt' ,'onkeypress'=>'return soloNumeros(event)','target'=>'_blank'/*,  'onchange'=>'javascript:document.confirmInput.submit();'*/, 'autocomplete'=>'off']);
}
else
{
if (count($articulo['descuentos'])>1)
{
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
echo $this->Form->input($encabezado.'cantidad',['maxlength'=>"3", 'id'=>'tab'.$indice,'data-cantidad-car'=>$cantidadencarrito, 'data-id-input'=>'tab'.$indice,'tabindex'=>$indice,'data-id'=>$articulo['id'],'data-pv-id'=> $articulo['descuentos'][1]['id'],'value'=>$cantidadencarrito ,'class'=>'formcartcantt' ,'onkeypress'=>'return soloNumeros(event)','target'=>'_blank'/*,  'onchange'=>'javascript:document.confirmInput.submit();'*/, 'autocomplete'=>'off']);
}
else
{
echo $this->Form->input($encabezado.'cantidad',['maxlength'=>"3", 'id'=>'tab'.$indice,'data-cantidad-car'=>$cantidadencarrito, 'data-id-input'=>'tab'.$indice,'tabindex'=>$indice,'value'=>$cantidadencarrito, 'data-id'=>	$articulo['id'],'data-pv-id'=> 0 ,'class'=>'formcartcantt' ,'onkeypress'=>'return soloNumeros(event)','target'=>'_blank'/*,  'onchange'=>'javascript:document.confirmInput.submit();'*/, 'autocomplete'=>'off']);
}
}
else
{
echo $this->Form->input($encabezado.'cantidad',['maxlength'=>"3", 'id'=>'tab'.$indice,'data-cantidad-car'=>$cantidadencarrito, 'data-id-input'=>'tab'.$indice,'tabindex'=>$indice,'data-id'=>	$articulo['id'],'data-pv-id'=> 0,'value'=>$cantidadencarrito ,'class'=>'formcartcantt' ,'onkeypress'=>'return soloNumeros(event)','target'=>'_blank'/*,  'onchange'=>'javascript:document.confirmInput.submit();'*/, 'autocomplete'=>'off']);
}
}
}
else
{	/* producto en falta*/
echo $this->Form->input($encabezado.'cantidad',['maxlength'=>"3",'id'=>'tab'.$indice,'data-cantidad-car'=>$cantidadencarrito, 'data-id-input'=>'tab'.$indice,'tabindex'=>$indice,'data-id'=>$articulo['id'],'data-pv-id'=> 0, 'value'=>$cantidadencarrito, 'class'=>'formcartcantt' ,'onkeypress'=>'return soloNumeros(event)','target'=>'_blank'/*,  'onchange'=>'javascript:document.confirmInput.submit();'*/, 'autocomplete'=>'off']);
}
?>
<button class="btn btn-sm" onclick="increment(<?php echo $articulo['id']; ?>,<?php echo $descuento ?>,<?php echo $articulo['id']; ?>);">+</button>
</div>
</td>

<td class=td_view_table2> 
<?php if ($articulo['venta_paq']>0) if ($articulo['paq']>1) echo $articulo['paq']; ?>
</td>
<td class=td_view_table2><?php
switch ($articulo['stock']) {
case 'B':
echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );
break;
case 'F':
echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);
break;
case 'S':
echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);
break;
case 'R':
echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);
break;
case 'D':
echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);
break; }?>
</td>
<td class=td_view_table3> <?php echo $articulo['troquel'];?></td>

<?php
$texto ='';
$texto =  $texto . str_replace('"', '', $articulo['descripcion_pag']).'</br>';
$texto= $texto .'Laboratorio: '.$lab[$articulo['laboratorio_id']].'</br>';
$texto= $texto .'Categoría: '.$cat[$articulo['categoria_id']].'</br>';
$texto= $texto .'Troquel: '.$articulo['troquel'].'</br>';
$texto= $texto .'EAN: '.$articulo['codigo_barras'].'</br>';
if ($articulo['descuentos'] !=null && $articulo['stock']!='F')
{
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
	if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
	{
		$texto= $texto .'Oferta: '.$articulo['descuentos'][0]['dto_drogueria'].'% por '.$articulo['descuentos'][0]['uni_min'].'unidad(es)</br>';
	}
	else
	{
		$descuento_off = number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.') ;
		$texto= $texto .'Oferta: '.$descuento_off.'% por '.$articulo['descuentos'][0]['uni_min'].'unidad(es)</br>';
	}
	$texto= $texto .'Plazo: '. $articulo['descuentos'][0]['plazo'].'</br>';
	if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
	{
		$texto= $texto .'Tipo de oferta: '. $articulo['descuentos'][0]['tipo_oferta'].'</br>';
	}
	else
	{
		$texto= $texto .'Tipo de oferta: TD </br>';
	}

	
}
else
if (count($articulo['descuentos'])>1)
{
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
	if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
	{
		$texto= $texto .'Oferta: '.$articulo['descuentos'][1]['dto_drogueria'].'% por '.$articulo['descuentos'][1]['uni_min'].'unidad(es)</br>';	
	}
	else
	{
		$descuento_off = number_format(round($articulo['descuentos'][1]['dto_drogueria']+$condiciongeneral, 3),2,',','.') ;
		$texto= $texto .'Oferta: '.$descuento_off.'% por '.$articulo['descuentos'][1]['uni_min'].'unidad(es)</br>';
	}
	$texto= $texto .'Plazo: '. $articulo['descuentos'][1]['plazo'].'</br>';
	if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
	{
		$texto= $texto .'Tipo de oferta: '. $articulo['descuentos'][1]['tipo_oferta'].'</br>';
	}
	else
	{
		$texto= $texto .'Tipo de oferta: TD </br>';
	}
}
}
}?>

<td class=td_view_table3>
	
<div onmouseover="showdiv(event,'<?php echo $texto;?>
','<?php echo $articulo['iva'];?>'
,'<?php echo $articulo['trazable'];?>'
,'<?php echo $articulo['cadena_frio'];?>'
,'<?php echo $articulo['categoria_id'];?>'
,'<?php echo $articulo['pack'];?>'
,'<?php echo $articulo['fv_cerca'];?>'
,'<?php echo $articulo['fv'];?>'
,'<?php echo $articulo['imagen'];?>')" onMouseOut='hiddenDiv()' style='display:table;'>
<?php 
	 if ($descuento!= 0){ if ($articulo['descuentos'][0]['tipo_venta']=='D' &&
		($articulo['carritos'][0]['cantidad'] < $articulo['carritos'][0]['unidad_minima'])) 
													{ echo $this->Html->image('oferta_perdida.png',['class'=>'off_perdida imgoferta'.$articulo['carritos'][0]['articulo_id'].'']); }
													else
													{ echo $this->Html->image('oferta_adquirida.png',['class'=>'off_perdida imgoferta'.$articulo['carritos'][0]['articulo_id'].'']); }
											}
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
//echo ' '.$this->Html->image('oferta.png',['title' => 'Oferta']);
}	
else
{	
if (count($articulo['descuentos'])>1)
{
	/*
if ($articulo['descuentos'][1]['tipo_venta']=='D' and $articulo['stock']!='F')
echo ' '.$this->Html->image('oferta.png',['title' => 'Oferta']);*/
}
}
}
?>	
</div>				
</td>
<td class=td_view_table5>
<?php echo $this->element('precio_publicox',['articulo'=>$articulo,'coef_pyf'=>$coef_pyf,'coef'=>$coef,'descuento_pf'=>$descuento_pf]);?>
</td>
<td class=td_view_table5>
<?php echo $this->element('precio_condescuento',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef , 'condiciongeneral'=>$condiciongeneral] );?>
</td>
<td class="td_view_table4">
<?php echo $this->element('precio_descuento_porcentaje',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef , 'condiciongeneral'=>$condiciongeneral, 'condiciongeneralmsd'=>$condiciongeneralmsd,'condiciongeneralcf'=>$condiciongeneralcf] );?>
</td>
<td class="td-sub-tabla-view">
<?php echo $this->element('precio_descuento_unim',['articulo'=>$articulo ] );?>
</td>
<td class="td-sub-tabla-view">
<?php echo $this->element('precio_descuento_plazo',['articulo'=>$articulo ] );?>
</td>
<td class="td-sub-tabla-view">
<?php echo $this->element('precio_descuento_tipo',['articulo'=>$articulo ] );?>
</td>
<td class=td_view_table5 data-subtotal="sub<?php echo $articulo['id'] ?>">
<?php echo $this->element('precio_subtotal',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'cantidadencarrito'=>$cantidadencarrito,'coef'=>$coef,'condiciongeneral'=>$condiciongeneral] );?>
</td>
<td class="actions">
<a href="#" onclick="preguntarSiNo(<?php echo $articulo['carritos'][0]['id'] ?>,<?php echo $articulo['carritos'][0]['articulo_id'] ?>)">
<?php echo $this->Html->image("delete_ico.png", ["alt" => "Quitar del carro"]); ?></a>
</td>
<td class="hide">

<?php echo $articulo['descripcion_sist']; ?>
</td>
<td class="hide"> <?php 		switch ($articulo['stock']) {
												case 'B':
													echo 2;
													break;
												case 'F':
													echo 3;
													break;
												case 'S':
													echo 1;
													break;
												case 'R':
													echo 4;
													break;
												case 'D':
													echo 5;
													break;
											} ?></td>

</tr>
<?php endforeach; //$indice+=2; ?>
</tbody>
</table>


<?php //* Precios con la condición del cliente incluido ?></p>	
<div class="paginator" id="paginator_view">
<ul class="pagination" id="paginator_flechas">
	<?php //echo $this->Html->image("pag_ant.png", ["alt" => "Anterior"]); ?>
<!--?= $this->Html->image("pag_ant.png", ["alt" => "Anterior"]),["escape"=>false], null ?-->
<!--?= $this->Paginator->numbers(['class'=>'pag_num']) ?-->
<?php //echo $this->Html->image("pag_sig.png", ["alt" => "Siguiente"]); ?>
<!--?= $this->Paginator->next($this->Html->image("pag_sig.png", ["alt" => "Siguiente"]),["escape"=>false],['tabindex'=>$indice]) ?-->
</ul>
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
eanimg ='<img src="https://www.drogueriasur.com.ar/ds/webroot/img/productos/'+ean+'" alt="'+ean+'">';

document.getElementById('flotante').innerHTML="<div id='flotante_text'>"+text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg+fvimg+fvcerca+"</div><div id='flotante_img'>"+eanimg+"</div>";

document.getElementById('flotante').style.top = (tempY-120)+"px";
document.getElementById('flotante').style.left = (tempX-10)+"px";
document.getElementById('flotante').style.display='block';
return;
}
$(function() {
$('.imgFoto').on('click', function() {
var str =  $(this).attr('src');
var str = str.replace("foto.png", "productos/"+$(this).data("id"));
var res = str.replace("productos/", "productos/big_");
var a = new XMLHttpRequest;
a.open( "GET", res, false );
a.send( null );
if (a.status === 404)
{
var res =  $(this).attr('src');
var res = res.replace("foto.png", "productos/"+$(this).data("id"));
}			

$('.enlargeImageModalSource').attr('src',res);
$('#enlargeImageModal').modal('show');
});
});
function hiddenDiv()
{
document.getElementById('flotante').style.display='none';
}
</script>
<script>
function myFunction() {
/*document.confirmInput.submit();*/
document.getElementById("formaddcart").submit();
}


		function sortTableview(n) {
	  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	
  table = document.getElementById("tablaviewresult");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;

    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 2; i < (rows.length - 1); i++) {
        
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      
      y = rows[i + 1].getElementsByTagName("TD")[n];

	  
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }

  }


</script>
<script>
	var dir = "asc";
</script>