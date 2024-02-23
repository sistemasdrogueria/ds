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
?>
<?php foreach ($articulos as $articulo): ?>
<div class="gallery-producto-promocion" >
<div class="product-item-6"   style=" width: 230px;" >
<div class=product-promo-img>
<?php echo $this->Html->image('productos/'.$articulo['imagen'], ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFoto']);?>
</div>
<?php
if ($articulo['nuevo'])
    echo $this->Html->image('icon_nuevo.png', ['alt' => 'nuevo','style'=>"float: left;
    margin-top: -220px;
    z-index: 50;
    margin-left: 150px;
    position: relative;"]);
?>
  <span class="product-promo-name"><?php echo str_replace('"', '', $articulo['descripcion_sist']);	?> </span>

  <span class="product-promo-discount">
  <?php
  if (!empty($articulo['descuentos']))
  {  
    
      $descuento = $articulo['descuentos'][0];
      if ($descuento['tipo_venta']=='D' && $descuento['tipo_oferta']=="TL" )   
          $descuento = $articulo['descuentos'][1];

    if ($descuento['tipo_venta']=='D')
      {
      $descuento_off = $descuento['dto_drogueria'];
    if ($descuento['tipo_oferta']=="TH")
    {
      $descuento_off+=$condiciongeneral;
    }

  echo '<div class=product-promo-discount-num>'.number_format(round($descuento_off, 3),2).'% </div><div class=product-promo-discount-off>  OFF</div>';
  if ($descuento['uni_min']>1)
  echo '<span class="product-promo-discount-um">'.$descuento['uni_min'].' U.M.</span>';
  }
  }
  ?>
  </span>
  
  <span class=product-promo-price>
    <?php 
 
      $precio_con_dcto=0;
      if (!empty($articulo['descuentos'])){
          $descuento = $articulo['descuentos'][0];
          if ($descuento['tipo_venta']=='D' && $descuento['tipo_oferta']=="TL" )   
          $descuento = $articulo['descuentos'][1];
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
          $precio = $precio*$descuento_pf;
          
          $precio -=$precio*($descuento_off/100);
        }	
        $precio_con_dcto = $precio;
      }	
      }
      
      $precio_farmacia = $articulo['precio_publico']*$descuento_pf;

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
  {   
      $descuento_id = $articulo['descuentos'][0]['id'];
      if ($articulo['descuentos'][0]['tipo_venta']=='D' && $articulo['descuentos'][0]['tipo_oferta']=="TL" )   
      $descuento_id = $articulo['descuentos'][1]['id'];
     
  }
      else
     $descuento_id =0; 

$indice++;
echo $this->Form->input('cantidad',['tabindex'=>$indice,'id'=>'tab'.$indice,'value' =>$cantidadencarrito/*,'id' => 'cart-cant'*/,'class'=>'formcartcant','target'=>'_blank','data-id-input'=>'tab'.$indice, 'data-id' => $articulo['id'],'data-pv-id'=> $descuento_id,  'autocomplete'=>'off' , 'style'=>'padding: 5px 5px; width:40px;']);

?>
<?= $this->Form->end(); ?>
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