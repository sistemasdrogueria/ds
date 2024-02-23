<div class="form_search">
<?= $this->Form->create(null,['url'=>['controller'=>'Fragancias','action'=>'index_admin'],'id'=>'searchform4']); ?>
<div class="input_text_search">
<?php echo $this->Form->input('marcas_tipo_id', ['class'=>'input_select_search','label'=>'','onchange'=>'this.form.submit();','options' => $marcas,'empty'=>'Tipo de Marcas']);?>
</div>
<div class="input_text_search">
<?= $this->Form->input('terminobusqueda', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Producto']); ?>
</div>
<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>