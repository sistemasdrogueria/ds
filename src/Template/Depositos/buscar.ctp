
<div class="row" >
<div>
  <br>
<table class="tablesorter">    
<thead >
<tr style="text-align:center">	
<th>Imagen</th>
<th>Codigo de Barra</th>
<th>Clave AMP</th>
<th>Troquel</th>
<th>Descripción</th>
<th>Laboratorio</th>
</tr>
</thead>
<tbody style="text-align:center">
<?php 

foreach ($articulos as $articulo): ?>
<tr>

  <td class='formcartcanttd'><?php echo $this->Html->image('productos/'.$articulo['imagen']); ?></td>
    <td class='formcartcanttd'><?php echo $articulo['codigo_barras']	?></td>
     <td class='formcartcanttd'><?php echo $articulo['clave_amp']	?></td>
  <td class='text-center formcartcanttd'><?php echo $articulo['troquel']	?></td>
  <td class=' text-center formcartcanttd'><?php echo $articulo['descripcion_sist']	?></td>
  <td class='text-center formcartcanttd'><?php echo $_SESSION['Laboratorios'][ $articulo['laboratorio_id']]?> </td>
</tr>


<?php endforeach; ?>
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