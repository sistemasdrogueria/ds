<script>
	$(document).ready(function() {
		/*
		$('.formcartcant').on('keydown', function(event) {

			var quantity = Math.round($(this).val());
			if ((event.keyCode == 40 || event.keyCode == 38 || event.keyCode == 18||event.keyCode == 9 ||event.keyCode == 13 )) {
				ajaxcart($(this).attr("data-id"), quantity,$(this).attr("data-pv-id"));

			}
			

		}); */

		$(".formcartcant").change(function() {
            var id=$(this).attr("data-id");
			var quantity = Math.round($(this).val());
            var plazo = $(this).attr("data-plazo");
			ajaxcart(id, quantity, plazo);


		});

		$(".formcartplazo").change(function() {
            var id=$(this).attr("data-id");
			var plazo = $(this).val();
            var quantity = $(this).attr("data-cantidad");
			ajaxcart(id,quantity , plazo);

		});


		var inputs = document.querySelectorAll("input,select");
		for (var i = 0; i < inputs.length; i++) {
			inputs[i].addEventListener("keypress", function(e) {
				if (e.which == 13 || e.keyCode == 40 || e.keyCode == 38 || e.keyCode == 18 || e.keyCode == 9) {
					e.preventDefault();
					var nextInput = document.querySelectorAll('[tabIndex="' + (this.tabIndex + 1) + '"]');
					if (nextInput.length === 0) {
						nextInput = document.querySelectorAll('[tabIndex="1"]');
					}
					nextInput[0].focus();
				}
			})
		}



		function ajaxcart(id, quantity, plazo) {

			$.ajax({
				type: "POST",
				url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'TransfersProveedors', 'action' => 'itemupdate')); ?>",
				data: {
					id: id,
					quantity: quantity,
					plazo: plazo
				},
				dataType: "json",
				success: function(data, textStatus) {

                    //alertify.message("").dismissOthers();
				//	alertify.success("Cantidad Agregada Con Exito!");
				
				},
				error: function(textStatus) {
	                //console.log(textStatus);
					//window.location.replace("/products/clear");
				}
			});
		}

	});



	

</script> 

<style>
    .formcartcant{
        width: 40px;
    }
</style>

<div class="articulos index large-10 medium-10 columns">
<table class='tablesorter' cellpadding="0" cellspacing="0">
<thead>
<tr>	
<th ><?= $this->Paginator->sort('cliente_id','Codigo') ?> </th>
<th ><?= $this->Paginator->sort('cliente_id','Cliente') ?> </th>
<th >Cant.</th>
<th >Stock</th>
<th ><?= $this->Paginator->sort('troquel','troquel') ?></th>
<th ><?= $this->Paginator->sort('descripcion_pag','Descripción') ?></th>
<th ><?= $this->Paginator->sort('precio_publico','P.Pub.') ?></th>
<th ><?= $this->Paginator->sort('precio_publico','P.c/ Dto') ?></th>
<th><div id="th-sub-tabla">Dto</div></td>
<th><div id="th-sub-tabla">Plazo</div></td>
<th><div id="th-sub-tabla">Tipo Of.</div></td>
<th >SubTotal</th>
<th ></th>
</thead>
<tbody>
<div id="flotante"></div>
<?php $indice=0;
$cat = $categorias;
$lab = $laboratorios; 

?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'CarritosTransfers','action'=>'carritoaddall'],'id'=>'formaddcart','onsubmit'=>'return validaragregar()']); ?>
<?php foreach ($carritos as $carrito): ?>
<?php //foreach ($articulos as $articulo): ?>
<tr>

<?php $indice+=1;
$encabezado = $indice.'.';//'Carritos.'.$articulo['id'].'.';
$indice+=1;
$articulo = $carrito['articulo'];
?>
<td><?php echo $carrito['cliente']['codigo'];?></td>
<td><?php echo $carrito['cliente']['nombre'];?></td>
<?php
$descuento_pf = $carrito['cliente']['preciofarmacia_descuento'];
$condicion = $carrito['cliente']['condicion_descuento'];
$coef = $carrito['cliente']['coeficiente'];
$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
?>
<td class='formcartcanttd'>
<?php
$cantidadencarrito = $carrito['cantidad'];
//echo $this->Form->input($encabezado.'cantidad',['label'=>'','tabindex'=>$indice,'value' =>$cantidadencarrito ,'class'=>'formcartcant','target'=>'_blank','onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;','autocomplete'=>'off']);
echo $this->Form->input($encabezado.'cantidad', ['label'=>'','tabindex' => $indice, 'value' => $cantidadencarrito, 'class' => 'formcartcant', 'data-id' => $carrito['id'], 'data-plazo' => $carrito['plazoley_dcto'], 'target' => '_blank', 'autocomplete' => 'off', 'style' => 'padding: 1px 1px; width:35px;']);

echo $this->Form->input($encabezado.'cliente_id',['type'=>'hidden','value'=>$this->request->session()->read('Auth.User.cliente_id')]);
echo $this->Form->input($encabezado.'articulo_id',['type'=>'hidden','value'=>$articulo['id']]);
echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=> $carrito['descuento']]); 	

			
?>
</td>
<td class='colstock'><?php
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
break;
}
/*
%aStock  = ("S" => "Stock habitual",
"B" => "Stock bajo. Confirme con su operadora",
"F" => "Producto en Falta",
"D" => "Producto discontinuado",
"R" => "Producto sujeto a stock");*/
?></td>
<td> <?php echo $articulo['troquel'];?></td>
<td class='masinfoband'>
<div 
onmouseover="showdiv(event,'<?php 
echo str_replace('"', '', $articulo['descripcion_pag']).'</br>'; 
echo 'Laboratorio: '.$lab[$articulo['laboratorio_id']].'</br>';
echo 'Categoría: '.$cat[$articulo['categoria_id']].'</br>';
echo 'Troquel: '.$articulo['troquel'].'</br>';
echo 'EAN: '.$articulo['codigo_barras'].'</br>'; ?>
','<?php echo $articulo['iva'];?>'
,'<?php echo $articulo['trazable'];?>'
,'<?php echo $articulo['cadena_frio'];?>'
,'<?php echo $articulo['categoria_id'];?>'
,'<?php echo $articulo['pack'];?>'
,'<?php echo $articulo['fv_cerca'];?>'
,'<?php echo $articulo['fv'];?>')" onMouseOut='hiddenDiv()' 
style='display:table;'>
<?php 

echo $articulo['descripcion_pag']; 

if ($articulo['pack'] !=null){
echo ' <font color="red" >PACK</font>';
}


?>	
</div>				
</td>
<td class='colprecio'>
<?php echo $this->element('transfer_precio_publico',['articulo'=>$articulo]);?>
</td>
<td class='colprecio'>
<?php echo $this->element('transfer_precio_con_descuento',['articulo'=>$articulo, 'carrito'=>$carrito,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef,'condiciongeneral'=>$condiciongeneral] );?>
</td>

<td class="td-sub-tabla">
<?php 

echo ' <font color="red" style="font-weight: bold;">'.$carrito['descuento'].'% '.'</font>'; 


?>
</td>
<td class="td-sub-tabla">
<?php echo $this->Form->input($encabezado.'plazoley_dcto',['label'=>'','class'=>'formcartplazo text-center', 'required','data-id' => $carrito['id'],'data-cantidad'=>$cantidadencarrito ,  'value'=>$carrito['plazoley_dcto'],'style'=>'padding: 1px 1px; width:60px;']); 	?>
</td>
<td class="td-sub-tabla"> <?php echo $carrito['tipo_oferta'];?>    </td>
<td class='colprecio'>
<?php echo $this->element('transfer_precio_subtotal',['articulo'=>$articulo ,'carrito'=>$carrito,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'cantidadencarrito'=>$cantidadencarrito,'coef'=>$coef] );?>
</td>

<td class="actions">
<?php

echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
array("alt" => __('Delete'), "title" => __('Delete'))), 
array('action' => 'delete_item_admin', $carrito['transfer_proveedor_id'],$carrito['transfers_import_id'] ), 
array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $carrito['transfer_proveedor_id']))
);?>

</td>


</tr>


<?php endforeach; //$indice+=2; ?>

</tbody>
</table>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>
<div class="importconfirm2">	
<div class="button-holder5">
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
//event.y|event.clientY = devuelve la posicion en relacion a la parte superior visible del navegador
//event.screenY = devuelve la posicion del cursor en relaciona la parte superior de la pantalla
//event.offsetY = devuelve la posicion del mouse en relacion a la posicion superior de la caja donde se ha pulsado
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
var fvcerca='';
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
fvcerca = 'Vencimiento: ';
fvcerca = fvcerca.concat(fv);			 
}				
document.getElementById('flotante').innerHTML=text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg+fvimg+fvcerca;
// Posicionamos la capa flotante
document.getElementById('flotante').style.top = (tempY-120)+"px";
document.getElementById('flotante').style.left = (tempX-10)+"px";
document.getElementById('flotante').style.display='block';
return;
}
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
</script>