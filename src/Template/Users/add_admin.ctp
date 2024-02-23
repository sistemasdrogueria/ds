<div class="clear"></div>
<article class="module width_full">
 <?= $this->Form->create($user); ?>
			<header>
			<legend><h3><?= __('Agregar Usuario') ?></h3></legend>
			
			</header>
				<div class="module_content">
			<fieldset >
			<?php echo $this->Form->select('cliente_id', $clientes);	?>
			</fieldset>
			<fieldset>
			<?php	echo $this->Form->input('username');?>
			</fieldset>
			<?php echo $this->Form->input('role', ['value'=>'client','type'=>'hidden']);	?>
			<fieldset >
			<?php echo $this->Form->select('perfile_id', $perfiles);	?>
			</fieldset>
			<fieldset >
			<label for="activo" >Password</label>	
			<?php echo $this->Form->password('password');?>
			</fieldset>
			<fieldset >
			<label for="activo" >Confirme Password</label>	
			<?php echo $this->Form->password('password_confirm');?>
			</fieldset>
			<fieldset>
			<div class="input select">
				<label for="activo" >Super Usuario</label>			
				<?php	echo $this->Form->checkbox('super', ['hiddenField' => true]);?>
			</div>
			</fieldset>
			</div><div class="clear"></div>
			<footer>
				<div class="submit_link">
				<?= $this->Form->button(__('Guardar')) ?>
				<?= $this->Form->end() ?>
				</div>
			</footer>
		</article><!-- end of post new article -->

