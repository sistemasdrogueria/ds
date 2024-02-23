<?php echo $this->Html->script('flickity.pkgd.min');?>
<h3>PRODUCTOS QUE PUEDEN INTERESARTE</h3>
<div class="gallery js-flickity" data-flickity-options='{ "freeScroll": true, "wrapAround": true }'>	
<?php 
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');?>
<?php foreach ($ofertasX as $oferta): ?>
<?php if ($oferta['ubicacion']==1 || $oferta['ubicacion']==2)
    {
?>
<div class="gallery-cell"> <!-- -->
<div class="product-item-4"> <!-- -->
<div class="product-thumb" style="height:200px; width: 200px; padding: 0px; min-height: 200px;">  

<?php echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['busqueda'],$oferta['detalle']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);?> 
</div> 

<div class="product-content-oferta1"> <!-- -->
<span class="descripcion">
</span>
</div> 	<!-- -->


</div> <!-- -->
</div> <!-- -->
    <?php } ?>
<?php endforeach; ?>

<?php foreach ($ofertasY as $oferta): ?>
<?php if ($oferta['ubicacion']>0 && $oferta['ubicacion']<3)
    {
?>
<div class="gallery-oferta">
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddoferta'],'id'=>'carritosoferta']); ?>


<?php echo $this->Form->input('cantidad',['type'=>'hidden','value'=>$oferta['unidades_minimas']]);
echo $this->Form->input('articulo_id',['type'=>'hidden','value'=>$oferta['articulo_id']]);
echo $this->Form->input('precio_publico',['type'=>'hidden','value'=>$oferta['articulo']['precio_publico']]);
echo $this->Form->input('descripcion',['type'=>'hidden','value'=>$oferta['descripcion']]);

echo $this->Form->input('compra_max',['type'=>'hidden','value'=>$oferta['articulo']['compra_max']]);
echo $this->Form->input('categoria_id',['type'=>'hidden','value'=>$oferta['articulo']['categoria_id']]);


if (!empty($oferta['articulo']['descuentos']))
{
    $descuento = $oferta['articulo']['descuentos'][0];
if ($descuento['tipo_venta']==='D')
{
echo $this->Form->input('cantidad',['type'=>'hidden','value'=>$oferta['unidades_minimas']]);
echo $this->Form->input('descuento',['type'=>'hidden','value'=>$descuento['dto_drogueria']]); 	
echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>$descuento['plazo']]); 	
echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>$oferta['unidades_minimas']]); 	
echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>$descuento['tipo_oferta']]); 
echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>$descuento['tipo_venta']]); 
echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>$descuento['tipo_precio']]); 
}
else
{
echo $this->Form->input('descuento',['type'=>'hidden','value'=>0]); 	
echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>'HABITUAL']); 	
echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>1]); 	
echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>null]); 	
}
}
else {
    echo $this->Form->input('descuento',['type'=>'hidden','value'=>0]); 	
echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>'HABITUAL']); 	
echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>1]); 	
echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>null]); 	
}
?>
<div class="product-item-6">
<div class="product-thumb" style="height:200px; padding: 0px;">

<?php 
if  ($oferta['oferta_tipo_id']==12)
echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['busqueda'],$oferta['detalle']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
else

echo $this->Html->image('productos/'.$oferta['articulo']['imagen'], ['alt' => str_replace('"', '', $oferta['descripcion'])]);?> 

</div> 
<div class="product-thumb-oferta2">
    
<?php 
if (!empty($oferta['articulo']['descuentos']))
if ($oferta['aplicaen']>1)
echo $this->Html->image('ofertaeti5.png', ['alt' => 'oferta','class'=>'offparpadea']);
else
echo $this->Html->image('ofertaeti4.png', ['alt' => 'oferta']);
?> 		
</div>
<?php 
if ($oferta['aplicaen']<2)
echo '<div class="product-thumb-oferta3">';
else
echo '<div class="product-thumb-oferta5">';
if (!empty($oferta['articulo']['descuentos'])){
if ($oferta['aplicaen']>1){
    $descuento = $oferta['articulo']['descuentos'][0];    
$valoroferta = $descuento['dto_drogueria']*$oferta['aplicaen'];
if (round($valoroferta)<100){
echo '<div class="oferta_porcentaje2">%</div>';
echo '<div class="oferta_descuento">'.round($valoroferta).'</div>';
}
else
{
if ($oferta['aplicaen']==2)
echo '<div class="oferta_descuento offparpadea" style=" margin-top: 5px; font-size: 35px;">2x1</div>';
if ($oferta['aplicaen']==3)
echo '<div class="oferta_descuento" style=" margin-top: 5px; font-size: 35px;">3x2</div>';
if ($oferta['aplicaen']==4)
echo '<div class="oferta_descuento" style=" margin-top: 5px; font-size: 35px;">4x3</div>';
if ($oferta['aplicaen']==5)
echo '<div class="oferta_descuento" style=" margin-top: 5px; font-size: 35px;">5x4</div>';
}
}
else
{
    $descuento = $oferta['articulo']['descuentos'][0]; 
	$valoroferta =0;
echo '<div class="oferta_porcentaje">%</div>';
echo '<div class="oferta_descuento">'.round($descuento['dto_drogueria']).'</div>';
}
}
else
$valoroferta =0;
echo '</div>';
?>				
<div class="product-thumb-oferta4">
<?php 
if ($valoroferta>0)
if (round($valoroferta)<100){
    if (!empty($oferta['articulo']['descuentos']))
    {
    if ($oferta['aplicaen']==2)
    echo '<div class="oferta_enlaxunidad">en la 2da unidad</div>';
    if ($oferta['aplicaen']==3)
    echo '<div class="oferta_enlaxunidad">en la 3ra unidad</div>';
    if ($oferta['aplicaen']==4)
    echo '<div class="oferta_enlaxunidad">en la 4ra unidad</div>';
    if ($oferta['aplicaen']==5)
    echo '<div class="oferta_enlaxunidad">en la 5ra unidad</div>';
    }
}
?>
</div>
<div class="product-content overlay">
<div class="product-content-oferta1">
<h5>
<?php echo $this->Form->submit(str_replace('"', '', $oferta['descripcion']),array('type'=>'image', 'id'=>'button_descripcion'));	?>
</h5>			
<span class="price">
<?php echo 'Precio Regular: $'.number_format(round(h($oferta['articulo']['precio_publico'])*$descuento_pf, 3),2,',','.'); ?>
<br>
<?php 
$precio_con_dcto=0;
if (!empty($oferta['articulo']['descuentos'])){
    $descuento = $oferta['articulo']['descuentos'][0];
if ($descuento['tipo_venta']=='D')
{
	$descuentooferta = $descuento['dto_drogueria'];
	$precio = $oferta['articulo']['precio_publico'];
	if ($descuento['tipo_precio']=='P')
	{
		$precio -=$precio*($descuentooferta/100);
	}
	if ($descuento['tipo_precio']=='F')
	{
		$precio = $precio*$descuento_pf;
		
		$precio -=$precio*($descuentooferta/100);
	}	
	$precio_con_dcto = $precio;
}	
}
if ($precio_con_dcto!=0) echo 'Precio c/Dto: $ '.number_format(round($precio_con_dcto, 3),2,',','.');
?>
</span>
<span class="descripcion">
<?php
if (!empty($oferta['articulo']['descuentos']))
{
    $descuento = $oferta['articulo']['descuentos'][0];
if ($oferta['aplicaen']>1)
{
if ($oferta['aplicaen']==2)
echo 'Oferta: '.$descuento['dto_drogueria']*$oferta['aplicaen'].'% en la 2da unidad - Min :'.$oferta['unidades_minimas'] . ' U </br>'; 
if ($oferta['aplicaen']==3)
echo 'Oferta: '.$descuento['dto_drogueria']*$oferta['aplicaen'].'% en la 3ra unidad - Min :'.$oferta['unidades_minimas'] . ' U </br>'; 
if ($oferta['aplicaen']==4)
echo 'Oferta: '.$descuento['dto_drogueria']*$oferta['aplicaen'].'% en la 4ta unidad - Min :'.$oferta['unidades_minimas'] . ' U </br>'; 
if ($oferta['aplicaen']==4)
echo 'Oferta: '.$descuento['dto_drogueria']*$oferta['aplicaen'].'% en la 5ta unidad - Min :'.$oferta['unidades_minimas'] . ' U </br>'; 
}
else
echo 'Oferta: '.$descuento['dto_drogueria'].'% por '.$oferta['unidades_minimas'].' u</br>';
if ($descuento['plazo']!=null)
echo 'Plazo: '. $descuento['plazo'].'</br>';
}
?>
</span>
</div> 	
<div class="product-content-oferta2">
<?php echo $this->Form->submit('agregarcarro2.png', ['type'=>'image']);	?> 
</div> 
</div>
</div>
</div>

<?= $this->Form->end() ?>	
<?php }?>
<?php endforeach; ?>