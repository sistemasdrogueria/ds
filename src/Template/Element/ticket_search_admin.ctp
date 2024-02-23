<style>
.input_date_input_search_i{

}
</style>
<div class="form_search">
<?= $this->Form->create('Tickets',['url'=>['controller'=>'Tickets','action'=>'index_admin_search'],'id'=>'searchform4']); ?>
<div class="input_date_search">
<div class="input_date_input_search">
<?= $this->Form->input('fechadesde', ['class'=>'input_date_input_search_i','label'=>'D:','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="input_date_input_search">
<?=	$this->Form->input('fechahasta', ['class'=>'input_date_input_search_i','label'=>'H:','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','onchange'=>'javascript:document.confirmInput.submit();']);?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino', ['class'=>'input_date_input_search_i','label'=>'','type'=>'text' ,'placeholder'=>'POR N° TICKET']); ?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino2', ['class'=>'input_date_input_search_i','label'=>'','type'=>'text' ,'placeholder'=>'POR CLIENTE']); ?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino3', ['class'=>'input_date_input_search_i','label'=>'','type'=>'text' ,'placeholder'=>'POR PRODUCTO']); ?>
</div>
</div>

<div class="input_select_search">
<div class="input_select_input_search">
<?php echo $this->Form->input('reclamos_tipo_id', ['class'=>'input_date_input_search_i','label'=>'','options' => $ReclamosTipos,'empty'=>'SELECCIONE TIPO']); ?>
</div>
</div>
<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<div>
<?= $this->Form->submit('Excel',['id'=>'buttonexcel','name'=>'btnexcel']); ?>
</div>
<?= $this->Form->end() ?>
</div>