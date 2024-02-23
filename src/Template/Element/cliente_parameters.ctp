<?= $this->Form->create('Clientes',['url'=>['controller'=>'Clientes','action'=>'edit_parameters']]); ?>			
	<div class="col-md-12 col-sm-12">	
	<div class="cliente_info">
	<span class='cliente_info_span'>Parámetros</span>
	<?php echo $this->Form->input('id', ['value' => $cliente->id,'type'=>'hidden']);?>
		<table cellpadding="0" cellspacing="0">
			<tr> 
				<td><?= __('Coeficiente de rentabilidad') ?></td>
				<td><?php echo $this->Form->input('coef_pyf', ['value' => $cliente->coef_pyf,'label'=>'']);?></td>
			</tr>	
		</table>
		
	</div> 
	</div> <!-- /.col-md-12 -->
	<div class="buttons-holder">
		<div class="button-holder">
			<?= $this->Form->submit('Guardar Cambios',['class'=>'sendbtn']); //'onclick'=>"return control();"?>
		</div>	
		<div class="button-holder">
		
			<?= $this->Html->link(__('Volver'),['controller' => 'Clientes', 'action' => 'view']); ?>
		</div>
	</div> <!-- /.buttons-holder -->
<?= $this->Form->end() ?>

<script>
 

</script>