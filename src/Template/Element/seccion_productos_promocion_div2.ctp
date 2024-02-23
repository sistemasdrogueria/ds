<?php 
echo $this->Html->css('seccion_productos_promocion.min.css');
echo $this->Html->css('owl.carousel.min.css');
echo $this->Html->script('owl.carousel');
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');?>
<h3><?php echo $titulo_seccion?></h3>
<div class="owl-carousel owl-theme">
<?php foreach ($ofertasProms as $oferta): ?>
<?php if ($oferta['oferta_tipo_id'] == $tipo_off)
    {
?>
<div class="item">
<div class="gallery-cell"> <!-- -->
<div class="product-item-4"> <!-- -->
<div class="product-thumb sn-borde">  
<?php echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['busqueda'],$oferta['detalle']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);?> 
</div> 
<div class="product-content-oferta1"> <!-- -->
<span class="descripcion">

</span>
</div> 	<!-- -->
</div> <!-- -->
</div> <!-- -->
</div> <!-- -->

<?php } endforeach; ?>

<?php foreach ($ofertasArts as $oferta): 

if ($oferta['oferta_tipo_id'] == $tipo_off)
{
  if ($oferta['oferta_tipo_id'] == $tipo_off)
    {
?>
<div class="item">
<div class="gallery-producto-promocion">

<?= $this->Form->create('Carritos',['url'=>['controller'=>'#','action'=>'#'],'id'=>'carritosoferta','onsubmit'=>'return false;']); ?>

<?php /*class="product-item-6" */?>
<div >
<div class="product-thumb sn-borde" style="padding: 0px;">

<?php 
if  ($oferta['oferta_tipo_id']==12 || $oferta['oferta_tipo_id']==17 ||$oferta['oferta_tipo_id']==18 ||$oferta['oferta_tipo_id']==16)
echo $this->Html->image('ofertas/'.$oferta['imagen'], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
//else
//echo $this->Html->image('productos/'.$oferta['articulo']['imagen'], ['alt' => str_replace('"', '', $oferta['descripcion'])]);

echo '</div> ';

if  ($oferta['oferta_tipo_id']==12 || $oferta['oferta_tipo_id']==18 ||$oferta['oferta_tipo_id']==16)
{
  /*
echo '<div class="product-promotion-poster-discount-fondo">';
if (!empty($oferta['articulo']['descuentos']))
if ($oferta['aplicaen']>1)
echo $this->Html->image('ofertaeti5.png', ['alt' => 'oferta','class'=>'offparpadea']);
else
echo $this->Html->image('ofertaeti4.png', ['alt' => 'oferta']);
echo '</div>';

if ($oferta['aplicaen']<2)
echo '<div class="product-promotion-poster-discount1">';
else
echo '<div class="product-promotion-poster-discount2">';

if (!empty($oferta['articulo']['descuentos'])){
if ($oferta['aplicaen']>1){
    $descuento = $oferta['articulo']['descuentos'][0];    
$valoroferta = $descuento['dto_drogueria']*$oferta['aplicaen'];
if (round($valoroferta)<100){
echo '<div class="product-promotion-poster-discount-perce">%</div>';
echo '<div class="product-promotion-poster-discount-value">'.round($valoroferta).'</div>';
}
else
{
if ($oferta['aplicaen']==2)
echo '<div class="product-promotion-poster-discount-perce-x offparpadea" style=" margin-top: 5px; font-size: 35px;">2x1</div>';
if ($oferta['aplicaen']==3)
echo '<div class="product-promotion-poster-discount-perce-x" style=" margin-top: 5px; font-size: 35px;">3x2</div>';
if ($oferta['aplicaen']==4)
echo '<div class="product-promotion-poster-discount-perce-x" style=" margin-top: 5px; font-size: 35px;">4x3</div>';
if ($oferta['aplicaen']==5)
echo '<div class="product-promotion-poster-discount-perce-x" style=" margin-top: 5px; font-size: 35px;">5x4</div>';
}
}
else
{
    $descuento = $oferta['articulo']['descuentos'][0]; 
	$valoroferta =0;
echo '<div class="product-promotion-poster-discount-perce">%</div>';
echo '<div class="product-promotion-poster-discount-value">'.round($descuento['dto_drogueria']).'</div>';
}
}
else
$valoroferta =0;
echo '</div>';


echo '<div class="product-promotion-poster-discount-text">';
  
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
  
echo '</div>';*/
}
?>




  <span class="product-promotion-name"><?php echo str_replace('"', '', $oferta['descripcion']);	?> </span>
<span class="product-promotion-stock"> <b>Stock </b> 
<?php
											switch ($oferta['articulo']['stock']) {
												case 'B':
													echo $this->Html->image('bajo.png', ['title' => 'Stock Bajo, Consultar Operadora', 'value' => 2]);
													break;
												case 'F':
													echo $this->Html->image('falta.png', ['title' => 'Producto en Falta', 'value' => 3]);
													break;
												case 'S':
													echo $this->Html->image('alto.png', ['title' => 'Stock Habitual', 'value' => 1]);
													break;
												case 'R':
													echo $this->Html->image('restrin.png', ['title' => 'Producto sujeto a stock', 'value' => 4]);
													break;
												case 'D':
													echo $this->Html->image('descont.png', ['title' => 'Producto Discontinuo', 'value' => 5]);
													break;
											}
											?></td>
 </span>
<div class="product-promotion-discount">
  <?php
  if (!empty($oferta['articulo']['descuentos']))
  {
      $descuento = $oferta['articulo']['descuentos'][0];
  if ($oferta['aplicaen']>1)
  {
  if ($oferta['aplicaen']==2)
  echo $descuento['dto_drogueria']*$oferta['aplicaen'].'% en la 2da unidad - Min :'.$oferta['unidades_minimas'] . ' U '; 
  if ($oferta['aplicaen']==3)
  echo $descuento['dto_drogueria']*$oferta['aplicaen'].'% en la 3ra unidad - Min :'.$oferta['unidades_minimas'] . ' U '; 
  if ($oferta['aplicaen']==4)
  echo $descuento['dto_drogueria']*$oferta['aplicaen'].'% en la 4ta unidad - Min :'.$oferta['unidades_minimas'] . ' U '; 
  if ($oferta['aplicaen']==4)
  echo $descuento['dto_drogueria']*$oferta['aplicaen'].'% en la 5ta unidad - Min :'.$oferta['unidades_minimas'] . ' U'; 
  }
  else
  {

    
    if ($oferta['unidades_minimas']>1) 
    {
    $UM = $oferta['unidades_minimas'];
    echo '<div class=product-promotion-discount-porc-um>'.$UM.'</div><div class=product-promotion-discount-porc-um-m>U.M</div><div class=product-promotion-discount-porc>'.$descuento['dto_drogueria'].'%</div>';

    }
    else
    echo '<span class=product-promotion-discount-porc>'.$descuento['dto_drogueria'].'%</span>';
  }

  if ($descuento['plazo']!=null)  
  if (trim($descuento['plazo'])!="HABITUAL")
    echo ' - '. $descuento['plazo'];
  }
  ?>
  </div>

  <span class=product-promotion-price>
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
      
      if ($precio_con_dcto!=0) 
      {
     
      echo '<span class=price_regular> $ '.number_format(round($precio_con_dcto, 3),2,',','.').'</span>'; 
      echo '<span class=price_regular_tach> $'.number_format(round(h($oferta['articulo']['precio_publico'])*$descuento_pf, 3),2,',','.').'</span>'; 
      }
      else
      echo '<span class=price_regular> $'.number_format(round(h($oferta['articulo']['precio_publico'])*$descuento_pf, 3),2,',','.').'</span>'; 
      ?>
  </span>


<?php if (isset( $oferta['articulo']['descuentos'][0]['id'])) {
  if ($oferta['articulo']['descuentos'][0]['tipo_venta']==='D')
    $descuentos =  $oferta['articulo']['descuentos'][0]['id'];
    else 
    $descuentos=0;   
   }else{

       $descuentos=0;   
   }
   ?>
    <div class="product-promotion-button-mas-menos">
     		<div class=carrito_item_cantidad_3>
           	<button class="btn btn-sm suma"   style="background-color:#1b2340;color:#fff;width:28px;"onclick="incrementOfertas(<?php echo $oferta['articulo_id']; ?>,<?php echo $descuentos; ?>,<?php echo $oferta['articulo_id']; ?>)">+</button>
						<?php
						echo $this->Form->input('ofert'.$oferta['articulo_id'].'', ['tabindex' =>'', 'value' => $oferta['unidades_minimas'], 'data-pv-id' => $descuentos, 'data-id' => $oferta['articulo_id'], 'class' => 'formcarritocan  text-center', 'onkeypress' => 'return soloNumeros(event)', 'style'=>'background-color:#1b2340;color:#fff;height: 40px; border-right: 1px solid #ddd!important;border-left: 1px solid #ddd!important;width:30px;', 'maxlength' => '3']);
						?>
            						<button class="btn btn-sm resta " style="background-color:#1b2340;color:#fff;width:28px;border-radius:4px;" onclick="decrementOfertas(<?php echo $oferta['articulo_id']; ?>,<?php echo $descuentos; ?>,<?php echo $oferta['articulo_id']; ?>)">-</button>

					</div>
<button type="submit" class="product-promotion-button-submit-mas-menos" data-value='<?php echo $oferta['unidades_minimas']; ?>'; value="" id="oferta<?php echo $oferta['articulo_id'] ?>" tabindex="" data-id-input="tab" data-id=" <?php echo $oferta['articulo_id']; ?> " data-pv-id='<?php echo $descuentos; ?>' onclick=incrementCarritosMes(<?php echo $oferta['articulo_id']; ?>,<?php echo $descuentos; ?>,<?php echo $oferta['articulo_id']; ?>); onsubmit="return false;">AGREGAR</button>
</div> 


</div>


</div>
</div>
<?= $this->Form->end() ?>	
<?php 
}
}?>
<?php endforeach; ?>
</div>

<script>
$(document).ready(function() {
var owl = $('.owl-carousel');
if (window.innerWidth > 768) {
    // Then log this message to the console
   media=1;
  }else{
    media=4;
  }
owl.owlCarousel({
rtl: true,
margin: 10,
nav: true,
loop: true,
items:media,
/*autoplay:true,
autoplayTimeout:2000,
autoplayHoverPause:true,*/
autoplay:<?php if ($autoplay==1) echo 'true'; else echo 'false'; ?>,
autoplayTimeout: 2000,
autoplayHoverPause:<?php if ($autoplay==1) echo 'true'; else echo 'false'; ?>,
responsive: {
0: {
items: 1
},
600: {
items: 2
},
900: {
items: 3
},
1000: {
items: 4
},
1100: {
items: 4
},
1300: {
items: 5
},
1300: {
items: 5
},
1500: {
items: 6
},
1700: {
items: 7
},
1900: {
items: 8
}
}
});
})
</script>