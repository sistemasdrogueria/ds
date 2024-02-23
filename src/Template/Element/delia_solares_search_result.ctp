<?php $indice=0;
$marcas= $marcas->toArray();
$grupos=$grupos->toArray();
$descuento_pf =$this->request->session()->read('Auth.User.pf_dcto');
$coef = $this->request->session()->read('Auth.User.coef');
$terminobuscar= 0;
$marca_id=0;
$grupo_id=0;
?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'#'],'id'=>'formaddcart','onsubmit'=>'return false;']); ?>
<div class=dermocontenedorajust>
<div class="dermocontenedor">
<?php foreach ($solares as $articulo): ?>
<?php 
$descuento=0; 
if (!empty($articulo['descuentos']))
{
if ($articulo['descuentos'][0]['tipo_venta']=='D')
    $descuento = $articulo['descuentos'][0]['id'];
else
{
    $descuento=0;   
    if (count($articulo['descuentos'])>1)
    {
    if ($articulo['descuentos'][1]['tipo_venta']=='D')
        $descuento = $articulo['descuentos'][1]['id'];
      
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
<?php echo $marcas[$articulo['marca_id']] ?>
</div>	
<div class='dermodescrip'>
<div class=dermodescrip_text><?= $articulo['descripcion_pag'] ?></div>
</div>



<span class="product-promo-discount">
  <?php
  if (!empty($articulo['descuentos']))
  {  $descuento = $articulo['descuentos'][0];
  
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
		     	case 'R': echo $this->Html->image('restrin.png',['value' => 4]);echo '<div class="overlay">Compra Restringida, Máx '.$articulo['restringido_unid'].' Uni</div>'; break;
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