<style>
.product-content-input{position:absolute;margin-top: 50px;width:90px; }
.product-content-input label {  display: none;}
</style>

<div class="row">
<div class = "gallery-contenedor-fp">
<?php $indice=0;
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');?>
<?php foreach ($articulos as $articulo): ?>
<div class="container-f">
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddoferta'],'name'=>'carritosoferta','id'=>'carritosoferta']); ?>
<?php //echo $this->Form->input('cantidad',['type'=>'hidden','value'=>$articulo['descuentos']['0']['uni_min']]);
echo $this->Form->input('articulo_id',['type'=>'hidden','value'=>$articulo['id']]);
echo $this->Form->input('precio_publico',['type'=>'hidden','value'=>$articulo['precio_publico']]);
echo $this->Form->input('descripcion',['type'=>'hidden','value'=>$articulo['descripcion_sist']]);
echo $this->Form->input('categoria_id',['type'=>'hidden','value'=>$articulo['categoria_id']]);
echo $this->Form->input('compra_max',['type'=>'hidden','value'=>$articulo['compra_max']]);
if ($articulo['descuentos']['0']['tipo_venta']=='D')
{
echo $this->Form->input('descuento',['type'=>'hidden','value'=>$articulo['descuentos']['0']['dto_drogueria']]); 	
echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>$articulo['descuentos']['0']['plazo']]); 	
echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>$articulo['descuentos']['0']['uni_min']]); 	
echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>$articulo['descuentos']['0']['tipo_oferta']]); 
echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>$articulo['descuentos']['0']['tipo_venta']]); 
echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>$articulo['descuentos']['0']['tipo_precio']]); 
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
?>	
<div class= "imagen-f" style="height:200px;">
<div class="imagen-f-imagen" style="height:200px;" >
<?php echo $this->Html->image('productos/'.$articulo['imagen'], ['class'=>'imagen-f-imagen','alt' => str_replace('"', '', $articulo['descripcion_sist']),'style'=>"width:100%"]);?> 
</div>
<div class="imagen-f-descripcion">
<?php echo str_replace('"', '', $articulo['descripcion_sist']); ?>
</div>
<div class="imagen-f-oferta">
<?php if ($articulo['descuentos']['0']['dto_drogueria']!=null)	echo $this->Html->image('ofertaeti4.png', ['alt' => 'oferta']);
?> 							
</div>
<div class="imagen-f-porcentaje">
<?php if ($articulo['descuentos']['0']['dto_drogueria']!=null )
{
	echo '<div class="f-descuento">'.round($articulo['descuentos']['0']['dto_drogueria']).'</div>';
	echo '<div class="f-porcentaje">%</div>';
}
?>
</div>
</div>
<div class="middle-f">
<div class="product-content-oferta1">
<h5 class="product-content-oferta-descripcion">						
<?php echo $this->Form->submit($articulo['descripcion_sist'],['class'=>'descripcion_label']);?>
</h5>
<span class="product-content-oferta-priciof">
<?php echo 'Precio Regular: $'.number_format(round(h($articulo['precio_publico'])*$descuento_pf, 3),2,',','.'); 
//echo 'Precio F. '.$this->element('precio_farmacia',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef] );?>
<br>
<?php 
$precio_con_dcto=0;
if ($articulo['descuentos']!=null){ 				
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
	$descuentooferta = $articulo['descuentos'][0]['dto_drogueria'];
	$precio = $articulo['precio_publico'];
	if ($articulo['descuentos'][0]['tipo_precio']=='P')
	{
		$precio -=$precio*($descuentooferta/100);
	}
	if ($articulo['descuentos'][0]['tipo_precio']=='F')
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
<span class="product-content-oferta-detalle">
<?php
/*if ($articulo['descuentos']['0']['dto_drogueria']!=null)
if ($articulo['aplicaen']>1)
{
echo 'Oferta: '.$articulo['dto_drogueria']*$articulo['aplicaen'].'% en la 2da unidad - Min :'.$articulo['uni_min'] . ' U </br>'; 
}
else*/
echo 'Oferta: '.$articulo['descuentos']['0']['dto_drogueria'].'% por '.$articulo['descuentos']['0']['uni_min'].' u</br>';
if ($articulo['descuentos']['0']['plazo']!=null)
echo 'Plazo: '. $articulo['descuentos']['0']['plazo'].'</br>';
/*
if ($articulo['descuentos']['0']['tipo_oferta']!=null)
echo 'Tipo de oferta: '. $articulo['descuentos']['0']['tipo_oferta'].'</br>';*/
?>
</span>
<div class=product-content-input>

<?php 
echo $this->Form->input('cantidad',['value'=>$articulo['descuentos']['0']['uni_min']]);
//echo $this->Form->input('cantidad',['value'=>$articulo['descuentos']['0']['uni_min'],'data-id' => $articulo['id'],'data-pv-id'=> $articulo['descuentos'][0]['id'],'class'=>'formcartcant']); 
?>
</div> 
</div> 	
<div class="product-content-oferta2">
<?php echo $this->Form->submit('agregarcarro2.png', ['type'=>'image']);?> 
</div>
</div>
  <?= $this->Form->end() ?>
</div>
<?php endforeach; ?>
</div>
</div>