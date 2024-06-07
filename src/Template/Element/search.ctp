<div class="search-form">
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'search'],'id'=>'searchform5','class'=>'carrito_search_form','style'=>'text-transform:capitalize;','onsubmit'=>'return validar()']); ?>
<?php // $this->Form->create('',['url'=>'','id'=>'searchform6','class'=>'carrito_search_form','onsubmit'=>'return validar()']); ?>
<?php
$ofertastipo= [1=>'Perfumería y Acces.', 2=>'Patagonia Med', 3=>'Todas las Ofertas'];
echo $this->Form->input('terminobuscar', ['tabindex'=>1,'label'=>'','id'=>'terminobuscar','name'=>'terminobuscar','value'=>'', 'type'=>'text','placeholder'=>'Buscar Producto','style'=>'height: 41px;width: 200px']);
//echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar','value'=>'', 'type'=>'text','placeholder'=>'Buscar Producto','style'=>'height: 41px;max-width: 180px;'/*, 'onchange'=>'javascript:document.confirmInput.submit()','style'=>'width: 15%'*/]);
echo $this->Form->input('monodroga_id', ['options' => $Monodrogas,  'label'=>'',/*'onchange'=>'clickbusqueda();',*/'empty'=>'Monodroga','class'=>'monodroga_id']);
echo $this->Form->input('accionfar_id', ['options' => $AccionesFars,/*'onchange'=>'clickbusqueda();',*/'label'=>'', 'empty'=>'Acción Terapeutica','class'=>'accionfar_id']);
echo $this->Form->input('laboratorio_id', ['label'=>'','options' => $laboratorios,/*'onchange'=>'clickbusqueda();',*/'empty'=>'Laboratorios','class'=>'laboratorio_id']);
echo $this->Form->input('ofertas', ['label'=>'','options' => $ofertastipo,'empty'=>'Ofertas'/*,'onchange'=>'clickbusqueda();'*/,'class'=>'ofertas']);
?>	
<div id=checkbarra>
<?php
echo $this->Form->checkbox('codigobarras', ['hiddenField' => false,'onclick'=>'validarChech();' ,'value'=> 0,'id'=>'codigobarras']);
echo $this->Html->image('cb.png',['id'=>'cbarras','alt'=>'Buscar por codigo de barras']);?>
<input type="hidden" value="0" class="search_barra_texto"  name="search_barra_texto">
</div>
<?php 
echo $this->Form->submit('Buscar',['class'=>'mainBtn']);
echo $this->Form->end() 
?>
</div>
<div> <span id="elSpan"></span></div>

<script>
document.getElementById("terminobuscar").focus();
function validar(){
//Almacenamos los valores
var nombre=$('#terminobuscar').val();
var laboratorio=$('#laboratorio-id').val();
var monodroga=$('#monodroga-id').val();
var accionfar=$('#accionfar-id').val();
var ofertas=$('#ofertas').val();
//Comprobamos la longitud de caracteres
if (nombre.length>2){ 
return true;
}
else {

if ((laboratorio.length>0) || (monodroga.length>0) || (accionfar.length>0) || (ofertas.length>0) )
{

return true;
}
else
{
var mensaje= 'Minimo 3 caracteres';
alert(mensaje);
return false;		
}
}
}

$(document).ready(function(){
    $("#terminobuscar").keydown(function(e){
        if(e.which==17 ){
            e.preventDefault();
        }
    })
});
$('#terminobuscar').on('keyup', function() {
    var input = $(this).val();
    var sanitizedInput = input.replace(/[^a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\'\_\"\.\-]/g, '');
    $(this).val(sanitizedInput);
});

$('#monodroga-id,#accionfar-id,#accionfar-id,#laboratorio-id').on("change", function(){

$( "#searchform5" ).submit();

});
$("#codigobarras").on("change", function(){
        if ($("#codigobarras").is(":checked")) {
          var texto=  $("#terminobuscar").val();
          caracteres = isNaN(texto);
            if(caracteres){
            $('.search_barra_texto').val(1);
             $('#codigobarras').val(1);
            }else{
                 $('#codigobarras').val(1);
            }
        }
 });

 $("#terminobuscar").on("blur", function(event){
        if ($("#codigobarras").is(":checked")) {
    var texto=  $("#terminobuscar").val();
          caracteres = isNaN(texto);
            if(caracteres){
                $('.search_barra_texto').val(1);
            }else{             
            }
        }
     });
$('.monodroga_id').select2();
            $('.accionfar_id').select2();
                $('.laboratorio_id').select2();
                         $('.ofertas').select2();
</script>
