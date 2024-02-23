<div class="form_search">
<?= $this->Form->create('',['url'=>['controller'=>'marcas','action'=>'index_admin'],'id'=>'searchform4']); ?>

<div class="input_text_search">
<?= $this->Form->input('termino', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Producto']); ?>
</div>

<div class="input_select_search">
<?php echo $this->Form->input('marcatipo', [   
    'class'=>'terminobusquedaselect','label'=>'','onchange'=>'this.form.submit();','label'=>'','options' => $marcastipos,'empty'=>'Tipo de Marcas']);?>
</div>
<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>

</div>