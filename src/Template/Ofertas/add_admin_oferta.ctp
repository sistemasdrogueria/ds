<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>

<?= $this->Form->create($oferta) ?>
<fieldset>
<?php echo $this->Form->input('articulo_id', ['options' => $articulos, 'empty' => true]); ?>
</fieldset>		
<fieldset>	
<?php echo $this->Form->input('descripcion'); ?>
</fieldset>		
<fieldset>	
<?php echo $this->Form->input('descuento_producto'); ?>
</fieldset>		
<fieldset>	
<?php echo $this->Form->input('unidades_minimas');	?>
</fieldset>	
<fieldset>	
<?php echo $this->Form->input('unidades_maximas'); ?>
</fieldset>		
<fieldset>	
<div class="input_date_search">
<div class="input_date_input_search">
<?= $this->Form->input('fecha_desde', ['label'=>'Desde:','id'=>'fecha_desde','name'=>'fecha_desde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="input_date_input_search">
<?=	$this->Form->input('fecha_hasta', ['label'=>'Hasta:','id'=>'fecha_hasta','name'=>'fecha_hasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','onchange'=>'javascript:document.confirmInput.submit();']);?>
</div>
</div>
</fieldset>
<fieldset>	
<?php echo $this->Form->input('plazos');?>
</fieldset>		
<fieldset>	
<?php echo $this->Form->input('oferta_tipo_id');?>
</fieldset>		
<fieldset>	
<?php echo $this->Form->input('imagen');?>
</fieldset>		
<fieldset>	
<label for="activo" >Activo</label>	
<?php	echo $this->Form->checkbox('activo', ['hiddenField' => true]);?>
</fieldset>		
<fieldset>	
<label for="activo" >Habilitada</label>	
<?php	echo $this->Form->checkbox('habilitada', ['hiddenField' => true]);?>
</fieldset>
<fieldset>
<?= $this->Form->button(__('GUARDAR')) ?>
<?= $this->Form->end() ?>
</fieldset>

</article> 