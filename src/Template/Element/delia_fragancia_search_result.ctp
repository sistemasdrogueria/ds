<?php $indice=0;
$marcas= $marcas->toArray();
$generos=$generos->toArray();
$descuento_pf =$this->request->session()->read('Auth.User.pf_dcto');
$coef = $this->request->session()->read('Auth.User.coef');
$terminobuscar= 0;
$marca_id=0;
$genero_id=0;
?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'#'],'id'=>'formaddcart','onsubmit'=>'return false;']); ?>
<div class=fraganciacontenedorajust>
<div class="fraganciacontenedor">
<?php foreach ($fragancias as $fragancia): ?>
    
   
<div class="fraganciadiv">
<div class="fraganciaimagen" align="center">
<?php 
$uploadPath = $fragancia['carpeta'].'/';
if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$fragancia['imagen'] ))
echo $this->Html->image($uploadPath.$fragancia['imagen'], ['alt' => str_replace('"', '', $fragancia['nombre']),'class'=>'imgFoto', 'loading'=>'lazy' ]);
else
echo $this->Html->image($uploadPath.$fragancia['imagen'], ['alt' => str_replace('"', '', $fragancia['nombre']),'class'=>'imgFoto','loading'=>'lazy' ]); 
?> 
</div> 
<div class='fragmarca'>
<?php
if(array_key_exists($fragancia['marca_id'],$marcas)){
    echo $marcas[$fragancia['marca_id']];
    }else{}?>
</div>	
<div class='fragdescrip'>
<?= $fragancia['nombre'] ?>
</div>

<div class="fraganciapresentaciondiv">
<table>
<?php 
$fraganciaspresentaciones =$fragancia['fragancias_presentaciones'];
foreach ( $fraganciaspresentaciones as $fp): ?>
<tr>
<td class=fragcantid>
<?php
$indice+=1;
$encabezado = $indice.'.';
$articulo = $fp['articulo']; 
 if (isset($articulo['descuentos'][0]['id'])) {
    $descuento = $articulo['descuentos'][0]['id'];

   }else{

       $descuento=0;   
   }

if ($articulo['carritos'] !=null )
{
    $cantidadencarrito = $articulo['carritos'][0]['cantidad'];
    echo $this->Form->input($encabezado.'cantidad',['maxlength'=> 3,'tabindex'=>$indice,'value' =>$cantidadencarrito ,'class'=>'fragcant', 'data-id-input'=>'tab'.$indice,'data-id'=>$articulo['id'],'data-cantidad-car'=>$cantidadencarrito, 'value'=>$cantidadencarrito,'data-pv-id'=> $descuento, 'onkeypress'=>'return soloNumeros(event)','target'=>'_blank'  , 'autocomplete'=>'off']);
    
    }else	
    {
        $cantidadencarrito ="";
    echo $this->Form->input($encabezado.'cantidad',['maxlength'=> 3,'tabindex'=>$indice,'class'=>'fragcant','data-id-input'=>'tab'.$indice,'data-id'=>$articulo['id'],'data-cantidad-car'=>$cantidadencarrito, 'value'=>$cantidadencarrito,'data-pv-id'=> $descuento,'onkeypress'=>'return soloNumeros(event)','target'=>'_blank'  , 'autocomplete'=>'off']);
    } ?>
</td>
<td class=fragml>
<?php echo $fp['detalle'].' ml';?>
</td>	
<td class=fragstock>
<?php switch ($articulo['stock']) {
case 'B': echo $this->Html->image('fragbajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );break;
case 'F': echo $this->Html->image('fragfalta.png',['title' => 'Producto en Falta']);break;
case 'S': echo $this->Html->image('fragalto.png',['title' => 'Stock Habitual']); break;
case 'R': echo $this->Html->image('restrin.png',['value' => 4]);echo '<div class="overlay">Compra Restringida, Máx '.$articulo['restringido_unid'].' Uni</div>'; break;
case 'D': echo $this->Html->image('fragd.png',['title' => 'Producto Discontinuo']); break;
} ?>
</td>
<td class=fragdesc>
<?php 
if ($articulo['descuentos'] !=null)
echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][0]['dto_drogueria'], 3),0,',','.').'% '.'</font>'; ?>

</td>
<td class=fragpre>
<?php 
if ($articulo['descuentos'] !=null)
 {
    $precio = $articulo['precio_publico'];
    $precio = $precio*$descuento_pf*$coef;
    $precio -=$precio*$articulo['descuentos'][0]['dto_drogueria']/100;
    echo  '<font style="font-weight: bold;">$ '.number_format(round($precio, 3),2,',','.').'</font>'; 
 }
else
 echo '$ '.number_format(round(h($articulo['precio_publico'])*$descuento_pf*$coef, 3),2,',','.'); ?>
 
</td>
</tr>
<tr>
  <?php 
 /*
  if ($articulo["id"]== 19940)
  echo $this->Html->image('MELCHOR.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes','style'=>'width:40px;height:70px']);
  if ($articulo["id"]== 2033)
  echo $this->Html->image('GASPAR.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes','style'=>'width:40px;height:70px']);
  if ($articulo["id"]== 51320)
  echo $this->Html->image('BALTAZAR.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes','style'=>'width:40px;height:70px']);

 
  if ($articulo["id"]== 24650)
  echo $this->Html->image('PAPA-NOEL.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes']);
 
  */
  ?>

  </tr>
<?php endforeach; ?>
</table>
</div>
    <?php if ($articulo["id"]== 48072)
echo $this->Html->image('GASPAR.png', ['alt' => str_replace('"', '', $articulo['descripcion_sist']),'class'=>'imgFotoReyes','style'=>'width:40px;']); ?>
</div>
<?php endforeach; ?>
</div>
<!--/div -->
</div>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>

<?= $this->Form->end() ?>	
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