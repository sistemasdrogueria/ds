<div class="resultpatmed"  >
<div id="flotante"></div>
<?php $indice=0; 

$cat = $categorias; $titulolab=0; $preciot=""; $items = $articulos->toArray();?>
<div class ="col-md-x" >
<table class='tablasearch' cellpadding="0" cellspacing="0">
<tbody>
<?php 
$max2 = sizeof($items);
$max = $max2/2;
$max1= round($max, 0, PHP_ROUND_HALF_DOWN);
$first =0;
for($i = 0; $i < $max1;$i++)
{
$articulo =  $items[$i];
$articulo= $articulo['articulo'];
$itempedido = $items[$i];
if ($articulo['laboratorio_id']!= $titulolab || $first ==0 )
{
if ($first !=0)
echo '<tr><td colspan="6" style =" text-align: center; background: #fff";></td></tr>';
$first =1;
$titulolab = $articulo['laboratorio_id'];

echo '<tr><td colspan="6" align="center" style =" text-align: center; background: #ebebeb; font-weight: bold;">'.$articulo['laboratorio']['nombre'].'</td></tr>';
echo '<tr><th>N° Transfer.</th><th>Cant.</th><th>'. $this->Paginator->sort('descripcion_pag','Descripción').'</th>';
echo '<th>Dto</th><th>Plazo</th><th>U.M.</th></tr>';
}		
?>
<tr>
<td>
<?php
$encabezado = $indice.'.';	$indice=$i+1;

echo $itempedido['pedidos_preventa_id'];
?>
</td>

<td class='formcartcanttd' >
<?php
$encabezado = $indice.'.';	$indice=$i+1;

echo $itempedido['cantidad'];
?>
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

<td class="td-sub-tabla">
<?php 

echo ' <font color="red" style="font-weight: bold;">'.$itempedido['descuento'].'% '.'</font>'; 

?>
</td>
<td class="td-sub-tabla">
<?php echo $itempedido['plazoley_dcto'];?>
</td>
<td class="td-sub-tabla">
<?php echo $itempedido['unidad_minima'];?>
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
/*$max2 = sizeof($items);
$max = $max2/2;*/
$first =0;
$indicej=$max1;
for($j = $max1; $j < $max2; $j++)
{
$articuloj =  $items[$j];
$articuloj= $articuloj['articulo'];
$itempedidoj = $items[$j];
if ($articuloj['laboratorio_id']!= $titulolab || $first ==0 )
{
if ($first !=0)
echo '<tr><td colspan="6" style =" text-align: center; background: #fff";></td></tr>';
$first =1;
$titulolab = $articuloj['laboratorio_id'];
$preciot= $articuloj['preventas'][0]['tipo_precio'];

echo '<tr><td colspan="6" align="center" style =" text-align: center; background: #ebebeb; font-weight: bold;">'.$articuloj['laboratorio']['nombre'].'</td></tr>';
echo '<tr><th>N° Transfer.</th><th>Cant.</th><th>'. $this->Paginator->sort('descripcion_pag','Descripción').'</th><th>Dto</th>';
echo '<th>Plazo</th><th>U.Min</th></tr>';
}		
?>

<tr>
<td>
<?php
$encabezado = $indice.'.';	$indice=$i+1;

echo $itempedidoj['pedidos_preventa_id'];
?>
</td>
<td class='formcartcanttd' >
<?php
//$encabezado = $indice.'.';	$indice=$i;
$encabezadoj = $indicej.'.';	$indicej=$j + 1 ;
echo $itempedidoj['cantidad'];

?>
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
<td class="td-sub-tabla">
<?php echo ' <font color="red" style="font-weight: bold;">'.$itempedidoj['descuento'].'% '.'</font>'; ?>
</td>
<td class="td-sub-tabla">
<?php echo $itempedidoj['plazoley_dcto'];?>
</td>
<td class="td-sub-tabla">
<?php echo $itempedidoj['unidad_minima'];?>
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

</div>	
</div>	

</div>
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
//var res =  $(this).attr('src');
$('.enlargeImageModalSource').attr('src',res);
$('#enlargeImageModal').modal('show');
});
});
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