<div class="carrito_resumen">
<table cellpadding="0" cellspacing="0" > 
<tr>
<td class="carrito_descripcion"><div>Importe Total (Sin IVA)</div> </td>
<td id="carrito_importe2" class="carrito_importe">$ <?php echo number_format($totalcarrito,2,',','.');?></td>

</tr>

<tr>
<td class="carrito_descripcion"><div>Importe Total Stock (Sin IVA)</div> </td>
<td id="carrito_importe2" class="carrito_importe">$ <?php echo number_format($totalcarritostock,2,',','.');?></td>
</tr>
<tr>
<td class="carrito_descripcion"><div>Items/Unid Total </div> </td>
<td class="carrito_importe"><div><?php echo $totalitems;?>/<?php echo $totalunidades;?></div></td>
</tr>
<tr>
<td class="carrito_descripcion"><div>Horario de corte</div> </td>
<td class="carrito_importe"><div>
<?php   if ($this->request->session()->read('Auth.User.codigo')!=66079 )
        echo $this->request->session()->read('Auth.User.cierre');
else    echo $this->request->session()->read('Auth.User.cierre')->i18nFormat('dd/MM/yy'). ' 21:00';?>
</div></td>
</tr>
</table>
</div>