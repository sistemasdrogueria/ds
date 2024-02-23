<div class="row">
<div class = "gallery-contenedor">
<?php 
$descuento_pf =$this->request->session()->read('Auth.User.pf_dcto');
foreach ($ofertas as $oferta): ?>
<div class="gallery-oferta">
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddoferta'],'id'=>'carritosoferta']); ?>
<?php echo $this->Form->input('cantidad',['type'=>'hidden','value'=>$oferta['uni_min']]);
echo $this->Form->input('articulo_id',['type'=>'hidden','value'=>$oferta['articulo_id']]);
echo $this->Form->input('precio_publico',['type'=>'hidden','value'=>$oferta['precio_publico']]);
echo $this->Form->input('descripcion',['type'=>'hidden','value'=>$oferta['descripcion']]);
echo $this->Form->input('categoria_id',['type'=>'hidden','value'=>$oferta['categoria_id']]);
echo $this->Form->input('compra_max',['type'=>'hidden','value'=>$oferta['compra_max']]);
if ($oferta['tipo_venta']=='D')
{
echo $this->Form->input('descuento',['type'=>'hidden','value'=>$oferta['dto_drogueria']]); 	
echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>$oferta['plazo']]); 	
echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>$oferta['uni_min']]); 	
echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>$oferta['tipo_oferta']]); 
echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>$oferta['tipo_venta']]); 
echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>$oferta['tipo_precio']]); 
}
else
{
echo $this->Form->input('descuento',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>null]); 	
}
?>	
<div class="product-item-6">
<div class="product-thumb">
<?php echo $this->Html->image('ofertas/thumb_'.$oferta['imagen'], ['alt' => str_replace('"', '', $oferta['descripcion'])]);?> 
</div> 
<div class="product-thumb-oferta2">
<?php if ($oferta['dto_drogueria']!=null)
if ($oferta['aplicaen']>1)
echo $this->Html->image('ofertaeti5.png', ['alt' => 'oferta']);
else
echo $this->Html->image('ofertaeti4.png', ['alt' => 'oferta']);
?> 		
</div>
<?php 
if ($oferta['aplicaen']<2)
echo '<div class="product-thumb-oferta3">';
else
echo '<div class="product-thumb-oferta5">';
if ($oferta['dto_drogueria']!=null ){
if ($oferta['aplicaen']>1){
$valoroferta = $oferta['dto_drogueria']*$oferta['aplicaen'];
if (round($valoroferta)<100){
echo '<div class="oferta_porcentaje2">%</div>';
echo '<div class="oferta_descuento">'.round($valoroferta).'</div>';
}
else
{
if ($oferta['aplicaen']==2)
echo '<div class="oferta_descuento" style=" margin-top: 5px; font-size: 35px;">2x1</div>';
if ($oferta['aplicaen']==3)
echo '<div class="oferta_descuento" style=" margin-top: 5px; font-size: 35px;">3x2</div>';
}
}
else
{
	$valoroferta =0;
echo '<div class="oferta_porcentaje">%</div>';
echo '<div class="oferta_descuento">'.round($oferta['dto_drogueria']).'</div>';
}
}
echo '</div>';
?>				
<div class="product-thumb-oferta4">
<?php 
if ($valoroferta>0)
if (round($valoroferta)<100){
if ($oferta['dto_drogueria']!=null && $oferta['aplicaen']==2)
echo '<div class="oferta_enlaxunidad">en la 2da unidad</div>';
if ($oferta['dto_drogueria']!=null && $oferta['aplicaen']==3)
echo '<div class="oferta_enlaxunidad">en la 3ra unidad</div>';
}
?>
</div>
<div class="product-content overlay">
<div class="product-content-oferta1">
<h5>
<?php echo $this->Form->submit(str_replace('"', '', $oferta['descripcion']),array('type'=>'image', 'id'=>'button_descripcion'));	?>
</h5>			
<span class="price">
<?php echo 'Precio Fcia. $'.number_format(round(h($oferta['precio_publico'])*$descuento_pf, 3),2,',','.'); ?>
</span>
<span class="descripcion">
<?php
if ($oferta['dto_drogueria']!=null)
if ($oferta['aplicaen']>1)
{
if ($oferta['aplicaen']==2)
echo 'Oferta: '.$oferta['dto_drogueria']*$oferta['aplicaen'].'% en la 2da unidad - Min :'.$oferta['uni_min'] . ' U </br>'; 
if ($oferta['aplicaen']==3)
echo 'Oferta: '.$oferta['dto_drogueria']*$oferta['aplicaen'].'% en la 3ra unidad - Min :'.$oferta['uni_min'] . ' U </br>'; 
}
else
echo 'Oferta: '.$oferta['dto_drogueria'].'% por '.$oferta['uni_min'].' u</br>';
if ($oferta['plazo']!=null)
echo 'Plazo: '. $oferta['plazo'].'</br>';
if ($oferta['tipo_oferta']!=null)
echo 'Tipo de oferta: '. $oferta['tipo_oferta'].'</br>';
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
<?php endforeach; ?>
</div>
<br>
Dadas las últimas actualizaciones si no visualiza correctamente las ofertas de perfumería, <br>
deberá refrescar la pantalla de su navegador. Para hacerlo, presioné las siguiente combinaciones de teclas: <br>
<br>
Google Chrome: ctrl + F5<br>
Mozilla Firefox: ctrl + shift + r<br>
</div>