<style>
	.tablasearch tbody {
    border: 3px solid #1c2e4c;
}
.tablasearch {
    width: 100%;
    margin-bottom: 30px; 
}
</style>


<div   >
<div id="flotante"></div>
<?php $indice=0; 

$cat = $categorias; $titulolab=0; $preciot=""; $items = $articulos->toArray();

$descuento_pf = $this->request->session()->read('cliente.preciofarmacia_descuento');
$condicion = $this->request->session()->read('cliente.condicion_descuento');
$coef = $this->request->session()->read('cliente.coeficiente');
$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
$condiciongeneralmsd = 100*(1-($descuento_pf));
$condiciongeneralcf = 100*(1-($descuento_pf *1.0248* (1-$condicion/100)));
$condiciongeneralaz = 100*(1-($descuento_pf *0.892));
?>
<div class="col-md-x" id=number1>

<?php 
       
$max2 = sizeof($items);
$arr =[];
foreach ($items as $ite):

$dort=$ite['articulo']['laboratorio']['nombre'];
	$arcount =$dort;
    list($a)=$arcount;
    array_push($arr,$arcount);
endforeach;

$countarr=array_count_values($arr);
$taba =sizeof($countarr);
$unidades = 0;
$unidades1 = 0;
$subtotal = 0;
$unico= array_unique($arr);
$tabltot= count($unico);
$tabltotd=$tabltot/2;
$max = $max2/2;
$max1= round($max, 0, PHP_ROUND_HALF_DOWN);
$first =0;
$indic=0;
$resu1 = 0;
$resu = 0;
    if($taba> 1 ){
			$tabarc2 =$taba/2;
			$tablass = [array_slice($countarr, 0, ceil($tabarc2)),array_slice($countarr, ceil($tabarc2))];
			$tabltitle1=array_sum($tablass[0]);
			$tabltitle2=array_sum($tablass[1]);
		
		} else{
			$ss=$max2;
			$tabltitle1= $max2;
			$tabltitle2= 0;

		}

		   if( $tabltitle1 > $max ){
			if( $tabltitle1!==1){
			$tabltitle1 = $tabltitle1;

			}
			

		}

		if( $tabltitle2 > $max ){
			if( $tabltitle2!==1){
			$tabltitle1 = $tabltitle1+1;

			}
			

		}




for($i = 0; $i < $tabltitle1; $i++)
{
$indic = $i + 1;			
$articulo =  $items[$i];

$articulo= $articulo['articulo'];

$itempedido = $items[$i];
if ($articulo['laboratorio_id']!= $titulolab || $first ==0 )
{
if ($first !=0)
echo '<tr><td colspan="6" style =" text-align: center; background: #fff";></td></tr>';
$first =1;
$titulolab = $articulo['laboratorio_id'];

echo '<table class="tablasearch" id="car' . $indic . '" cellpadding="0" cellspacing="0">
		<tbody><tr ><td colspan="8" align="center"  style =" border: 2px  solid #1c2e4c; text-align: center; background: #ebebeb; font-weight: bold;">'.$articulo['laboratorio']['nombre'].'</td></tr>';
echo '<tr style ="border: 2px solid #1c2e4c;"><th>N° Transfer.</th><th>Cant.</th><th>'. $this->Paginator->sort('descripcion_pag','Descripción').'</th>';
echo '<th>Dto</th><th>Plazo</th><th class="hide">PSP</th><th  class="hide">PCD</th><th>U.M.</th></tr>';
}		



if ($i + 1 >$tabltitle1) {
				//echo '<tr style=" border-left: 2px solid #1c2e4c; border-right: 2px solid #1c2e4c;border-bottom: 2px solid #1c2e4c;" >';
//print_r($tabltitle1);
			$x = $i;
				$cont = 0;
				$contt=0;
	
				$tabltitle1 = $x++;
			
			
				echo '<tr  class="care1" style=" border-left: 2px solid #1c2e4c; border-right: 2px solid #1c2e4c;">';
				}else

				echo '<tr   class="care1" style=" border-left: 2px solid #1c2e4c; border-right: 2px solid #1c2e4c;">';

			?>

<td align="center">
<?php
$encabezado = $indice.'.';	$indice=$i+1;

echo $itempedido['pedidos_preventa_id'];
?>
</td>

<td class='formcartcanttd' >
<?php
$encabezado = $indice.'.';	$indice=$i+1;
$unidades += $itempedido['cantidad'];
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
<td class="td-sub-tabla  hide">
<?php 
if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))
echo $this->element('precio_publico',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef,'condiciongeneral'=>$condiciongeneral] );
else
echo $this->element('precio_es_farmacia',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef] );?></br>
</div>
</td>
<td class='colprecio hide ' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<div style="font-weight: bold;">
<?php 
//echo $this->element('precio_es_condescuento',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef] );
?>
<?php 

$total =$this->element('precio_condescuentoconf',['articulo'=>$itempedido ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef,'condiciongeneral'=>$condiciongeneral] )*$itempedido['cantidad'];
$resu1 += $total;
echo $this->element('precio_condescuentoconf',['articulo'=>$itempedido ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef,'condiciongeneral'=>$condiciongeneral] );?>
</td>


<td class="td-sub-tabla">
<?php echo $itempedido['unidad_minima'];?>
</td>
</tr>		
<?php 	

			if ($i + 1 >= $tabltitle1) {
				
				$indic = $tabltitle2 + 10;
				echo '<tr style= "border: 2px solid #1c2e4c;">
                  
<td colspan="1" style =" border-top: 2px solid #1c2e4c;text-align: center; font-weight: bold;background: #ebebeb;"></td>
<td style =" border-top: 2px solid #1c2e4c;text-align: center; background: #ebebeb;font-weight: bold;"; id="cantcar' . $indic. '" class="formcartcanttd">' . $unidades . ' </td> 
<td colspan="1" style =" border-top: 2px solid #1c2e4c;text-align: center; font-weight: bold;background: #ebebeb;"></td>
<td colspan="1" style ="border-top: 2px solid #1c2e4c;background: #ebebeb;"></td><td colspan="4"  class="formcartcanttds float-left"style =" border-top: 2px solid #1c2e4c;text-align: center; background: #ebebeb;font-weight: bold;"; id="subt' . $indic . '">Subtotal $' .number_format( $resu1, 2, ',', '.') . ' </td>
 </tr>'; 
			
			}
}	
?>
</tbody>
</table>
</div>
<div class="col-md-x flex-container" id="number2">

<?php 
/*$max2 = sizeof($items);
$max = $max2/2;*/
$first =0;
$indi = 100;
$indicej=$tabltitle1;

for($j = $tabltitle1; $j < $max2; $j++)
{
 $indi = $indi+1;
$articuloj =  $items[$j];
$articuloj= $articuloj['articulo'];
$itempedidoj = $items[$j];

$unidades1 += $itempedidoj['cantidad'];
if ($articuloj['laboratorio_id']!= $titulolab || $first ==0 )
{
	
if ($first !=0)
echo '<tr><td colspan="6" style =" text-align: center; background: #fff";></td></tr>';
$first =1;
$titulolab = $articuloj['laboratorio_id'];
$preciot= $articuloj['preventas'][0]['tipo_precio'];

echo '<table class="tablasearch" id="car' . $indi . '" cellpadding="0" cellspacing="0">	
<tbody><tr style ="border: 2px solid #1c2e4c;"><td colspan="6" align="center" style =" text-align: center; background: #ebebeb; font-weight: bold;">'.$articuloj['laboratorio']['nombre'].'</td></tr>';
echo '<tr style ="border: 2px solid #1c2e4c;"><th>N° Transfer.</th><th>Cant.</th><th>'. $this->Paginator->sort('descripcion_pag','Descripción').'</th><th>Dto</th>';
echo '<th>Plazo</th><th>U.Min</th></tr>';
}		

if ($j+1>=$max2)

echo '<tr id="care1" style ="border-left: 2px    solid #1c2e4c;border-right: 2px   solid #1c2e4c;border-bottom: 2px   solid #1c2e4c;">';
else
echo '<tr id="care1"style ="border-left: 2px   solid #1c2e4c;border-right: 2px   solid #1c2e4c;">';
?>
<td align="center">
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
<td class='colprecio hide' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<div style="font-weight: bold;">
<?php 
//echo $this->element('precio_es_condescuento',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef] );
?>
<?php 
$total =$this->element('precio_condescuentoconf',['articulo'=>$itempedidoj ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef,'condiciongeneral'=>$condiciongeneral] )*$itempedidoj['cantidad'];
$resu += $total;

echo $this->element('precio_condescuentoconf',['articulo'=>$itempedidoj ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef,'condiciongeneral'=>$condiciongeneral] );?>
</td>

<td class="td-sub-tabla ">
<?php echo ' <font color="red" style="font-weight: bold;">'.$itempedidoj['descuento'].'% '.'</font>'; ?>
</td>
<td class="td-sub-tabla">
<?php echo $itempedidoj['plazoley_dcto'];?>
</td>
<td class="td-sub-tabla">
<?php echo $itempedidoj['unidad_minima'];?>
</td>
</tr>


<?php	} if ($tabltitle2> 0)
	
			//echo '<tr><td colspan="3" style ="background: #fff;" style =" background: #fff;"></td><td colspan="2" style =" text-align: right; font-weight: bold;background: #ebebeb;">SUBTOTAL</td><td colspan="2" style =" text-align: center; background: #ebebeb;font-weight: bold;"; class="formcartcanttd">'.$unidades .' </td></tr>';
			echo '<tr style ="border: 2px solid #1c2e4c;">

<td colspan="1" style =" border-top: 2px solid #1c2e4c;text-align: center; font-weight: bold;background: #ebebeb;"></td>
<td style =" border-top: 2px solid #1c2e4c;text-align: center; background: #ebebeb;font-weight: bold;"; id="cantcar' . $indi . '" class="formcartcanttd">' . $unidades1 . ' </td> 
<td colspan="1" style =" border-top: 2px solid #1c2e4c;text-align: center; font-weight: bold;background: #ebebeb;"></td>
<td colspan="1" style ="border-top: 2px solid #1c2e4c;background: #ebebeb;"></td><td colspan="4"  class="formcartcanttds float-left"style =" border-top: 2px solid #1c2e4c;text-align: center; background: #ebebeb;font-weight: bold;"; id="subt' . $indi . '">Subtotal $' . number_format( $resu, 2, ',', '.') . ' </td>
 </tr>';


?>	


</tbody>
</table>
</div>
<div class ="col-md-12">


<div class ="col-md-x">
<table class='tablasearch' cellpadding="0" cellspacing="0">	
<tbody>
<?php 
echo '<tr style ="border: 2px solid #1c2e4c;"><td colspan="3" align="center" style =" text-align: center; background: #ebebeb; font-weight: bold;">TOTALES</td></tr>';
echo '<tr style ="border: 2px solid #1c2e4c;"><th>IMPORTE</th><th>UNIDADES</th><th>ITEMS</th></tr>';
echo '<tr style ="border: 2px solid #1c2e4c;"><td align="center">$ '.number_format(round($total_importe, 3),2,',','.').'</td>';
echo '<td align="center">'.$total_unidades.'</td><td align="center">'.$total_items.'</td>';
echo'</tr>';
?>
</tbody>
</table>

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
document.getElementById('flotante').style.top = (tempY-10)+"px";
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
<script>/*
	var ctd = $('.tablasearch').length;
    var ctdm =ctd-1;
	for (i = 0; i < ctdm; i++) {
		var gur = document.querySelectorAll('.tablasearch');
		var ar = $('.tablasearch').toArray();
	
		var idtb = ar[i].id;

        console.log(idtb);
        
        console.log(ctdm);
	
	totale(idtb);
	}



    function totale (idtb){
var e = document.querySelector("#"+idtb).rows.length;
 var total =0;
 var totalp =0;
 	var noTruncarDecimales = {
			maximumFractionDigits: 2,
			minimumFractionDigits: 2,
		};
for(i=2; i < e; i++)
{
var h = document.querySelector("#"+idtb).rows[i].children[1].innerText;
var j = document.querySelector("#"+idtb).rows[i].children[6].innerText;
 total =parseInt(total)+parseInt(h);
  totalp =parseFloat(totalp)+parseFloat(j);
 console.log(total,totalp);
}
	var num = totalp;
	
		ptnum = parseFloat(num).toLocaleString(['ban', 'id'], noTruncarDecimales);

$('<tr style="border: 2px solid #1c2e4c;"><td  id="cantcar'+idtb+'" style=" border-top: 2px solid #1c2e4c;text-align: center; font-weight: bold;background: #ebebeb;"></td><td style=" border-top: 2px solid #1c2e4c;text-align: center; background: #ebebeb;font-weight: bold;" class="formcartcanttd"> '+total+'</td><td style="border-top: 2px solid #1c2e4c;background: #ebebeb;"></td><td colspan="4" class="formcartcanttds float-left" style=" border-top: 2px solid #1c2e4c;text-align: center; background: #ebebeb;font-weight: bold;" id="subt11">Subtotal $'+ptnum+'</td></tr>').appendTo($("#"+idtb));
}*/

</script>