<div id="dialog-form" title="agregar email">
  <p class="validateTips">Todos los campos son requeridos.</p>


<?= $this->Form->create('Clientes',['url'=>['controller'=>'Clientes','action'=>'edit_email'],'id'=>'editaremail']); ?>			
	<div class="col-md-12 col-sm-12">	
	<div class="cliente_info">
	<!-- span class='cliente_info_span'>Datos de Contacto</span -->
	<?php echo $this->Form->input('id', ['value' => $cliente->id,'type'=>'hidden']);?>
		<table cellpadding="0" cellspacing="0">
			
			<tr>
				<td><?= __('Email') ?></td>
				<td><?php echo $this->Form->input('email', ['value' => $cliente->email,'label'=>'','type'=>'email','class'=>'text ui-widget-content ui-corner-all' ]);?></td>
			</tr>
			<tr>
				<td><?= __('Email Alternativo') ?></td>
				<td><?php echo $this->Form->input('email_alternativo', ['value' => $cliente->email_alternativo ,'label'=>'','type'=>'email','class'=>'text ui-widget-content ui-corner-all' ]);?></td>
			</tr>
		</table>

	</div> 
	</div> <!-- /.col-md-12 -->

<?= $this->Form->end() ?>
</div>