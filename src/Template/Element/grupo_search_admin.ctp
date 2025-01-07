<style>
.input_date_input_search_i{ padding: 5px;}
.form_search {    display: flex;    justify-content: center;    align-items: center;    margin: 0 auto;     padding-top: 20px;   padding-bottom: 20px;    flex-wrap: wrap; }
.input_date_search,.input_text_search,.submit_link_2 {    display: flex;    flex-direction: row;    align-items: center;    /* Espacio entre los elementos */}
.input_date_input_search_i {    width: 150px;padding: 10px;}
.submit_link_2 {    margin-left: 10px; padding:0;}
#fechadesde, #fechahasta {     padding: 10px;}
#button_search{    height: 39px;}
.tablesorter td { border-left: 1px dotted #ccc;}
.header{ text-align: center;}
.colcenter{ text-align: center;}
</style>
<div class="form_search">
<?= $this->Form->create('',['url'=>['controller'=>'Grupos','action'=>'index_admin'],'id'=>'searchform4']); ?>

<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino', ['class'=>'input_date_input_search_i','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Producto']); ?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?php echo $this->Form->input('grupotipo', ['class'=>'input_date_input_search_i','label'=>'','options' => $grupostipos,'empty'=>'Tipo de Grupos']);?>
</div>
</div>
<div class=submit_link_2>
<?= $this->Form->submit('Buscar', ['class' => 'submit_link', 'id' => 'button_search']); ?>
</div>
<?= $this->Form->end() ?>

</div>

