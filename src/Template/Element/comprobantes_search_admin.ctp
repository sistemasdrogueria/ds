<style>
.input_date_input_search_i{ padding: 5px;}
.form_search {    display: flex;    justify-content: center;    align-items: center;    margin: 0 auto;     padding-top: 20px;   padding-bottom: 20px;    flex-wrap: wrap; }
.input_date_search,.input_text_search,.submit_link_2 {    display: flex;    flex-direction: row;    align-items: center;    /* Espacio entre los elementos */}
.input_date_input_search_i {    width: 120px;padding: 10px;}
.submit_link_2 {    margin-left: 10px; padding:0;}
#fechadesde, #fechahasta {     padding: 10px;}
#button_search{    height: 39px;}
</style>

<div class="form_search" style="height: 90px;">
<?= $this->Form->create('null',['url'=>['controller'=>'Comprobantes','action'=>'search_admin'],'id'=>'searchform4','onsubmit'=>'return validar()']); ?>

<div class="input_date_search">
<div class="input_date_input_search">
<?= $this->Form->input('fechadesde', ['label'=>'','class'=>'input_date_input_search_i','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="input_date_input_search">
<?=	$this->Form->input('fechahasta', ['label'=>'','class'=>'input_date_input_search_i','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','onchange'=>'javascript:document.confirmInput.submit();']);?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('terminobuscarn', ['class'=>'input_date_input_search_i','label'=>'','type'=>'text' ,'placeholder'=>'N° Nota','onchange'=>'javascript:document.confirmInput.submit();']); ?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('terminobuscarf', ['class'=>'input_date_input_search_i','label'=>'','type'=>'text' ,'placeholder'=>'N° Factura','onchange'=>'javascript:document.confirmInput.submit();']); ?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('terminocliente', ['class'=>'input_date_input_search_i','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Cliente','onchange'=>'javascript:document.confirmInput.submit();']); ?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?php echo $this->Form->input('factura', ['label'=>'Factura','type'=>'checkbox','value'=>1,'checked'=>1]); ?>
<?php echo $this->Form->input('notacredito', ['label'=>'Nota de Credito','type'=>'checkbox','value'=>1,'checked'=>1]);?>
<?php echo $this->Form->input('notadebito', ['label'=>'Nota de Debito','type'=>'checkbox','value'=>1,'checked'=>1]);?>
<?php echo $this->Form->input('recibo',['label'=>'Recibo Oficial','type'=>'checkbox','value'=>1,'checked'=>1]);	//,'checked'?>
</div>
</div>
<div class=submit_link_2>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>