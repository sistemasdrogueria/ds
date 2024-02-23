<div class="clear"></div>
<article class="module width_full">
 <?= $this->Form->create($usuario); ?>
			<header>
			<legend><h3><?= $titulo ?></h3></legend>
			</header>
				<div class="module_content">
				
			
			<fieldset style="width:70%;float:left;">
			<?php	echo $this->Form->input('nombre');?>
			</fieldset>
			<fieldset style="width:50%; float:left; ">
			<?php	echo $this->Form->input('cliente_id', ['options' => $clientes]);?>
			</fieldset>
			<fieldset style="width:50%; float:left; ">
			<?php
			$opciones = ['admin', 'client','provider'];
		
				echo $this->Form->select('role', $opciones);?>
			</fieldset>
			<fieldset style="width:70%;float:left;">	
			<div class="input select">
				<label for="clave" >Contraseña</label>			
				<?php	echo $this->Form->user('user',['id'=>'clave']);?>
			</div>
			</fieldset>
			<fieldset style="width:70%;float:left;">
			<div class="input select">
				<label for="clave" >Confirme Contraseña</label>			
				<?php	echo $this->Form->user('clave_confirmar',['id'=>'clave_confirmar']);?>
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