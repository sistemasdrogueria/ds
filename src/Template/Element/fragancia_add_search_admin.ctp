<style>
.input_date_input_search_i{ padding: 5px;}
.form_search {    display: flex;    justify-content: center;    align-items: center;    margin: 0 auto;     padding-top: 20px;   padding-bottom: 20px;    flex-wrap: wrap; }
.input_date_search,.input_text_search,.submit_link_2 {    display: flex;    flex-direction: row;    align-items: center;    /* Espacio entre los elementos */}
.input_date_input_search_i {    width: 120px;padding: 10px;}
.submit_link_2 {    margin-left: 10px; padding:0;}
#fechadesde, #fechahasta {     padding: 10px;}
#button_search{    height: 39px;}
input[type="file"]::file-selector-button {

  padding: 10px;
  border: thin solid grey;
  border-radius: 3px;
}
</style>

<div class="form_search">
<?= $this->Form->create('Fragancias', ['url'=>['controller'=>'Fragancias','action'=>'add_admin'],'type' => 'file'])?>

<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('nombre', ['label'=>'','type'=>'text','class'=>'input_date_input_search_i','placeholder'=>'Nombre']); ?>
</div>
</div>


<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('marca_id', ['class'=>'input_date_input_search_i','label'=>'','options' => $marcas,'empty'=>'MARCA']);	?>	
</div>
</div>

<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('genero_id', ['class'=>'input_date_input_search_i','label'=>'','options' => $generos,'empty'=>'GENERO']);	?>	
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?php
echo $this->Form->input('file',['type' => 'file','label'=>'' ]);?>
</div>
</div>
<div class=submit_link_2>
<?= $this->Form->button(__('Guardar'),['id'=>'button_search']) ?>
</div>
<?= $this->Form->end() ?>

</div><!-- end of .tab_container -->