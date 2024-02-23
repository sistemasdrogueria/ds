<?= $this->Form->create('Users',['url'=>['controller'=>'Users','action'=>'add_user']]); ?>
	<div class="large-5 columns strings">
		<span class='cliente_info_span'>Agregar Usuarios</span>
			<div class="cliente_info">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="label_user">Nombre Usuario</td>
						<td>
							<div style="width:40%; float:left;">
							<?php	echo $this->Form->input('username');	?>
							</div>
							<div style="width:60%; padding-top:4px;">
							<?php echo '.'.$this->request->session()->read('Auth.User.codigo'); ?>			
							</div>
						</td>
					</tr>
					<tr>
						<td class="label_user">Perfil de usuario</td>	
						<td><?php echo $this->Form->select('perfile_id', $perfiles);	?></td>
					</tr>			
					<tr>
						<td class="label_user">Contraseña</td>
						<td><?php echo $this->Form->password('password');?></td>
					</tr>	
					<tr>
						<td class="label_user">Confirme Contraseña</td>
						<td><?php echo $this->Form->password('password_confirm');?></td>
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