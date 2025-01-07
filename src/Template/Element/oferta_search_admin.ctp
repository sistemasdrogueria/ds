<style>
.input_date_input_search_i{ padding: 5px;}
.form_search {    display: flex;    justify-content: center;    align-items: center;    margin: 0 auto;     padding-top: 20px;   padding-bottom: 20px;    flex-wrap: wrap; }
.input_date_search,.input_text_search,.submit_link_2 {    display: flex;    flex-direction: row;    align-items: center;    /* Espacio entre los elementos */}
.input_date_input_search_i {    width: 120px;padding: 10px;}
.submit_link_2 {    margin-left: 10px; padding:0;}
#fechadesde, #fechahasta {     padding: 10px;}
#button_search{    height: 39px;}
</style>
<div class="form_search">
<?= $this->Form->create('',['url'=>['controller'=>'Ofertas','action'=>'index_admin'],'id'=>'searchform4']); ?>
<div class="input_date_search">
<div class="input_date_input_search">
<?= $this->Form->input('fechadesde', ['label'=>'','class'=>'input_date_input_search_i','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="input_date_input_search">
<?=	$this->Form->input('fechahasta', ['label'=>'','class'=>'input_date_input_search_i','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:'])?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino', ['label'=>'','type'=>'text','class'=>'input_date_input_search_i','placeholder'=>'Buscar x Producto']); ?>
</div>
</div>

<div class="input_text_search">
<div class="input_date_input_search">
<?php echo $this->Form->input('ofertatipo', ['class'=>'input_date_input_search_i','label'=>'','onchange'=>'this.form.submit();','options' => $ofertastipos2,'empty'=>'Tipo de Oferta']);?>
</div>
</div>
<div class=submit_link_2>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>