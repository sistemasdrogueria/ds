<?= $this->Form->create('Clientes',['url'=>['controller'=>'Clientes','action'=>'edit_cuenta']]); ?>			
	<div class="col-md-12 col-sm-12">	
	<div class="cliente_info">
	<span class='cliente_info_span'>Datos de Contacto</span>
	<?php echo $this->Form->input('id', ['value' => $cliente->id,'type'=>'hidden']);?>
		<table cellpadding="0" cellspacing="0">
			<tr> 
				<td><?= __('Telefono') ?></td>
				<td><?php echo $this->Form->input('telefono', ['value' => $cliente->telefono,'label'=>'']);?></td>
			</tr>	
			<tr>
				<td><?= __('Email') ?></td>
				<td><?php echo $this->Form->input('email', ['value' => $cliente->email,'label'=>'','type'=>'email' ]);?></td>
			</tr>
			<tr>
				<td><?= __('Email Alternativo') ?></td>
				<td><?php echo $this->Form->input('email_alternativo', ['value' => $cliente->email_alternativo ,'label'=>'','type'=>'email' ]);?></td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0">
		<tr>
			<td><?= __('Recibir Oferta por email') ?></td>
			<td><?php 
			if ($cliente->ofertaxmail)	
				echo $this->Form->checkbox('ofertaxmail',['checked'=>"checked"]); 
			else
				echo $this->Form->checkbox('ofertaxmail');
			?>
			</td>
		</tr>
		<tr>	
			<td><?= __('Recibir respuesta por email') ?></td>
			<td>
				<?php 
					if ($cliente->respuestaxmail)	
						echo $this->Form->checkbox('respuestaxmail',['checked'=>"checked"]); 
					else
						echo $this->Form->checkbox('respuestaxmail'); 
				?>
			</td>
		</tr>
		</table>
	</div> 
	</div> <!-- /.col-md-12 -->
	<div class="buttons-holder">
		<div class="button-holder">
			<a href="#" onclick="changepassword();">Cambiar Contraseña</a>
			<!--?= $this->Html->link(__('Cambiar Contraseña'), ['controller' => 'users', 'action' => 'change_password']) ?-->
		</div>				
		<div class="button-holder">
			<?= $this->Form->submit('Guardar Cambios',['class'=>'sendbtn']); //'onclick'=>"return control();"?>
		</div>	
		<div class="button-holder">
		<a href="#" onclick="usuariosadd();">Usuarios</a>
			<!--?= $this->Html->link(__('Usuarios'),['controller' => 'users', 'action' => 'add']); //'onclick'=>"return control();"?-->
		</div>
		<div class="button-holder">
		
		<?= $this->Html->link(__('Parámetros'),['controller' => 'Clientes', 'action' => 'parameters']); //'onclick'=>"return control();" ?>
	</div>
	</div> <!-- /.buttons-holder -->
<?= $this->Form->end() ?>

<script>
 function usuariosadd(){

	 $.ajax({
    data: {
    },
    url: myBaseUrlsusersadd,
    type: "post",
    success: function (data) {
$('#mostrarresultado').removeClass('hide');
$('#redimensionar').removeClass('redimensionar');
$('#mostrarresultado').html(data);



	},
  });
}

function changepassword(){

	 $.ajax({
    data: {
    },
    url: myBaseUrlsuserschange,
    type: "post",
    success: function (data) {
$('#mostrarresultado').removeClass('hide');
$('#redimensionar').removeClass('redimensionar');
$('#mostrarresultado').html(data);



	},
  });
}
 


</script>