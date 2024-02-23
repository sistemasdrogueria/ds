<div class="clear"></div>

<article class="module width_full">
	<?= $this->Form->create($categoria); ?>
	<header><h3><?= $titulo ?></h3></header>
	<div class="module_content">
    <table class="viewlabel">
	<tr>
            <th><h2>Categoria Principal</h2></th>
			<th></th>
	<tr>
		<td><h3 class="subheader"><?= __('Número') ?></h3></td>
            <td><h4><p><?= $this->Number->format($categoriaprincipal->id) ?></p></h4></td>
	</tr>
	<tr>			
            <td><h3 class="subheader"><?= __('Nombre') ?></h3></td>
            <td><h4><p><?= h($categoriaprincipal->nombre) ?></p></h4></td>
	</tr>
	<tr>    
	<td><h3 class="subheader"><?= __('Descripción') ?></h3></td>
            <td><h4><p><?= h($categoriaprincipal->descripcion) ?></p></h4></td>
	</tr>

	</table>    
          
		<h2>Sub Categoria</h2>	
	
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