<?php $indice=0;
$marcas= $marcas->toArray();
$generos=$generos->toArray();
$descuento_pf =$this->request->session()->read('Auth.User.pf_dcto');
$coef = $this->request->session()->read('Auth.User.coef');?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddall'],'id'=>'formaddcart','onsubmit'=>'return validaragregar()']); ?>
<div class="row hide dermocontenedor_search"><br></div>
<div class="dermocontenedorajust dermocontenedor" >
<div class="dermocontenedor">
<?php
if($result !== 0)foreach ($result as $dermo):?>
<div class="dermodiv">
<div class="product-item-4">
<div class="dermoimagen" align="center">
<?php 
$uploadPath = 'producto/';
if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$dermo['imagen'] ))
echo $this->Html->image($uploadPath.$dermo['imagen'], ['alt' => str_replace('"', '', $dermo['nombre'])]);
else
echo $this->Html->image($uploadPath.$dermo['imagen'], ['alt' => str_replace('"', '', $dermo['nombre'])]); 
?> 
</div> 
<div class="product-content overlay">
<span class="title">	
Marca: <br>
</span>
<?php //echo $marcas[$dermo['marca_id']].'<br>' ?>
<span class="title">	
Genero:<br>
</span>
<?php //echo $generos[$dermo['genero_id']] ?>
</div> 
</div>		
<div class='fragdescrip'>
<?= $dermo['nombre'] ?>
</div>
<div class="dermopresentaciondiv">
<table>
<?php 
$dermospresentaciones =$dermo['dermos_presentaciones'];
foreach ( $dermospresentaciones as $fp): ?>
<tr>
<td>
<?php
$indice+=1;
$encabezado = $indice.'.';
$articulo = $fp['articulo'];
echo $this->Form->input($encabezado.'cliente_id',['type'=>'hidden','value'=>$this->request->session()->read('Auth.User.cliente_id')]);
echo $this->Form->input($encabezado.'articulo_id',['type'=>'hidden','value'=>$fp['articulo_id']]);
echo $this->Form->input($encabezado.'categoria_id',['type'=>'hidden','value'=>$articulo['categoria_id']]);	
echo $this->Form->input($encabezado.'precio_publico',['type'=>'hidden','value'=>$articulo['precio_publico']]);
echo $this->Form->input($encabezado.'descripcion',['type'=>'hidden','value'=>$articulo['descripcion_pag']]);
echo $this->Form->input($encabezado.'compra_min',['type'=>'hidden','value'=>$articulo['compra_min']]);
echo $this->Form->input($encabezado.'compra_multiplo',['type'=>'hidden','value'=>$articulo['compra_multiplo']]);
echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>0]); 	
echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>'HABITUAL']); 	
echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>1]); 	
echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'compra_max',['type'=>'hidden','value'=>$articulo['compra_max']]);
if ($articulo['carritos'] !=null )
{
$cantidadencarrito = $articulo['carritos'][0]['cantidad'];
echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'value' =>$cantidadencarrito ,'class'=>'fragcant','target'=>'_blank','onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;','autocomplete'=>'off']);
}
else	
{
echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'class'=>'fragcant','target'=>'_blank',  'onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;', 'autocomplete'=>'off']);
} ?>
</td>
<td class='fragstock'>
<?php switch ($articulo['stock']) {
case 'B': echo $this->Html->image('fragbajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );break;
case 'F': echo $this->Html->image('fragfalta.png',['title' => 'Producto en Falta']);break;
case 'S': echo $this->Html->image('fragalto.png',['title' => 'Stock Habitual']); break;
case 'R': echo $this->Html->image('restrin.png',['value' => 4]);echo '<div class="overlay">Compra Restringida, Máx '.$articulo['restringido_unid'].' Uni</div>'; break;
case 'D': echo $this->Html->image('fragd.png',['title' => 'Producto Discontinuo']); break;
} ?>
</td>
<td class='fragml'>
<?php echo $fp['detalle'].' ml';?>
</td>			
<td class='fragpre'>
<?php echo '$ '.number_format(round(h($articulo['precio_publico'])*$descuento_pf*$coef, 3),2,',','.'); ?>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
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

<script>
function myFunction() {/*document.confirmInput.submit();*/
document.getElementById("fragcant").submit();}
</script>