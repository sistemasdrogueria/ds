	<style>
.offparpadea {
animation-name: parpadeo; animation-duration: 1s; animation-timing-function: linear;animation-iteration-count: infinite; -webkit-animation-name:parpadeo; -webkit-animation-duration: 1s;
-webkit-animation-timing-function: linear; -webkit-animation-iteration-count: infinite;}
@-moz-keyframes parpadeo{  0% { opacity: 1.0; }  50% { opacity: 0.0; }  100% { opacity: 1.0; }}
@-webkit-keyframes parpadeo {   0% { opacity: 1.0; }  /*25% { opacity: 0.5; }*/   50% { opacity: 0.0; }  /*75% { opacity: 0.5; }*/   100% { opacity: 1.0; }}
@keyframes parpadeo {   0% { opacity: 1.0; }  /*25% { opacity: 0.5; }*/   50% { opacity: 0.0; }  /*75% { opacity: 0.5; }*/  100% { opacity: 1.0; } }
.product-content-input{position:absolute;margin-top: 140px;width:90px; }
.product-content-input label {  display: none;}
</style>

<div class="row" style ="text-align: center;">
<div class = "gallery-contenedor"     style="margin:0px auto;">
<?php 
 $indice=0;
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');?>
<?php foreach ($ofertasX as $oferta): ?>
<?php if ($oferta['ubicacion']==0||$oferta['ubicacion']==2)
    {
?>
<div class="gallery-oferta"> <!-- -->
<div class="product-item-6"> <!-- -->
<div> <!-- class="product-thumb">  -->
<?php 
			switch ($oferta['oferta_tipo_id']) {
				case 2:
					echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['laboratorio_id']]], ['alt' => str_replace('"', '', $oferta['descripcion']),'loading'=>'lazy']);

					break;
				case 4:
					if ($oferta['busqueda_sect']!= "EXPO")
					echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'search_i',$oferta['busqueda_sect'],$oferta['laboratorio_id']]], ['alt' => str_replace('"', '', $oferta['descripcion']),'loading'=>'lazy']);
					else

					echo '<a href="https://www.exposurvirtual.com.ar/" target ="_blank">'.$this->Html->image('ofertas/'.$oferta['imagen'], ['alt' => 'EXPOSURVIRTUAL8']) .'</a>';

					break;
				case 5:
					if ($oferta['busqueda_sect']!="")
					echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'search_i',$oferta['busqueda_sect']]], ['alt' => str_replace('"', '', $oferta['descripcion']),'loading'=>'lazy']);
					else
					echo $this->Html->image('ofertas/'.$oferta['imagen'], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
					
					break;
				case 6:
						echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'search_i',$oferta['busqueda_sect'],0,1]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
						break;
				case 11:
						echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['busqueda'],$oferta['detalle'],$oferta['descripcion']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
						break;
						

			}
		/*	
			if ($oferta['detalle']!='IT' && $oferta['detalle']!='LAB' )
			{
				if ($oferta['detalle']!='D') 
				echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['busqueda'],$oferta['detalle'],$oferta['descripcion'],'0']], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
				else
				echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'search_i',$oferta['busqueda'],$oferta['busqueda_sect']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);		
			}
			else
			{
				if ($oferta['detalle']!='IT')
				{
				  echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'search_i',$oferta['busqueda_sect'],$oferta['busqueda']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
				}
				else
				  echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'search_i',$oferta['busqueda_sect']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
			}
		
	  */

?> 
</div> <!-- -->
<div class="product-content-oferta1"> <!-- -->
<span class="descripcion">
</span>
</div> 	<!-- -->
</div> <!-- -->
</div> <!-- -->
	<?php }?>
<?php endforeach; ?>
<?php
foreach ($ofertasY as $oferta): ?>
<?php if ($oferta['oferta_tipo_id']==1)
{
	$indice+=1;$encabezado = $indice.'.'; $indice+=1;
?>
<div class="gallery-oferta">
<?= $this->Form->create('Carritos'.$indice,['url'=>['controller'=>'#','action'=>'#'],'id'=>'carritosoferta'.$indice]); ?>

<div class="product-item-6">
<div class="product-thumb" style="height:200px; border: 5px solid #303030; ">
<?php echo $this->Html->image('productos/'.$oferta['articulo']['imagen'], ['alt' => str_replace('"', '', $oferta['descripcion'])]);?> 
</div> 
<div class="product-thumb-oferta2">
<?php if (!empty($oferta['articulo']['descuentos']))
{
if ($oferta['aplicaen']>1)
echo $this->Html->image('ofertaeti5.png', ['alt' => 'oferta', 'class'=>'offparpadea']);
else
echo $this->Html->image('ofertaeti4.png', ['alt' => 'oferta']);
}
?> 		
</div>
<?php 
$valoroferta =0;
if ($oferta['aplicaen']<2)
echo '<div class="product-thumb-oferta3">';
else
echo '<div class="product-thumb-oferta5" >';
if (!empty($oferta['articulo']['descuentos']))
{
	$descuento = $oferta['articulo']['descuentos'][0];
if ($oferta['aplicaen']>1){
$valoroferta = $descuento['dto_drogueria']*$oferta['aplicaen'];
if (round($valoroferta)<100){
echo '<div class="oferta_porcentaje2">%</div>';
echo '<div class="oferta_descuento">'.round($valoroferta).'</div>';
}
else
{
if ($oferta['aplicaen']==2)
echo '<div class="oferta_descuento offparpadea" style=" margin-top: 5px; font-size: 35px;">2x1</div>';
if ($oferta['aplicaen']==3)
echo '<div class="oferta_descuento offparpadea" style=" margin-top: 5px; font-size: 35px;">3x2</div>';
if ($oferta['aplicaen']==4)
echo '<div class="oferta_descuento offparpadea" style=" margin-top: 5px; font-size: 35px;">4x3</div>';
if ($oferta['aplicaen']==5)
echo '<div class="oferta_descuento offparpadea" style=" margin-top: 5px; font-size: 35px;">5x4</div>';
if ($oferta['aplicaen']==10)
echo '<div class="oferta_descuento offparpadea" style=" margin-top: 5px; font-size: 28px;">10x9</div>';
}
}
else
{
	$valoroferta =0;
echo '<div class="oferta_porcentaje">%</div>';
echo '<div class="oferta_descuento">'.round($descuento['dto_drogueria']).'</div>';
}
}
echo '</div>';
?>				
<div class="product-thumb-oferta4">
<?php 
if ($valoroferta>0)
if (round($valoroferta)<100){
if ($descuento['dto_drogueria']!=null && $oferta['aplicaen']==2)
echo '<div class="oferta_enlaxunidad">en la 2da unidad</div>';
if ($descuento['dto_drogueria']!=null && $oferta['aplicaen']==3)
echo '<div class="oferta_enlaxunidad">en la 3ra unidad</div>';
if ($descuento['dto_drogueria']!=null && $oferta['aplicaen']==4)
echo '<div class="oferta_enlaxunidad">en la 4ra unidad</div>';
if ($descuento['dto_drogueria']!=null && $oferta['aplicaen']==5)
echo '<div class="oferta_enlaxunidad">en la 5ra unidad</div>';
if ($descuento['dto_drogueria']!=null && $oferta['aplicaen']==10)
echo '<div class="oferta_enlaxunidad">en la 10ma unidad</div>';
}
?>
</div>
<div class="product-content overlay">
<div class="product-content-oferta1">
<h5 style="color:#E84C3D;">
<?php echo str_replace('"', '', $oferta['descripcion']);?>
</h5>			
<?php 
$precio_con_dcto=0;
if (!empty($oferta['articulo']['descuentos']))
{
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

<span class="descuento_porcentaje_um">
<?php
if (!empty($oferta['articulo']['descuentos']))
{
	$descuento = $oferta['articulo']['descuentos'][0];

if ($oferta['aplicaen']>1)
{
$off = $descuento['dto_drogueria']*$oferta['aplicaen'];
if ($off>100)
$off = 100;
if ($oferta['aplicaen']==2)
echo $off.'% en la 2da unidad';
if ($oferta['aplicaen']==3)
echo $off.'% en la 3ra unidad';
if ($oferta['aplicaen']==4)
echo $off.'% en la 4ra unidad';
if ($oferta['aplicaen']==10)
echo $off.'% en la 10ma unidad'; 
if ($oferta['unidades_minimas'] >1)
echo ' - Min :'.$oferta['unidades_minimas'] . ' U ';
}
else
if ($descuento['uni_min'] >1)
echo $descuento['dto_drogueria'].'% por '.$descuento['uni_min'].' u';
}

?>
</span>
<span class=descuento_stock>
  <?php
 if (!empty($oferta['articulo']))
 { 
  echo 'Stock ';
  switch ($oferta['articulo']['stock']) {
  case 'B': echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora','value' => 2] );	break;
			case 'F': echo $this->Html->image('falta.png',['title' => 'Producto en Falta','value' => 3]);				break;
			case 'S': echo $this->Html->image('alto.png',['title' => 'Stock Habitual','value' => 1]);					break;
			case 'R': echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock','value' => 4]);		break;
			case 'D': echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo','value' => 5]);			break;
			}
		}
			?>
</span>
</div>
<div class=product-content-input>

<?php 

 if (isset($oferta['articulo']['descuentos'][0])) {
    $descuento = $oferta['articulo']['descuentos'][0]['id'];

   }else{

       $descuento=0;   
   }
echo $this->Form->input($indice.'cantidad',['data-value'=>$oferta['unidades_minimas'],'value'=>$oferta['unidades_minimas'],'class'=>'cantidadoferta','id'=>'bu'.$oferta['articulo_id'],'tabindex'=>'','data-id-input'=>'tab','data-id'=>$oferta['articulo_id'],'data-pv-id'=> $descuento, 'onkeypress'=>'return soloNumeros(event)']);
//echo $this->Form->input('cantidad',['value'=>$articulo['descuentos']['0']['uni_min'],'data-id' => $articulo['id'],'data-pv-id'=> $articulo['descuentos'][0]['id'],'class'=>'formcartcant']); 
?>
</div> 

<div class="product-content-oferta2">
<div  onclick= "incrementCarritos(<?php echo $oferta['articulo_id']; ?>,<?php echo $descuento; ?>,<?php echo $oferta['articulo_id']; ?>);">
<a href="#product-content-oferta2" onsubmit ="return false;" >
<?php echo $this->Html->image('agregarcarro2.png', ['alt' => 'AGREGAR']);?></a>
</div> 
</div> 
</div>
</div>
</div>
<?= $this->Form->end() ?>	
<?php }?>
<?php endforeach; ?>
</div>
</div>