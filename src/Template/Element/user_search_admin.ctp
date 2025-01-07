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

<?= $this->Form->create('Users',['url'=>['controller'=>'Users','action'=>'index_search_admin'],'id'=>'searchform4']); ?>

<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino', ['class'=>'input_date_input_search_i','label'=>'','type'=>'text' ,'placeholder'=>'Buscar']); ?>
</div></div>

<div class="input_text_search">

<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>