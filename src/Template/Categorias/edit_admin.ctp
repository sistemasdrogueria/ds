<div class="clear"></div>

<article class="module width_full">
	<?= $this->Form->create($categoria); ?>
	<header><h3><?= $titulo ?></h3></header>
	<div class="module_content">

		<fieldset >
			<?php	echo $this->Form->input('nombre');?>
		</fieldset>
		<fieldset >
			<?php	echo $this->Form->input('descripcion');?>
		</fieldset>

	</div><div class="clear"></div>
	<footer>
				<div class="submit_link">
					
					
				<?= $this->Form->button(__('Guardar')) ?>
				<?= $this->Form->end() ?>
				</div>
	</footer>
</article>