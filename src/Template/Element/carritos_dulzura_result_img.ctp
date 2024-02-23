
<script>

$(document).ready(function(){

$(".formcartcant").change(function(){
 
 	var quantity = Math.round($(this).val());
	 ajaxcart($(this).attr("data-id"), quantity,$(this).attr("data-pv-id"));


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


$(".remove").each(function() {
	$(this).replaceWith('<a class="remove" id="' + $(this).attr('id') + '" href="' + Shop.basePath + 'shop/remove/' + $(this).attr('id') + '" title="Remove item"><img src="' + Shop.basePath + 'img/icon-remove.gif" alt="Remove" /></a>');
});

$(".remove").click(function() {
	ajaxcart($(this).attr("id"), 0);
	return false;
});

function ajaxcart(id, quantity, pv_id) {

	$.ajax({
		type: "POST",
		url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'itemupdate')); ?>",
		data: {
			id: id,
			quantity: quantity, 
			preventa_id: pv_id
		},
		dataType: "json",
		success: function(data, textStatus) {
			
			$.each(data.carro, function(key, value) {
                    /*if($('#subtotal-' + key).html() != "$" + value.subtotal) {
                        $('#quantity-' + key).val(value.quantity);
                        $('#subtotal-' + key).html("$" + value.subtotal).animate({ backgroundColor: "#ff8" }, 100).animate({ backgroundColor: 'transparent'}, 500);
					} */
					if (key == "articulo_id")
					    {stri = 'data-id='+ value; 

							//var selc = document.querySelector('[date-id="'+value+'"]');
							
							//selc.val = 5;
					}
                    // console.log(value);
				});
				
				
		
		},
		error: function(textStatus) {
			console.log(textStatus);
			//window.location.replace("/products/clear");
		}
	});
}

});
</script>

<style>
.product-promotion-poster-discount-fondo{float:left;margin-top:-190px;z-index:100;margin-left:120px}
.product-promotion-poster-discount1{float:left;margin-top:-170px;z-index:150;color:#fff;margin-left:129px}
.product-promotion-poster-discount2{float:left;margin-top:-170px;z-index:150;color:#fff;margin-left:135px}
.product-promotion-poster-discount-perce{float:right;font-size:18px;font-weight:700;margin-right:15px}
.product-promotion-poster-discount-value{float:right;font-size:28px;font-weight:700}
.product-promotion-discount{width:100%;float:left;text-align: center; min-height:35px;font-weight:bold; color: red; font-size: 16px;}
.product-promotion-discount-um{float:right;min-height:35px;font-weight:bold ;  margin-top: -25px;}
.product-promotion-name{width:100%;float:left;min-height:45px;  color: #000; text-align: center; font-size: 12px  ;  font-weight:bold; }
.product-promotion-price{width:100%;float:left;min-height:30px;font-size:18px}
.gallery-producto-promocion{min-height:350px;min-height:30px; display:inline-block; background-color: #fff; color: #000; margin: 5px 5px 5px 5px;}
.product-promotion-button{right:0;-webkit-backface-visibility:hidden;backface-visibility:hidden;font-size:18px}
.product-promotion-cant{width:100%;  float: left;}
.product-promotion-cant-um {width:100%; height: 40px; margin-top: 10px; margin-bottom: 5px; float: left;}
.product-promotion-discount-num{font-size:18px; display: inline}
.product-promotion-discount-off{ display: inline }
.product-promotion-combo{width:100%;float:left;min-height:30px;  color: #000; text-align: center; font-size: 12px  ; margin-top: 5px; font-weight: bold;text-decoration: underline;   }
/*.product-promotion-button-submit{width:100%;padding:8px 8px 8px 8px;border:0;outline:0;color:#fff;text-align:center;margin:0 auto;display:block;float:right;background-color:#2d2e35;font-size:18px}*/
.price_regular{font-size:20px;float:right;font-weight:bold;padding-right:10px;}
.imgFoto{cursor: zoom-in;}
.price_regular_tach{text-decoration:line-through;padding-left:10px;padding-right:10px;padding-top: 4px; float:left;font-size:16px}
.price_regular_mayor{font-size:20px;float:right;font-weight:bold;}
.price_regular_mayor_tach{text-decoration:line-through;padding-left:10px;padding-top: 4px; float:left;font-size:16px}
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
<div class="product-item-6">
<span class="product-promotion-combo"><?php 
  if (!empty($articulo['preventas']))   {  $descuento = $articulo['preventas'][0]; echo str_replace('"', '', $descuento['combo']);	}
?> </span>
<div  style="height: 100%; padding: 0px; padding: 5px;">
<?php 

echo $this->Html->image('productos/'.$articulo['imagen'], ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFoto']);
?>
</div>
  <span class="product-promotion-name"><?php echo str_replace('"', '', $articulo['descripcion_sist']);	?> </span>

  <span class="product-promotion-discount">
  <?php
  if (!empty($articulo['preventas']))
  {  $descuento = $articulo['preventas'][0];
  
  echo '<div class=product-promotion-discount-num>'.$descuento['dto_drogueria'].'% </div><div class=product-promotion-discount-off>  OFF</div>';
  

  }
  ?>
  </span>


  <span class=product-promotion-price>
    <?php 
 
      $precio_con_dcto=0;
      if (!empty($articulo['preventas'])){
          $descuento = $articulo['preventas'][0];
      if ($descuento['tipo_venta']=='D')
      {
        $descuentoarticulo = $descuento['dto_drogueria'];
        $precio = $articulo['precio_publico'];
        if ($descuento['tipo_precio']=='P')
        {
          $precio -=$precio*($descuentoarticulo/100);
        }
        if ($descuento['tipo_precio']=='F')
        {
          $precio = $precio*$descuento_pf;
          
          $precio -=$precio*($descuentoarticulo/100);
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
  <div class=product-promotion-cant-um>
<span class="product-promotion-cant">
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddall']]); ?>
<?php

if (!empty($articulo['carritos_preventas']) )
	$cantidadencarrito = $articulo['carritos_preventas'][0]['cantidad'];
else
	$cantidadencarrito ="";
echo $this->Form->input('cantidad',['tabindex'=>$indice,'value' =>$cantidadencarrito,'id' => 'cart-cant','class'=>'formcartcant','target'=>'_blank', 'data-id' => $articulo['id'],'data-pv-id'=> $articulo['preventas'][0]['id'],  'autocomplete'=>'off' , 'style'=>'padding: 1px 1px; width:40px;']);
$indice++;
?>
<?= $this->Form->end(); ?>
</span>
<span class="product-promotion-discount-um">
  <?php
  if ($descuento['uni_min']>1)
  echo $descuento['uni_min'].' U.M.';
  else
  if (!empty($descuento['combo_id']))
  {
     if ($descuento['combo_id']<5) echo "FAMILIA ".$descuento['combo_id'];
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