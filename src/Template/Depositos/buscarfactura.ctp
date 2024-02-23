<div class="row" >
<div>
  <table class="tablesorter">   
  <thead >
<tr style="text-align:center">	
<th>CLIENTE : <b><?php  if(!empty($clientenombre)) {echo $clientenombre;}else{ echo "";}?></b></th>
<th>FACTURA NÚMERO: <b><?php  if(!empty($facturanumero)) {echo $facturanumero;}else{ echo "";}?></b></th>
</thead >
<tbody style="text-align:center">
<tr>

<td id="codigocliente"></td>
<td id="facturanumero"></td>
</tr>
  <br>  <br>
</tbody>
</table>
<table class="tablesorter">    
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

$articulosff = $articulosf->toArray();
if($articulosff !== null){
foreach ($articulosff as $articulo): ?>
<tr>

  <td class='formcartcanttd'><?php echo $this->Html->image('productos/'.$articulo['articulo']['imagen']); ?></td>
    <td class='formcartcanttd'><?php echo $articulo['codigo_barra']	?></td>
  <td class='text-center formcartcanttd'><?php echo $articulo['troquel']	?></td>
  <td class=' text-center formcartcanttd'><?php echo $articulo['descripcion']	?></td>
  <td class='text-center formcartcanttd'><?php echo  $articulo['cantidad_facturada'];	?> </td>
</tr>


<?php endforeach; } else{


echo "<tr><div>sin resultados</div></tr>";

  
}?>
</tbody>
</table>
</div>
</div>
<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">

</div>
<div class="modal-body">       
<img src="" class="enlargeImageModalSource" style="width: 100%;">       
</div>
</div>
</div>
</div>