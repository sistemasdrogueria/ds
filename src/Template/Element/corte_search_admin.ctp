<style>
.input_date_input_search_i{ padding: 5px;}
</style>
<div class="form_search">
<?= $this->Form->create('',['url'=>['controller'=>'Cortes','action'=>'index_admin'],'id'=>'searchform4']); ?>
<div class="input_date_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino', ['class'=>'input_date_input_search_i','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Codigo']); ?>
</div>
<div class="input_date_input_search">
<?= $this->Form->input('transporte_id', ['class'=>'input_date_input_search_i','label'=>'','options' => $salidas,'empty'=>'Transportes']);?>
</div>
</div>
<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>