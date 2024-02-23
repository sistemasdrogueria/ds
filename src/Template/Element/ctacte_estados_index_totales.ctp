<div class="col-md-12 col-sm-12">	
<div class="cliente_info">
<span class='cliente_info_span'>Estado de Cuenta Corriente</span>
<table cellpadding="0" cellspacing="0">
<tr> 
<td class="ctadescripcion_item">
<?= $this->Html->link(__('Deuda vencida'), ['controller' => 'CtacteEstados', 'action' => 'deudavencida']) ?>
</td>
<td class="carrito_importe"><?php  echo '$ '. number_format($totalvencidaX[0],2,',','.');?></td>
</tr>
<tr>
<td class="ctadescripcion">
<?= $this->Html->link(__(' - Medicamentos'), ['controller' => 'CtacteEstados', 'action' => 'deudavencida',2]) ?>
</td>
<td class="carrito_importe_red_dark"><?php echo '$ '.  number_format($totalvencidaX[1],2,',','.');?></td>
</tr>
<tr>
<td class="ctadescripcion">
<?= $this->Html->link(__(' - Perf. y Acce.'), ['controller' => 'CtacteEstados', 'action' => 'deudavencida',3]) ?>
</td>
<td class="carrito_importe_red_dark"><?php echo '$ '.  number_format($totalvencidaX[2],2,',','.');?></td>
</tr>
<tr>
<td class="ctadescripcion">
<?= $this->Html->link(__(' - Ofertas a Plazos'), ['controller' => 'CtacteEstados', 'action' => 'deudavencida',5]) ?>
</td>
<td class="carrito_importe_red_dark"><?php echo '$ '.  number_format($totalvencidaX[3],2,',','.');?></td>
</tr>
<tr>
<td class="ctadescripcion">
<?= $this->Html->link(__(' - Transfers'), ['controller' => 'CtacteEstados', 'action' => 'deudavencida',6]) ?>
</td>
<td class="carrito_importe_red_dark"><?php echo '$ '.  number_format($totalvencidaX[4],2,',','.');?></td>
</tr>					
<tr class="ctadescripciondiv">
<td class="ctadescripcion_item">
<?= $this->Html->link(__('Saldo Acreedor'), ['controller' => 'CtacteEstados', 'action' => 'credito']) ?>
</td>
<td class="carrito_importe"><?php echo '$ '.  number_format($totalcredito,2,',','.');?></td>
</tr>
<tr>
<td class="ctadescripcion">
<?= $this->Html->link(__(' - Tarjetas de Crédito'), ['controller' => 'CtacteEstados', 'action' => 'credito']) ?>
</td>
<td class="carrito_importe_red_dark"><?php echo '$ '.  number_format($totaltarjetacredito,2,',','.');?></td>
</tr>
<tr>
<td class="ctadescripcion">
<?= $this->Html->link(__(' - Obras Sociales'), ['controller' => 'CtacteEstados', 'action' => 'obrasocial']) ?>
</td>
<td class="carrito_importe_red_dark"><?php echo '$ '.  number_format($totalobrasocial,2,',','.');?></td>
</tr>
<tr class="ctadescripciondiv">
<td class="ctadescripcion_item">
<?= $this->Html->link(__('Notas de Débito'), ['controller' => 'CtacteEstados', 'action' => 'index']) ?>
</td>
<td class="carrito_importe"><?php echo '$ '.  number_format($totalnotadebito,2,',','.');?></td>
</tr>
<tr class="ctadescripciontotal">	
<td class="ctadescripcion">
<?php 
if (($totalvencidaX[0]-$totalcredito+$totalnotadebito )>0)
echo 'Saldo vencido a pagar';
else echo 'Saldo a favor';
?>
</td>
<?php 

if (($totalvencidaX[0]-$totalcredito+$totalnotadebito )>0)
echo '<td class="carrito_importe_red">';
else
echo '<td class="carrito_importe_green">';
echo '$ '.  number_format($totalvencidaX[0]-$totalcredito+$totalnotadebito,2,',','.');?></td>	
</tr>
<tr>	
<td class="ctadescripcion"></td>
<td class="carrito_importe"></td>	
</tr>
<tr>
<td class="ctadescripcion_item">
<?= $this->Html->link(__('Deuda a vencer'), ['controller' => 'CtacteEstados', 'action' => 'deudaavencer']) ?>
</td>
<td class="carrito_importe"><?php echo '$ '. number_format($totalavencerX[0],2,',','.');?></td>
</tr>
<tr>
<td class="ctadescripcion">
<?= $this->Html->link(__(' - Medicamentos'), ['controller' => 'CtacteEstados', 'action' => 'deudaavencer',2]) ?>
</td>
<td class="carrito_importe_red_dark"><?php echo '$ '.  number_format($totalavencerX[1],2,',','.');?></td>
</tr>
<tr>
<td class="ctadescripcion">
<?= $this->Html->link(__(' - Perf. y Acce.'), ['controller' => 'CtacteEstados', 'action' => 'deudaavencer',3]) ?>
</td>
<td class="carrito_importe_red_dark"><?php echo '$ '.  number_format($totalavencerX[2],2,',','.');?></td>
</tr>
<tr>
<td class="ctadescripcion">
<?= $this->Html->link(__(' - Ofertas a Plazos'), ['controller' => 'CtacteEstados', 'action' => 'deudaavencer',5]) ?>
</td>
<td class="carrito_importe_red_dark"><?php echo '$ '.  number_format($totalavencerX[3],2,',','.');?></td>
</tr>
<tr>
<td class="ctadescripcion">
<?= $this->Html->link(__(' - Transfers'), ['controller' => 'CtacteEstados', 'action' => 'deudaavencer',6]) ?>
</td>
<td class="carrito_importe_red_dark"><?php echo '$ '.  number_format($totalavencerX[4],2,',','.');?></td>
</tr>
<tr class="ctadescripciondiv">
<td class="ctadescripcion_item">
<?= $this->Html->link(__('Valores en Cartera'), ['controller' => 'CtacteEstados', 'action' => 'documentocartera']) ?>
</td>
<td class="carrito_importe"><?php echo '$ '. number_format($totalcartera,2,',','.');?><?php ?></td>
</tr>
<tr>	
<td></td>
<td>
<?php 			?>
</td>
</tr>
<tr class="ctadescripciontotal">
<td class="ctadescripcion_item"><?= __('Deuda Total') ?></td>
<td class="carrito_importe"><?php echo '$ '. number_format($totaldeuda,2,',','.');?><?php ?></td>
</tr>
<tr>	
<td>
</td>
<td>
</td>
</tr>
<tr>	
<td>
<?php 
echo 'Al día: '
?>
</td>
<td>
</td>
</tr>
</table>
</div> 
</div> <!-- /.col-md-12 -->