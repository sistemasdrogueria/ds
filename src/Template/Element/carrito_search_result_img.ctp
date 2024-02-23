<style>.imgFotoReyes{ width: 40px; position: absolute; margin-left: -200px; margin-top: 20px;}
.parpad { animation-name: parpadeo; animation-duration: 2s;  animation-timing-function: linear;animation-iteration-count: infinite;-webkit-animation-name:parpadeo;-webkit-animation-duration: 2s;-webkit-animation-timing-function: linear;-webkit-animation-iteration-count: infinite;}
@-moz-keyframes parpadeo{ 0% { opacity: 1.0; }50% { opacity: 0.0; }100% { opacity: 1.0; }}
@-webkit-keyframes parpadeo { 0% { opacity: 1.0; }50% { opacity: 0.0; }100% { opacity: 1.0; }}
@keyframes parpadeo {  0% { opacity: 1.0; }50% { opacity: 0.0; }100% { opacity: 1.0; }}


</style>
<div class="row" style ="text-align: center;">
<div class = "gallery-contenedor"    style="margin:0px auto;">
<?php 
$titulolab=0; $preciot=""; 
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');
$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
$condiciongeneralmsd = 100*(1-($descuento_pf));
$condiciongeneralcf = 100*(1-($descuento_pf *1.0248* (1-$condicion/100)));
$condiciongeneralaz = 100*(1-($descuento_pf *0.892));
$indice =1;
$coef_pyf = $this->request->session()->read('Auth.User.coef_pyf');
?>
<?php foreach ($articulos as $articulo): ?>
<div class="gallery-producto-promocion" >
<div class="product-item-6"   style=" width: 230px;" >
<div class=product-promo-img>
<?php echo $this->Html->image('productos/'.$articulo['imagen'], ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFoto','loading'=>'lazy' , 'style'=>'max-height:200px']);?>
</div>
<?php
if ($articulo['nuevo'])
echo $this->Html->image('icon_nuevo.png', ['alt' => 'nuevo','style'=>"float: left;margin-top: -220px; z-index: 50; margin-left: 150px;  position: relative;"]); ?>
<span class="product-promo-name"><?php echo str_replace('"', '', $articulo['descripcion_pag']);	?> </span>

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
if ($articulo["id"]== 19940)
echo $this->Html->image('MELCHOR.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes']);
if ($articulo["id"]== 2033)
echo $this->Html->image('GASPAR.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes']);
*/if ($articulo["id"]== 47965)
echo $this->Html->image('BALTAZAR.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes']);
/*if ($articulo["id"]== 24650)
echo $this->Html->image('PAPA-NOEL.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes']);

if ($articulo["id"]== 16781){

echo $this->Html->image('CORAZON-ROJO.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imagen dia de los enamorados', 'width'=>50])

}
*/
if ($articulo["fv_cerca"])
{
    echo 'VENCIMIENTO: '.$articulo["fv"];
}

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
if (!empty($articulo['descuentos']))
{if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
$descuento_id = $articulo['descuentos'][0]['id'];
}
else
$descuento_id =0; 
}
else
$descuento_id =0; 

echo $this->Form->input('cantidad',['tabindex'=>$indice,'value' =>$cantidadencarrito,'id' => 'cart-cant','class'=>'formcartcant','target'=>'_blank', 'data-id' => $articulo['id'],'data-pv-id'=> $descuento_id,  'autocomplete'=>'off' , 'style'=>'padding: 5px 5px; width:40px;']);
$indice++;
?>
<?= $this->Form->end(); ?>
</span>
<span class=product-promo-stock>
<?php
echo 'Stock ';
switch ($articulo['stock']) {
case 'B': echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora','value' => 2] );	break;
case 'F': echo $this->Html->image('falta.png',['title' => 'Producto en Falta','value' => 3]);				break;
case 'S': echo $this->Html->image('alto.png',['title' => 'Stock Habitual','value' => 1]);break;
case 'R': echo $this->Html->image('restrin.png',['value' => 4]);echo '<div class="overlay" style="color:#f1f1f1;">Compra Restringida, Máx '.$articulo['restringido_unid'].' Uni</div>'; break;
case 'D': echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo','value' => 5]);break;
}
?>
</span>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
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