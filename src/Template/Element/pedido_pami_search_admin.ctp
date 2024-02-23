<div class="form_search">
<?= $this->Form->create('Pedidos',['url'=>['controller'=>'Pedidos','action'=>'pami_admin'],'id'=>'searchform4']); ?>
<div class="input_date_search">
<div class="input_date_input_search">
<?= $this->Form->input('fechadesde', ['label'=>'Desde:','class'=>'input_date_input_search_i','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="input_date_input_search">
<?=	$this->Form->input('fechahasta', ['label'=>'Hasta:','class'=>'input_date_input_search_i','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','onchange'=>'javascript:document.confirmInput.submit();']);?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino', ['label'=>'','type'=>'text','class'=>'input_date_input_search_i','placeholder'=>'Buscar x Producto']); ?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino2', ['label'=>'','type'=>'text','class'=>'input_date_input_search_i','placeholder'=>'Buscar x Número']); ?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino3', ['label'=>'','type'=>'text','class'=>'input_date_input_search_i','placeholder'=>'Buscar x Cliente']); ?>
</div>
</div>
<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>