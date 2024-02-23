<script>$(document).ready(function(){
/*
$(".formcartcantx").blur(function(){
 
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
			descuento_id: pv_id
		},
		dataType: "json",
		success: function(data, textStatus) {
			//alert(data);
			console.log(data);
		
		},
		error: function(textStatus) {
			console.log(textStatus);
			//window.location.replace("/products/clear");
		}
	});
}
*/
});
</script>

<div class="row">
<div class = "gallery-contenedor-fp">
<?php $indice=0;
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');


function numberOfDecimals($value)
{
    if ((int)$value == $value)
    {
        return 0;
    }
    else if (! is_numeric($value))
    {
        // throw new Exception('numberOfDecimals: ' . $value . ' is not a number!');
        return false;
    }

    return strlen($value) - strrpos($value, '.') - 1;
}

?>


<?php foreach ($ofertasHOT as $oferta): ?>
<div class="container-f">

 
<div class= "imagen-f" style="height:200px;">
<div class="imagen-f-imagen" style="height:200px;" >

<?php
      if ($oferta['busqueda_sect']!=1)
      {
        if ($oferta['detalle']=='TD')

        //echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['busqueda'],$oferta['detalle'],$oferta['descripcion'],'0']], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
        //else
        echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'hotsale_search',$oferta['busqueda_sect']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
	  
	  }
	  else
	  {
		if ($oferta['detalle']=='TD')

        //echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['busqueda'],$oferta['detalle'],$oferta['descripcion'],'0']], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
        //else
        echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'hotsale_search',$oferta['busqueda_sect']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
	  
	  }
/*		echo $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddoferta'],'name'=>'carritosoferta','id'=>'carritosoferta']); 
		
		echo $this->Form->input('articulo_id',['type'=>'hidden',14114]);
		echo $this->Form->input('precio_publico',['type'=>'hidden','value'=>225]);
		echo $this->Form->input('descripcion',['type'=>'hidden','value'=>'ACTRON 600 X 10 RAPIDA ACCION']);
		echo $this->Form->input('categoria_id',['type'=>'hidden','value'=>1]);
		echo $this->Form->input('compra_max',['type'=>'hidden','value'=>1000]);
		if ($articulo['descuentos']['0']['tipo_venta']=='D')
		{
		echo $this->Form->input('descuento',['type'=>'hidden','value'=>$articulo['descuentos']['0']['dto_drogueria']]); 	
		echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>$articulo['descuentos']['0']['plazo']]); 	
		echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>$articulo['descuentos']['0']['uni_min']]); 	
		echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>$articulo['descuentos']['0']['tipo_oferta']]); 
		echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>$articulo['descuentos']['0']['tipo_venta']]); 
		echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>$articulo['descuentos']['0']['tipo_precio']]); 
		}

		id 14114
		troquel 522991-1
		descripcion_sist ACTRON 600 X 10 RAPIDA ACCION
		descripcion_pag ACTRON 600 X 10 RAPIDA ACCION
		categoria_id 1
		subcategoria_id 1
		codigo_barras 7793640215523
		laboratorio_id 24
		precio_publico 225
		precio_final 225
		stock S
		cadena_frio (false)
		iva (false)
		msd (false)
		clave_amp 20047
		trazable (false)
		pack (false)
		proveedor_id 430
	
	  } 
	 */
	  /*else
          echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['busqueda'],$oferta['detalle'],$oferta['descripcion'],'1']], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
*/


?>
</div>
<div class="imagen-f-descripcion">
<?php echo str_replace('"', '', $oferta['descripcion']); ?>
</div>
<div class="imagen-f-oferta">
<?php 	echo $this->Html->image('HS-OFF2.png', ['alt' => 'oferta']);

?> 							
</div>




<?php

	
	if (numberOfDecimals($oferta['descuento_producto'])>0)
	{
		echo '<div class="imagen-f-porcentaje" style="margin-left:140px;">';
		echo '<div class="f-descuento" style="font-size: 24px;">'.$oferta['descuento_producto'].'</div>';
	}
	else
	{
		echo '<div class="imagen-f-porcentaje">';
		echo '<div class="f-descuento">'.$oferta['descuento_producto'].'</div>';
		echo '<div class="f-porcentaje">%</div>';
	}
	echo '</div>';
?>


</div>


</div>
<?php endforeach; ?>

<?php foreach ($articuloshs as $articulo): ?>
<div class="container-f">
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddoferta'],'name'=>'carritosoferta','id'=>'carritosoferta']); ?>
<?php 
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
echo $this->Form->input('descuento',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>null]); 	
echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>null]); 	
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
<?php if ($articulo['descuentos']['0']['dto_drogueria']!=null)
/*if ($articulo['aplicaen']>1) echo $this->Html->image('ofertaeti5.png', ['alt' => 'oferta']);
	else */
	if ($articulo['descuentos']['0']['dto_drogueria'] == 50) 	
	echo $this->Html->image('HS-OFF4.png', ['alt' => 'oferta']);
	else	
	if ($articulo['descuentos']['0']['dto_drogueria'] == 40) 	
	echo $this->Html->image('HS-OFF80.png', ['alt' => 'oferta']);
	else
	echo $this->Html->image('HS-OFF2.png', ['alt' => 'oferta']);



?> 							
</div>

<?php if ($articulo['descuentos']['0']['dto_drogueria']!=null )

{
/*
if ($articulo['aplicaen']>1)
echo '<div class="f-descuento">'.round($articulo['dto_drogueria']*$articulo['aplicaen']).'</div>';
else*/

if ($articulo['descuentos']['0']['dto_drogueria'] == 50) 
{

	echo '<div class="imagen-f-porcentaje2x1">';
	echo '<div class="f-descuento2x1">2X1</div>';
	echo '</div>';
}
else
{
	if ($articulo['descuentos']['0']['dto_drogueria'] == 40) 
{

	echo '<div class="imagen-f-porcentaje">';
	echo '<div class="f-descuento">80</div>';
	echo '<div class="f-porcentaje">%</div>';
	echo '</div>';
}
else
{
	echo '<div class="imagen-f-porcentaje">';
	echo '<div class="f-descuento">'.round($articulo['descuentos']['0']['dto_drogueria']).'</div>';

	echo '<div class="f-porcentaje">%</div>';
	echo '</div>';
}
}
}
?>


</div>
<div class="middle-f">
<div class="product-content-oferta1">
<h5 class="product-content-oferta-descripcion">						
<?php echo $this->Form->submit($articulo['descripcion_sist'],['class'=>'descripcion_label']);?>
</h5>
<span class="product-content-oferta-priciof">
<?php echo 'Precio  s/Dto. $'.number_format(round(h($articulo['precio_publico'])*$descuento_pf, 3),2,',','.'); 
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


if ($precio_con_dcto!=0)
	echo 'Precio c/Dto $ '.number_format(round($precio_con_dcto, 3),2,',','.');
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
</div> 	
<div class=product-content-input>
<?php


echo $this->Form->input('cantidad',['value'=>$articulo['descuentos']['0']['uni_min'],'data-id' => $articulo['id'],'data-pv-id'=> $articulo['descuentos'][0]['id'],'class'=>'formcartcant']);
?>
</div> 
<div class="product-content-oferta2">
<?php

echo $this->Form->submit('botonhs.png', ['type'=>'image']);
?> 
</div>


</div>

  <?= $this->Form->end() ?>
</div>

<?php endforeach; ?>
</div>
</div>