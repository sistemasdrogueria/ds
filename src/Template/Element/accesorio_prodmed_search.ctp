<style>
#searchform6 input.mainBtn{border:0;outline:0;padding:10px;color:#fff;background:#8EA800;margin:2px;min-width:125px; font-size: 18px; }
#searchform6 input[type="text"]{ margin:2px 2px 0;-webkit-margin-before:0; display: inline-block; min-width:200px;}
#searchform6 input[type="select"]{ margin:2px 2px 0;-webkit-margin-before:0; display: inline-block;}
#searchform6 label{display:none}
#searchform6 select{background:#fff;padding:10px 10px 9px 8px;margin:2px}
.input.text{display: inline-block;}
</style>
<?php  $laboratorios=$_SESSION['Laboratorios2']; ?>
<div style =" text-align: center;">
<div class="search-form-new" style='text-align:center;'>
<?= $this->Form->create('PatagoniaMed',['url'=>['controller'=>'AccesoriosYProductosMedicos','action'=>'search'],'id'=>'searchform6','onsubmit'=>'return validar();']); ?>
<?php
echo "<div style='display: inline-block; '>";
echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscarprodmed','name'=>'terminobuscar','value'=>'', 'class'=>'terminobuscarprodmed','type'=>'text','placeholder'=>'Buscar Producto']);
echo "</div>";
echo "<div style='display: inline-block;'>";
echo $this->Form->input('laboratorio_id', ['label'=>'','options' => $laboratorios,'class'=>'prodmedicoid','empty'=>'Todos los Laboratorios']);
echo "</div>";
echo "<div style='display: inline-block;' >";
echo $this->Form->submit('Buscar',['class'=>'mainBtn']);

echo "</div>";
echo "<div style='display: inline-block; margin-left:10px;'>". $this->Html->image('icn_volver.png', ['url'=>['controller'=>'AccesoriosYProductosMedicos','action'=>'index'],'alt' => 'volver'])."</div>";
echo $this->Form->end(); 
?>
</div> 
</div>
<script>
function validar(){
//Almacenamos los valores
var nombre=$('#terminobuscar').val();
var laboratorio=$('#laboratorio-id').val();
//Comprobamos la longitud de caracteres
if (nombre.length>2){ 
return true;
}
else {

if (laboratorio.length>0)
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