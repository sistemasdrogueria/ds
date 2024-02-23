<div class="col-md-12 col-sm-12">	
	<div class="cliente_info">
	<span class='cliente_info_span'>Compras Semanales</span>
	<div>
	<table>
	<?= $this->Form->create('CtacteComprasSemanales',['url'=>['controller'=>'CtacteComprasSemanales','action'=>'index'],'id'=>'searchform5']); ?>
		<tr><td>Seleccione cuenta:</td></tr>
		<tr><td>
			<div id="selectsemanaresumen">
				<?php echo $this->Form->input('cliente_id',['id'=>'selectcuenta','options'=> $clientes,'onChange'=>'document.getElementById("searchform5").submit();']); ?>
			</div>
			</td>
		</tr>
		<tr><td>Seleccione la semana:</td></tr>
		<tr><td><div id="selectsemanaresumen">
				<?php echo $this->Form->input('nro_sistema', ['id'=>'selectsemananro','options' => $ctacteResumenSemanales, 'onChange'=>'document.getElementById("searchform5").submit();']); ?>
				</div>
			</td>
		</tr>
	</table>		
	<?= $this->Form->end() ?>
	</div>
	<br>
	<div class="compra_semanal_fecha"> <?php echo 'Desde el '. date_format($row['desde'],'d-m-Y').' al '.date_format($row['hasta'],'d-m-Y');?></div>
	<br>
		<table cellpadding="0" cellspacing="0">
			<tr> 
				<td class="ctadescripcion">
				Factura Medicamentos
				</td>
				<td class="carrito_importe"><?php  echo '$ '. number_format($totalmedicamento,2,',','.');?></td>
			</tr>	
			<tr>
				<td class="ctadescripcion">
				Factura Perf. y Acces.
				</td>
				<td class="carrito_importe"><?php echo '$ '.  number_format($totalperfumeria,2,',','.');?></td>
			</tr>
			
			<tr>	
			<td class="ctadescripcion">
				Factura Transfers
			</td>
			<td class="carrito_importe"><?php echo '$ '.  number_format($totaltransfer,2,',','.');?>
			</td>	
			</tr>
			<tr>
				<td class="ctadescripcion">
				Factura a Plazo
				</td>
				<td class="carrito_importe"><?php echo '$ '. number_format($totaloferta,2,',','.');?></td>
			</tr>
			
		
			<tr>	
			<td></td>
			<td>
				<?php 			?>
			</td>
		</tr>
			<tr class="ctadescripciontotal">
				<td class="ctadescripcion"><?= __('Total Compras') ?></td>
				<td class="carrito_importe"><?php echo '$ '. number_format($totalmedicamento+$totaloferta+$totalperfumeria+$totaltransfer,2,',','.');?><?php ?></td>
		</tr>
		<tr>	
			<td></td>
			<td>
				<?php 
					
				?>
			</td>
		</tr>
		</table>
	</div> 
</div> <!-- /.col-md-12 -->