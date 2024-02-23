  <br>
<table class="table sort">    
<thead >
<tr style="text-align:center">	
<th>Imagen</th>
<th>Código de Barra</th>
<th>Clave AMP</th>
<th>Troquel</th>
<th>Descripción</th>
<th>Laboratorio</th>
</tr>
</thead>
<tbody style="text-align:center">
<?php 
if(!empty($articulos)){
foreach ($articulos as $articulo): ?>
<tr>

  <td class='formcartcanttd'><?php echo $this->Html->image('productos/'.$articulo['imagen'],['class'=>'zoom', 'id'=>$articulo['imagen'], 'onclick'=>'mostrarimggrande(this);']); ?></td>
  <td class='formcartcanttd'><?php echo $articulo['codigo_barras']	?></td>
  <td class='formcartcanttd'><?php echo $articulo['clave_amp']	?></td>
  <td class='text-center formcartcanttd'><?php echo $articulo['troquel']	?></td>
  <td class='text-center formcartcanttd'><?php echo $articulo['descripcion_sist']	?></td>
  <td class='text-center formcartcanttd'><?php echo $_SESSION['Laboratorios'][ $articulo['laboratorio_id']]?> </td>
</tr>


<?php endforeach; } ?>
</tbody>
</table>

