<style>.imgFotoAmigo{width: 80px; position: absolute; margin-left: -250px; margin-top: 40px;}
</style>
<?php 
$titulolab=0; $preciot=""; 
$grupos=$grupos->toArray();
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');
$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
$condiciongeneralmsd = 100*(1-($descuento_pf));
$condiciongeneralcf = 100*(1-($descuento_pf *1.0248* (1-$condicion/100)));
$condiciongeneralaz = 100*(1-($descuento_pf *0.892));
$indice=0;
$coef_pyf = $this->request->session()->read('Auth.User.coef_pyf');
$terminobuscar= 0;
$marca_id=0;
$grupo_id=0;
?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'#'],'id'=>'formaddcart','onsubmit'=>'return false;']); ?>
<div class=dermocontenedorajust>
<div class="dermocontenedor">
<?php foreach ($result as $articulo): ?>
<?php 
$descuento=0; 
if (isset($articulo['descuentos'][0]['id'])) {
if ($articulo['descuentos'][0]['tipo_venta']=='D')
$descuento = $articulo['descuentos'][0]['id'];
else
{
$descuento=0;   
if (count($articulo['descuentos'])>1)
{
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
$descuento = $articulo['descuentos'][1]['id'];
}  
} 

}
}
?>
<div class="dermodiv">
<div class="dermoimagen" align="center">
<?php 
$uploadPath = 'productos/';
if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$articulo['imagen'] ))
echo $this->Html->image($uploadPath.$articulo['imagen'], ['alt' => str_replace('"', '', $articulo['descripcion_pag']),'class'=>'imgFoto']);
else
echo $this->Html->image($uploadPath.$articulo['imagen'], ['alt' => str_replace('"', '', $articulo['descripcion_pag']),'class'=>'imgFoto']); 
?> 
</div> 
<div class='dermomarca'>
<?php if ($articulo['grupo_id'] !=1)
if(array_key_exists($articulo['grupo_id'],$grupos)){
echo $grupos[$articulo['grupo_id']];
}
else
echo $grupos[65]; ?>
</div>	
<div class='dermodescrip'>
<div class=dermodescrip_text><?= $articulo['descripcion_pag'] ?></div>
</div>
<?php
if ($articulo['nuevo'])
echo $this->Html->image('icon_nuevo.png', ['alt' => 'nuevo','style'=>"float: left;margin-top: -220px; z-index: 50; margin-left: 150px;  position: relative;"]); ?>


<?php
echo '<span class="product-promo-discount">';
if (!empty($articulo['descuentos']))
{  $descuento = $articulo['descuentos'][0];

if ($descuento['tipo_venta']=='D')
{
$descuento_off = $descuento['dto_drogueria'];
if ($descuento['tipo_oferta']=="TH")
{
$descuento_off+=$condiciongeneral;
}

echo $this->Html->image('etiqueta_off2.png', ['alt' => 'nuevo','style'=>"float: left;margin-top: -280px; z-index: 150; margin-left: -5px;  position: relative;"]); 
echo '<div class=product-promo-discount-num style= "color: #fff !important; float: left;margin-top: -238px; z-index: 155; margin-left: 60px;  position: relative;">'.number_format(round($descuento_off, 3),2).'% </div>';
if ($descuento['uni_min']>1)
{
echo '<span class="product-promo-discount-um">'.$descuento['uni_min'].' U.M.</span>';
}
}
}
echo '<span class=product-promo-price-public>';
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3))
{
if ($articulo['iva']==0) 
echo '<div class="product-promo-discount-num parpad" style= "color: #2a6496 !important; float: left; z-index: 155; margin-left: 60px;  position: relative;font-size:17px !important;">'.
'PP $ '.number_format($articulo['precio_publico'],2,',','.').'</div>';
}
else
{
if ($articulo['id']>27338 && $articulo['id']<27345)
$descuento_pf =0.807;

$precio = $articulo['precio_publico']*$descuento_pf;
if ($coef !=1)	$precio = $precio*$coef;
$precio_con_dcto = $precio *1.21* $coef_pyf;
if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420) 				
{
$precio_con_dcto = $precio_con_dcto *$articulo['tf_coef'];
}
echo '<div class="product-promo-discount-num parpad" style= "color: #2a6496 !important; float: left; z-index: 155; margin-left: 60px;  position: relative; font-size:17px !important;">'.
'PP $ '.number_format($precio_con_dcto,2,',','.').'</div>';
} 
echo '</span>';
echo '</span>';
?>
<?php 
/*
  if ($articulo["id"]== 19072)
  echo $this->Html->image('6-Pezzella.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoAmigo']);
  if ($articulo["id"]== 19688)
  echo $this->Html->image('MELCHOR.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes']);
  if ($articulo["id"]== 21098)
  echo $this->Html->image('GASPAR.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes']);
  if ($articulo["id"]== 34266)
  echo $this->Html->image('BALTAZAR.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes']);

 if ($articulo["id"]== 51320)
echo $this->Html->image('CORAZON-VERDE.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes','width'=>50]);
 */
  ?>
<span class=product-promo-price>
<?php 

$precio_con_dcto=0;
if (!empty($articulo['descuentos'])){
$descuento = $articulo['descuentos'][0];
if ($descuento['tipo_venta']=='D')
{
$descuento_off = $descuento['dto_drogueria'];
$precio = $articulo['precio_publico'];
if ($descuento['tipo_precio']=='P')
{
if ($descuento['tipo_oferta']=="TH")
{
$descuento_off+=$condiciongeneral;
}
$precio -=$precio*($descuento_off/100);
}
if ($descuento['tipo_precio']=='F')
{
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3) &&($articulo['categoria_id'] !=2))
{
$precio = $precio*$descuento_pf;
if ($articulo['iva'] ==1)
if ($this->request->session()->read('Auth.User.codigo_postal')!=9410 && $this->request->session()->read('Auth.User.codigo_postal')!=9420) 	
{					
$precio = $precio/(1.21);
}
if ($articulo['msd']!=1)
$precio -= $precio*$condicion/100;

$precio -=$precio*($descuento_off/100);

if ($precio!=0 && $articulo['cadena_frio']==1 && $articulo['subcategoria_id']!=10)
$precio = $precio*1.0248;

}
else
{
$precio = $precio*$descuento_pf;
$precio -=$precio*($descuento_off/100);
}
}	
$precio_con_dcto = $precio;
}	
}   
if ($articulo['categoria_id']!=1 && $articulo['categoria_id']!=6 && $articulo['categoria_id']!=7)
$precio_farmacia = $articulo['precio_publico']*$descuento_pf;
else
{
$precio = $articulo['precio_publico'];
$precio = $precio*$descuento_pf;
if ($condicion >0 ) 
$precio -= $precio*$condicion/100;
if ($precio!=0 && $articulo['cadena_frio']==1 && $articulo['subcategoria_id']!=10)
$precio = $precio*1.0248;
$precio_farmacia = $precio;

}

if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420) 				
{
$precio_farmacia = $precio_farmacia *$articulo['tf_coef'];;
if ($precio_con_dcto!=0) 
$precio_con_dcto = $precio_con_dcto*$articulo['tf_coef'];;
}
if ($precio_con_dcto!=0) 
{
if ($precio_farmacia<10000)
{echo '<span class=price_regular> $ '.number_format(round($precio_con_dcto, 3),2,',','.').'</span>'; 
echo '<span class=price_regular_tach> $'.number_format(round($precio_farmacia, 3),2,',','.').'</span>'; 
}
else
{
echo '<span class=price_regular_mayor> $ '.number_format(round($precio_con_dcto, 3),2,',','.').'</span>'; 
echo '<span class=price_regular_mayor_tach> $'.number_format(round($precio_farmacia, 3),2,',','.').'</span>'; 
}

}
else
if ($precio_farmacia<10000)
echo '<span class=price_regular> $'.number_format(round($precio_farmacia, 3),2,',','.').'</span>'; 
else
echo '<span class=price_regular_mayor> $'.number_format(round($precio_farmacia, 3),2,',','.').'</span>'; 

?>
</span>

<div class=product-promo-cant-um>
<span class="product-promo-cant">
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'#'],'id'=>'formaddcart'.$indice,'onsubmit'=>'return false;']); ?>
<?php

if (!empty($articulo['carritos']) )
$cantidadencarrito = $articulo['carritos'][0]['cantidad'];
else
$cantidadencarrito ="";
if (!empty($articulo['carritos']) )
$cantidadencarrito = $articulo['carritos'][0]['cantidad'];
else
$cantidadencarrito ="";

$descuento_id=0;  
if (!empty($articulo['descuentos']))
{
if ($descuento['tipo_venta']=='D')
$descuento_id = $articulo['descuentos'][0]['id'];
else
{
if (count($articulo['descuentos'])>1)
{
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
$descuento_id = $articulo['descuentos'][1]['id'];
}  
} 
}
}

echo $this->Form->input('cantidad',['tabindex'=>$indice,'value' =>$cantidadencarrito,'id' => 'cart-cant','class'=>'formcartcant','target'=>'_blank', 'data-id' => $articulo['id'],'data-pv-id'=> $descuento_id,  'autocomplete'=>'off' , 'style'=>'padding: 5px 5px; width:40px;']);
$indice++; 
$this->Form->end(); ?>
</span>
<span class=product-promo-stock>
<?php
echo 'Stock ';
switch ($articulo['stock']) {
case 'B': echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora','value' => 2] );	break;
case 'F': echo $this->Html->image('falta.png',['title' => 'Producto en Falta','value' => 3]);				break;
case 'S': echo $this->Html->image('alto.png',['title' => 'Stock Habitual','value' => 1]);					break;
case 'R': echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock','value' => 4]);		break;
case 'D': echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo','value' => 5]);			break;
}
?>
</span>
</div>


</div>
<?php endforeach; ?>

</div><?= $this->Form->end() ?>
<!--/div -->
</div>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>

</div>

<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">       
<img src="" class="enlargeImageModalSource" style="width: 100%;">       
</div>
</div>
</div>
</div>

<?php 
	echo $this->Html->script('buscador');
	?>
    
    <?php
echo $this->Html->script('paginacion');
?>

<script>
$(function() {
$('.imgFoto').on('click', function() {
var str =  $(this).attr('src');
//alert (str);
//var str = str.replace("foto.png", "productos/"+$(this).data("id"));
var res = str.replace("productos/", "productos/big_");
var a = new XMLHttpRequest;
a.open( "GET", res, false );
a.send( null );
if (a.status === 404)
{
var res =  $(this).attr('src');
//var res = res.replace("foto.png", "productos/"+$(this).data("id"));
}			
//var res =  $(this).attr('src');
$('.enlargeImageModalSource').attr('src',res);
$('#enlargeImageModal').modal('show');
});
});
</script>