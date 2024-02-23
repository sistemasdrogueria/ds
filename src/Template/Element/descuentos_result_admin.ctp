
<script>
$(document).ready(function(){

$(".formcartcant").blur(function(){
 
 	var quantity = Math.round($(this).val());
	 ajaxcart($(this).attr("data-id"), quantity);


});

var inputs = document.querySelectorAll("input,select");
for (var i = 0 ; i < inputs.length; i++) {
   inputs[i].addEventListener("keypress", function(e){
      if (e.which == 13 ||e.keyCode == 40 || e.keyCode == 38 || e.keyCode == 18||e.keyCode == 9  ) {
         e.preventDefault();
         var nextInput = document.querySelectorAll('[tabIndex="' + (this.tabIndex + 1) + '"]');
         if (nextInput.length === 0) {
            nextInput = document.querySelectorAll('[tabIndex="1"]');
         }
         nextInput[0].focus();
      }
   })
}

function ajaxcart(id, quantity, pv_id) {

	$.ajax({
		type: "POST",
		url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Articulos', 'action' => 'ordenupdate')); ?>",
		data: {
			id: id,
			quantity: quantity
			
		},
		dataType: "json",
		success: function(data, textStatus) {
			
			$.each(data.articulo, function(key, value) {
                    // console.log(value);
				});

		},
		error: function(textStatus) {
			//onsole.log(textStatus);
			//window.location.replace("/products/clear");
		}
	});
}

});
</script>
               

<div>	
<div id="tab1" class="tab_content">
<?= $this->Form->create('Ofertas',['url'=>['controller'=>'Ofertas','action'=>'edit_oferta']]); ?>
<table class="tablesorter"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('Articulos.fp_orden','Orden') ?></th>
<th><?= $this->Paginator->sort('id','Imagen') ?></th>
<th><?= $this->Paginator->sort('id','EAN') ?></th>
<th><?= $this->Paginator->sort('Articulos.descripcion_sist','Descripción') ?></th>
<th><?= $this->Paginator->sort('Articulos.stock','STOCK') ?></th>
<th><?= $this->Paginator->sort('dto_drogueria','Descuento') ?></th>
<th><?= $this->Paginator->sort('uni_min','Unidades Min') ?></th>
<th><?= $this->Paginator->sort('fecha_desde') ?></th>
<th><?= $this->Paginator->sort('fecha_hasta') ?></th>
<th><?= $this->Paginator->sort('plazo') ?></th>

<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>

<?php $indice=0; ?>
<?php foreach ($descuentos as $oferta): ?>
<tr>
<td>
<?php 
$indice+=1;
$encabezado = $indice.'.';
echo $this->Form->input($encabezado.'id',['tabindex'=>$indice,'value' =>$oferta['articulo']['fp_orden'] ,'label'=>'','class'=>'formcartcant','data-id' => $oferta['articulo']['id'],'target'=>'_blank','autocomplete'=>'off', 'style'=>'padding: 1px 1px; width:35px;']);?>
</td>
<td>
<?php 
$uploadPath = 'productos//' ;	

$filename = WWW_ROOT . 'img' . DS .$uploadPath.$oferta['articulo']['imagen'] ;						
if (file_exists($filename))
echo $this->Html->image($uploadPath.$oferta['articulo']['imagen'], ['alt' => str_replace('"', '', $oferta['articulo']['descripcion_sist']),'height' => 75]);
//else
//echo $uploadPath.$oferta['imagen'];	
?> 

</td>
<td><?=$oferta['articulo']['codigo_barras'] ?></td>
<td>
<?= $oferta['articulo']['descripcion_sist'] ?>
</td>
   
<td class='colstock'><?php
switch ($oferta['articulo']['stock']) {
case 'B': echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );	break;
case 'F': echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);				break;
case 'S': echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);					break;
case 'R': echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);		break;
case 'D': echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);			break;
}
?></td>



<td><?php echo $oferta->dto_drogueria.' %' ?></td>
<td><?= $oferta->uni_min ?></td>
<td><?php echo date_format($oferta->fecha_desde,'d-m-Y');?></td>
<td><?php echo date_format($oferta->fecha_hasta,'d-m-Y');?></td>

<td><?php echo $oferta->plazo;?></td>

<?php 

//$indice+=1;
//$encabezado = $indice.'.';
//echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=> $oferta->id]);
?>

<td class="actions">

<?=	$this->Html->image("admin/icn_edit.png", array(
"alt" => "Edit",
'url' => array('controller' => 'Articulos', 'action' => 'edit',  $oferta['articulo']['id'])
));
?>
<?=	$this->Html->image("admin/icn_view.png", array(
"alt" => "Ver",
'url' => array('controller' => 'Descuentos', 'action' => 'view_admin',  $oferta->id)
));?>
</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>
<?= $this->Form->end() ?>
</div><!-- end of .tab_container -->
<div class="pagination">
<ul>
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
?>
</ul>
<div class="total">
<?php
echo $this->Paginator->counter('{{count}} Total');
?>
</div>
</div>
</div>		