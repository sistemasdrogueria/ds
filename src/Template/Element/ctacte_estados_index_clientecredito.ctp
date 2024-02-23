<div class="col-md-12 col-sm-12">	
	<div class="cliente_info">
	<div class="search-form">
    <?= $this->Form->create('CtacteEstados',['url'=>['controller'=>'CtacteEstados','action'=>'index'],'id'=>'searchform5']); ?>
	<?= $this->Form->input('cliente_id',['id'=>'selectcuenta','options'=> $clientes,'default'=>$this->request->session()->read('cliente_id'),'label'=>'Cuenta:','onChange'=>'document.getElementById("searchform5").submit();']); ?>
	<?= $this->Form->end() ?>
	</div>
	<br>
	<span class='cliente_info_span'>Crédito Asignado</span>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td class="ctadescripcion">
				<?php 	
				if ($clientecredito!=null)
				{
					if ($clientecredito['credito_tipo']=='S')
						echo 'Crédito Semanal';
					else
						echo 'Crédito Diario';
				}
				else
					echo 'Crédito Semanal';
				?>
				</td>
				<td class="carrito_importe"><?php 
				if ($clientecredito!=null)
					echo '$ '.  number_format($clientecredito['credito_maximo'],2,',','.');
				else
					echo '$ 0.00';
				?></td>
			</tr>
			<tr>
				<td class="ctadescripcion">
				<?= __('Crédito Disponible') ?>
				</td>
				<td class="carrito_importe"><?php 
				if ($clientecredito!=null)
					echo '$ '. number_format($clientecredito['credito_maximo']-$clientecredito['credito_consumo'],2,',','.');
				else
					echo '$ 0.00';
				?></td>
			</tr>
		<tr>	
			<td class="ctadescripcion">Al dia:</td>
			<td class="carrito_importe">
				<?php 
				if ($clientecredito!=null)
					echo date_format($clientecredito->fecha,'d-m-Y H:m:s');
				else
					echo '';?>
			</td>
		</tr>
		</table>
	</div> 
</div> <!-- /.col-md-12 -->