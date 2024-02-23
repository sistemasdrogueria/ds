<table class="table sort">   
  <thead >
<tr style="text-align:center">	
<th>CLIENTE : <b><?php  if(!empty($clientenombre)) {echo $clientenombre.'('.$cliente['codigo'].')';}else{ echo "";}?></b></th>
<th>NÚMERO PEDIDO: <b><?php  if(!empty($articulosf)) {echo $articulosf[0]['pedido_ds'];}else{ echo "";}?></b></th>
</thead >
<tbody style="text-align:center">
<tr>

<td id="codigocliente"></td>
<td id="facturanumero"></td>
</tr>
  <br>  <br>
</tbody>
</table>
<table class="table sort">    
<thead >

<tr style="text-align:center">	
<th>Imagen</th>
<th>Codigo de Barra</th>
<th>Troquel</th>
<th>Descripción</th>
<th>Cantidad</th>
</tr>
</thead>
<tbody style="text-align:center">
<?php 

if(!empty($articulosf)){
$articulosfci = $articulosf[0]["facturas_cuerpos_items"];
foreach ($articulosfci as $articulo): ?>
<tr>

  <td class='formcartcanttd'><?php echo $this->Html->image('productos/'.$articulo['articulo']['imagen'],['class'=>'zoom', 'id'=>$articulo['articulo']['imagen'], 'onclick'=>'mostrarimggrande(this);']); ?></td>
  <td class='formcartcanttd'><?php echo $articulo['codigo_barra']	?></td>
  <td class='text-center formcartcanttd'><?php echo $articulo['troquel'];?></td>
  <td class=' text-center formcartcanttd'><?php echo $articulo['descripcion']; ?></td>
  <td class='text-center formcartcanttd'><?php echo  $articulo['cantidad_facturada'];	?> </td>
</tr>
<?php endforeach; } else{
echo "<tr><div>sin resultados</div></tr>";  
}?>
</tbody>
</table>

