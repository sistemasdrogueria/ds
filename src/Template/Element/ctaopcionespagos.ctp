<div class="col-md-12 col-sm-12">	
	<div class="cliente_info">
	<span class='cliente_info_span'>Resumen de Pagos</span>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td class="ctadescripcion_item">
				<?= $this->Html->link(__('Deposito Bancario'), ['controller' => 'CtactePagos', 'action' => 'search',1]) ?>
				</td>
				<td class="carrito_importe"><?php echo '$ '.  number_format($totalpagosX[0],2,',','.');?></td>
			</tr>
			<tr>
				<td class="ctadescripcion_item">
				<?= $this->Html->link(__('Cheque diferido'), ['controller' => 'CtactePagos', 'action' => 'search',2]) ?>
				</td>
				<td class="carrito_importe"><?php echo '$ '.  number_format($totalpagosX[1],2,',','.');?></td>
			</tr>	
			<tr class="ctadescripciondiv">
				<td class="ctadescripcion_item">
				<?= $this->Html->link(__('Efectivo'), ['controller' => 'CtactePagos', 'action' => 'search',3]) ?>
				</td>
				<td class="carrito_importe"><?php echo '$ '.  number_format($totalpagosX[2],2,',','.');?></td>
			</tr>			
			<tr class="ctadescripciondiv">
				<td class="ctadescripcion_item">
				<?= $this->Html->link(__('Retenciones'), ['controller' => 'CtactePagos', 'action' => 'search',4]) ?>
				</td>
				<td class="carrito_importe"><?php echo '$ '.  number_format($totalpagosX[3],2,',','.');?></td>
			</tr>
			<tr>
				<td class="ctadescripcion_item">
				<?= $this->Html->link(__('Transferencia'), ['controller' => 'CtactePagos', 'action' => 'search',5]) ?>
				</td>
				<td class="carrito_importe"><?php echo '$ '.  number_format($totalpagosX[4],2,',','.');?></td>
			</tr>
			<tr>
				<td class="ctadescripcion_item">
				<?= $this->Html->link(__('Tarjetas'), ['controller' => 'CtactePagos', 'action' => 'search',6]) ?>
				</td>
				<td class="carrito_importe"><?php echo '$ '.  number_format($totalpagosX[5],2,',','.');?></td>
			</tr>
			<tr>
				<td class="ctadescripcion_item">
				<?= $this->Html->link(__('O. Sociales'), ['controller' => 'CtactePagos', 'action' => 'search',7]) ?>
				</td>
				<td class="carrito_importe"><?php echo '$ '.  number_format($totalpagos7,2,',','.');?></td>
			</tr>
			<tr>	
				<td></td>
				<td></td>
			</tr>
			
			<tr class="ctadescripciontotal">
				<td class="ctadescripcion_item"><?= __('Total') ?></td>
				<td class="carrito_importe"><?php echo '$ '. number_format($totalpagos,2,',','.');?><?php ?></td>
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