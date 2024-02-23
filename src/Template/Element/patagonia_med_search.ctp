
<style>
#searchform6 input.mainBtn{border:0;outline:0;padding:10px;color:#fff;background:#8EA800;margin:2px;min-width:125px; font-size: 18px; }
#searchform6 input[type="text"]{ margin:2px 2px 0;-webkit-margin-before:0; display: inline-block; min-width:200px;}
#searchform6 input[type="select"]{ margin:2px 2px 0;-webkit-margin-before:0; display: inline-block;}
#searchform6 label{display:none}
#searchform6 select{background:#fff;padding:10px 10px 9px 8px;margin:2px}
.input.text{display: inline-block;}
    

    /*'id'=>'searchform6', */
</style>

<div style ="
 text-align: center;">
<div class="search-form-new" style='text-align:center;'>
<?= $this->Form->create('PatagoniaMed',['url'=>['controller'=>'PatagoniaMed','action'=>'search'],'id'=>'searchform6','onsubmit'=>'return validar()']); ?>
<?php
echo "<div style='display: inline-block; '>";
echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar','value'=>'', 'type'=>'text','placeholder'=>'Buscar Producto', 'onchange'=>'javascript:document.confirmInput.submit();']);
echo "</div>";
echo "<div style='display: inline-block;'>";
echo $this->Form->input('laboratorio_id', ['label'=>'','options' => $laboratorios,'empty'=>'Todos los Laboratorios']);
echo "</div>";
echo "<div style='display: inline-block;' >";
echo $this->Form->submit('Buscar',['class'=>'mainBtn']);

echo $this->Form->end(); 
echo "</div>";
?>
</div> <!-- /.search-form -->
</div>
<script>
document.getElementById("terminobuscar").focus();
function validar(){
//Almacenamos los valores
var nombre=$('#terminobuscar').val();
var laboratorio=$('#laboratorio-id').val();
var oferta=$('#ofertas').val();
//Comprobamos la longitud de caracteres
if (nombre.length>2){ 
return true;
}
else {

if ((laboratorio.length>0) || (oferta.length>0))
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
</script>
