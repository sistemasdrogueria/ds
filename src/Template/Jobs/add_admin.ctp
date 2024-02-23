<div class="clear"></div>
<article class="module width_full">
<?= $this->Form->create($job, ['url'=>['controller'=>'Jobs','action'=>'add_admin']]) ?>
<header>
<legend><h3><?= h($titulo) ?></h3></legend>
</header>
<div class="module_content">
<fieldset>
<?php	echo $this->Form->input('titulo',['label'=>'Nombre del Puesto']);?>
<?php	echo $this->Form->control('sector_id', ['options' => $sectors],['empty' => '(Seleccionar)']);?>
<?php	echo $this->Form->control('puesto_id', ['options' => $puestos],['empty' => '(Seleccionar)']);?>
</fieldset><fieldset>
<label>Disponibilidad</label>
<?php echo $this->Form->select('disponibilidad',['FULL_TIME'=>'FULL_TIME', 'PART_TIME'=>'PART_TIME'],['empty' => '(Seleccionar)']);?>
<label>Edad</label>
<?php echo $this->Form->select('edad',['18 - 30'=>'18 - 30','25 - 35'=>'25 - 35', '31 - 40'=>'31 - 40','+40'=>'+40'],['empty' => '(Seleccionar)']);?>
<label>Nivel Exigido</label>
<?php echo $this->Form->select('nivel_educacion',['Secundario'=>'Secundario', 'Terciario'=>'Terciario','Universitario'=>'Universitario'],['empty' => '(Seleccionar)']);?>
<label>Sexo</label>
<?php echo $this->Form->select('sexo',['Masculino'=>'Masculino', 'Femenino'=>'Femenino','Indistinto'=>'Indistinto'],['empty' => '(Seleccionar)']);?>
</fieldset>
<fieldset>
<label>Horario</label>
<?php echo $this->Form->select('horario',['Mañana-Tarde'=>'Mañana-Tarde', 'Tarde-Noche'=>'Tarde-Noche'],['empty' => '(Seleccionar)']); ?>
</fieldset>
<fieldset>
<div class="input select">
<?php echo $this->Form->control('cantidad_vacante'); ?>
</div>
</fieldset>
<fieldset>
<?php	echo $this->Form->control('tareas',['label'=>'Tareas a realizar']); ?>
</fieldset>
<fieldset>
<?php	echo $this->Form->control('requerimiento',['label'=>'+ requerimientos']); ?>
</fieldset>
<fieldset>		
<?= $this->Form->input('fecha', ['label'=>'fecha:','id'=>'fechadesde','name'=>'fecha', 'type'=>'text','placeholder'=>'Fecha']);?>
</fieldset>
<fieldset>
<label for="activo" >Activa</label>			
<?php	echo $this->Form->checkbox('activo', ['hiddenField' => true]);?>
</fieldset>
</div><div class="clear"></div>
<footer>
<div class="submit_link">
<?= $this->Form->button(__('Guardar')) ?>
<?= $this->Form->end() ?>
</div>
</footer>
</article><!-- end of post new article -->