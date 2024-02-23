<div class="carrito_resumen">
<table cellpadding="0" cellspacing="0" > 
<tr>
<td class="carrito_descripcion">
<div>
Credito Disponible  
</div> <!-- /.col-md-6 -->
</td>
</tr>
<tr>
<td class="carrito_importe"> 
<div >
<?php echo "$ ".number_format($creditodisponible,2,',','.');?>
</div> <!-- /.col-md-6 -->
</td>
</tr>
<tr>
<td class="carrito_descripcion">
<div>
Importe Total  
</div> <!-- /.col-md-6 -->
</td>
</tr>
<tr>
<td class="carrito_importe">
$ <?php echo number_format($totalcarrito,2,',','.');?>
</td>
</tr>
<tr>
<td class="carrito_descripcion">
<div>
Items/Unid Total 
</div> <!-- /.col-md-6 -->
</td>
</tr>
<tr>
<td class="carrito_importe">
<div>
<?php echo $totalitems;?>/<?php echo $totalunidades;?>
</div>
</td>
</tr>
</table>
</div>