
<div class="form_search">
<?= $this->Form->create('',['url'=>['controller'=>'OfertasTipos','action'=>'index_admin'],'id'=>'searchform4']); ?>
<div class="input_text_search">
<?= $this->Form->input('termino', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Producto']); ?>
</div>
<div class="input_select_search">
<?php $ubicacion = array('1'=>'Exterior', '2'=>'Principal','3'=>'Tiendas','4'=>'Sliders de Producto','5'=>'Eventos Especiales');?>
<?php echo $this->Form->input('ubicacion', ['class'=>'terminobusquedaselect','label'=>'','onchange'=>'this.form.submit();','options' => $ubicacion,'empty'=>'Ubicación Oferta']);?></div>
<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>