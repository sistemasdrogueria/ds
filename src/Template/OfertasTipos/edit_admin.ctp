<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>

<?= $this->Form->create($ofertasTipo) ?>
<fieldset>
<?php echo $this->Form->input('nombre'); ?>
</fieldset>		
<fieldset>	
<?php echo $this->Form->input('orden');	?>
</fieldset>	
<fieldset>	
<?php echo $this->Form->input('ubicacion'); ?>
</fieldset>		
<fieldset>	
<label for="activo" >Activo</label>	
<?php	echo $this->Form->checkbox('activo', ['hiddenField' => true]);?>
</fieldset>		
<fieldset>
<?= $this->Form->button(__('GUARDAR')) ?>
<?= $this->Form->end() ?>
</fieldset>

</article> 
