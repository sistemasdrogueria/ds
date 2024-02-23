<?= $this->Form->create('Users',['url'=>['controller'=>'Users','action'=>'change_password']]); ?>
	<div class="large-5 columns strings">
		<span class='cliente_info_span'>Cambiar Contraseña</span>
			<div class="cliente_info">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="label_user">Contraseña Actual</td>
						<td>
						<?php echo $this->Form->input('username', ['value' => $this->request->session()->read('Auth.User.username'),'type'=>'hidden']);?>
						<?php echo $this->Form->password('password');?></td>
					</tr>	
					<tr>
						<td class="label_user">Contraseña Nueva</td>
						<td><?php echo $this->Form->password('current_password');?></td>
					</tr>
					<tr>
						<td class="label_user">Confirme Contraseña</td>
						<td><?php echo $this->Form->password('confirm_new_password');?></td>
					</tr>	
				</table>			
			</div>
		</div>
<div class="buttons-holder">
		<div class="button-holder" style="width:150px;">
			<?= $this->Form->submit('Guardar',['class'=>'sendbtn']) ?>
		</div>	
</div> <!-- /.buttons-holder -->
<?= $this->Form->end() ?>