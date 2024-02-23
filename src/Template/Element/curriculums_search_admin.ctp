<div class="form_search">
<?= $this->Form->create('Curriculums',['url'=>['controller'=>'Curriculums','action'=>'index_admin'],'id'=>'searchform4']); ?>
<div class="input_date_search">
<div class="input_date_input_search">
<?= $this->Form->input('fechadesde', ['label'=>'Desde:','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="input_date_input_search">
<?=	$this->Form->input('fechahasta', ['label'=>'Hasta:','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','onchange'=>'javascript:document.confirmInput.submit();']);?>
</div>
</div>
<div class="input_text_search">		
<?= $this->Form->input('termino', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Nombre/Apellido']); ?>
</div>
<div class="input_select_search">
<div class="input_select_input_search">
<?php echo $this->Form->input('sector_id', ['label'=>'Sector','options' => $sectors,'empty'=>'Seleccione sector']); ?>
</div>
</div>
<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>