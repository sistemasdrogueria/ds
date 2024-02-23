<div class="carrito_resumen">
<table cellpadding="0" cellspacing="0" > 
<tr>
<td class="carrito_descripcion"><div>Importe Total (Sin IVA)</div></td>
<td class="carrito_importe">$ <?php echo number_format($totalcarrito,2,',','.');?></td>
</tr>
<tr>
<td class="carrito_descripcion"><div>Items/Unid Total</div>	</td>
<td class="carrito_importe"><div><?php echo $totalitems;?>/<?php echo $totalunidades;?></div></td>
</tr>
<tr>
<td class="carrito_descripcion"><div>Horario de corte</div> </td>
<td class="carrito_importe"><div><?php echo $this->request->session()->read('Auth.User.cierre')?></div></td>
</tr>
</table>
</div>