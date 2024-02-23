<div class="form_search">
<?= $this->Form->create('',['url'=>['controller'=>'Incorporations','action'=>'index_admin'],'id'=>'searchform4']); ?>
<div class="input_date_search">
<div class="input_date_input_search">
<?= $this->Form->input('fechadesde', ['label'=>'','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="input_date_input_search">
<?=	$this->Form->input('fechahasta', ['label'=>'','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:'])?>
</div>
</div>
<div class="input_text_search">
<?= $this->Form->input('termino', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Producto']); ?>
</div>
<div class="input_select_search">
<?php echo $this->Form->input('tipo', ['class'=>'terminobusquedaselect','label'=>'','onchange'=>'this.form.submit();','options' => $incorporationstipos2,'empty'=>'Tipo de Incorporaciones']);?>
</div>
<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>