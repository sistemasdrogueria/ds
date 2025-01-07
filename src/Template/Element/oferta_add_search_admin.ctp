<style>
.input_date_input_search_i{ padding: 5px;}
.form_search {    display: flex;    justify-content: center;    align-items: center;    margin: 0 auto;     padding-top: 20px;   padding-bottom: 20px;    flex-wrap: wrap; }
.input_date_search,.input_text_search,.submit_link_2 {    display: flex;    flex-direction: row;    align-items: center;    /* Espacio entre los elementos */}
.input_date_input_search_i {    width: 140px;padding: 10px !important;}
.submit_link_2 {    margin-left: 10px; padding:0;}
#fechadesde, #fechahasta {     padding: 10px;}
#button_search{    height: 39px;}
</style>
<div class="form_search">
<?= $this->Form->create(null,['url'=>['controller'=>'Ofertas','action'=>'add'],'id'=>'searchform4','onsubmit'=>'return validar()']); ?>
<?php $ofertastipo= [1=>'Perfumería y Acces.', 2=>'Patagonia Med', 3=>'Todas las Ofertas'];
?>
<div class="input_date_search">
<div class="input_date_input_search">
<?php echo $this->Form->input('terminosearch', ['label'=>'','class'=>'input_date_input_search_i','id'=>'termino','placeholder'=>'Buscar Producto', 'onchange'=>'javascript:document.confirmInput.submit();']);?>
</div>
</div>
<div class="input_date_search">
<div class="input_date_input_search">
<?php echo $this->Form->input('categoria_id', ['label'=>'','class'=>'input_date_input_search_i','options' => $categorias,'empty'=>'Toda las Categorias']);?>
</div>
</div>
<div class="input_date_search">
<div class="input_date_input_search">
<?php echo $this->Form->input('laboratorio_id', ['label'=>'','class'=>'input_date_input_search_i','options' => $laboratorios,'empty'=>'Todos los Laboratorios']);?>
</div>
</div>
<div class="input_date_search">
<div class="input_date_input_search">
<?php echo $this->Form->input('tipoofertas', ['label'=>'','class'=>'input_date_input_search_i','options' => $ofertastipo,'empty'=>'Seleccionar Ofertas']);?>
</div>
</div>
<div class=submit_link_2>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?php echo $this->Form->end() ?>
</div> <!-- /.search-form -->

<script>
document.getElementById("termino").focus();
function validar(){
//Almacenamos los valores
var nombre=$('#termino').val();
var laboratorio=$('#laboratorio-id').val();
var oferta=$('#ofertas').val();
//Comprobamos la longitud de caracteres
if (nombre.length>3){ 
return true;
}
else {

if ((laboratorio.length>1) || (oferta.length>0))
{

return true;
}
else
{
var mensaje= 'Minimo 4 caractere ';
alert(mensaje);
return false;		
}
}
}
</script>
