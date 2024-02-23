<style>
.product-promotion span{    color: #000;}
.product-promo-poster-discount-fondo{float:left;margin-top:-190px;z-index:100;margin-left:120px}
.product-promo-poster-discount1{float:left;margin-top:-170px;z-index:150;color:#fff;margin-left:129px}
.product-promo-poster-discount2{float:left;margin-top:-170px;z-index:150;color:#fff;margin-left:135px}
.product-promo-poster-discount-perce{float:right;font-size:18px;font-weight:700;margin-right:15px}
.product-promo-poster-discount-value{float:right;font-size:28px;font-weight:700}
.product-promo-discount{width:100%;float:left;text-align: center; min-height:35px;font-weight:bold; color: red !important; font-size: 16px !important;}
.product-promo-discount-um{float:right;min-height:35px;font-weight:bold ;  color: #000 !important}
.product-promo-stock{float:right;min-height:35px;font-weight:bold ;  margin-top: -30px; color: #000 !important}
.product-promo-name{width:100%;float:left;min-height:45px;  color: #000 !important; text-align: center; font-size: 12px !important;  font-weight:bold; }
.product-promo-price{width:100%;float:left;min-height:30px;font-size:18px; color: #000 !important;}
.gallery-producto-promocion{min-height:350px;min-height:30px; display:inline-block; background-color: #fff; color: #000; padding: 10px; margin: 5px;}
.product-promo-button{right:0;-webkit-backface-visibility:hidden;backface-visibility:hidden;font-size:18px}
.product-promo-cant{width:100%;  float: left; color: #000 !important;}
.product-promo-cant-um {width:100%; height: 40px; margin-top: 10px; margin-bottom: 5px; float: left; color: #000 !important;}
.product-promo-discount-num{font-size:18px !important; display: inline; color: #000 !important;}
.product-promo-discount-off{ display: inline }
.product-promo-combo{width:100%;float:left;min-height:30px;  color: #000; text-align: center; font-size: 12px  ; margin-top: 5px; font-weight: bold;text-decoration: underline;   }
/*.product-promo-button-submit{width:100%;padding:8px 8px 8px 8px;border:0;outline:0;color:#fff;text-align:center;margin:0 auto;display:block;float:right;background-color:#2d2e35;font-size:18px}*/
.price_regular{font-size:20px !important;float:right;font-weight:bold;padding-right:10px; color: #000 !important;}
.imgFoto{cursor: zoom-in;}
.product-promo-img{height: 100%; padding: 0px; padding: 15px 15px 15px 15px;}
.price_regular_tach{text-decoration:line-through;padding-left:10px;padding-right:10px;padding-top: 4px; float:left;font-size:16px !important; color: #000 !important;}
.price_regular_mayor{font-size:20px !important;float:right;font-weight:bold; color: #000 !important;}
.price_regular_mayor_tach{text-decoration:line-through;padding-left:10px;padding-top: 4px; float:left;font-size:16px !important; color: #000 !important;}
.enlargeImageModal{z-index: 2000;}
.modal-backdrop {
  z-index: -1;
}
</style>
<div class="row" style ="text-align: center;">
<div class = "gallery-contenedor"    style="margin:0px auto;">
<?php 
$cat = $categorias; $titulolab=0; $preciot=""; 
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
<?php 

echo $this->Html->image('productos/'.$articulo['imagen'], ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFoto']);
?>
</div>
  <span class="product-promo-name"><?php echo str_replace('"', '', $articulo['descripcion_sist']);	?> </span>

  <span class="product-promo-discount">
  <?php
  if (!empty($articulo['descuentos']))
  {  $descuento = $articulo['descuentos'][0];
  
      $descuento_off = $descuento['dto_drogueria'];
    if ($descuento['tipo_oferta']=="TH")
    {
      $descuento_off+=$condiciongeneral;
    }

  echo '<div class=product-promo-discount-num>'.number_format(round($descuento_off, 3),2).'% </div><div class=product-promo-discount-off>  OFF</div>';
  if ($descuento['uni_min']>1)
  echo '<span class="product-promo-discount-um">'.$descuento['uni_min'].' U.M.</span>';

  }
  ?>
  </span>
  
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
          $precio = $precio*$descuento_pf;
          
          $precio -=$precio*($descuento_off/100);
        }	
        $precio_con_dcto = $precio;
      }	
      }
      
      $precio_farmacia = $articulo['precio_publico']*$descuento_pf;
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
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddall']]); ?>
<?php

if (!empty($articulo['carritos']) )
	$cantidadencarrito = $articulo['carritos'][0]['cantidad'];
else
	$cantidadencarrito ="";
  if (!empty($articulo['descuentos']))
      $descuento_id = $articulo['descuentos'][0]['id'];
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