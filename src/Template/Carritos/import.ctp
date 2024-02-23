<?php echo $this->Html->script('https://www.google.com/recaptcha/api.js?render=6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB'); ?>
<div class="col-md-9">
<div class="product-item-3">
<div class="product-thumb">
<div class='cliente_info_class2'>Importar desde Archivo de sistema</div>
<?php echo $this->element('carrito_import_search'); ?>
</div> <!-- /.product-thumb -->    
<div class="modal fade"  style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;"data-keyboard="false" data-backdrop="static" 
id="exampleModal"
tabindex="-1" 
role="dialog"
aria-labelledby="exampleModalLabel" 
aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;"
role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" 
class="close-intro"
data-dismiss="modal" 
aria-label="Close">
<span aria-hidden="true">
×
</span>
</button>
</div>

<!-- Modal body with image -->
<div class="modal-body-intro">
<?php if(!is_null($import1))
{
if ($import1['url_campo']!='' && $import1['url_campo2']!='')
echo $this->Html->image('publicaciones/'.$import1['imagen'],['url'=>['controller'=>$import1['url_controlador'],'action'=>$import1['url_metodo'],$import1['url_campo'],$import1['url_campo2']],'id' =>'import_img1', 'alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
if ($import1['url_campo']!='')
echo $this->Html->image('publicaciones/'.$import1['imagen'],['url'=>['controller'=>$import1['url_controlador'],'action'=>$import1['url_metodo'],$import1['url_campo']],'id' =>'import_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
echo $this->Html->image('publicaciones/'.$import1['imagen'],['url'=>['controller'=>$import1['url_controlador'],'action'=>$import1['url_metodo']],'id' =>'import_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
?>
</div>

<div class="moda-footer-intro">
<button class="btn-continuar"onclick="closedivbutton(1)"  >Continuar</button>
</div>
</div>
</div>
</div>


<div class="modal fade" style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;" data-keyboard="false" data-backdrop="static"
id="exampleModal2"
tabindex="-1" 
role="dialog"
aria-labelledby="exampleModalLabel" 
aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;"
role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" 
class="close-intro"
data-dismiss="modal" 
aria-label="Close">
<span aria-hidden="true">
×
</span>
</button>
</div>

<!-- Modal body with image -->
<div class="modal-body-intro" onclick="closediv()">
<?php if(!is_null($import2))
{ 
if ($import2['url_campo']!='' && $import2['url_campo2']!='')
echo $this->Html->image('publicaciones/'.$import2['imagen'],['url'=>['controller'=>$import2['url_controlador'],'action'=>$import2['url_metodo'],$import2['url_campo'],$import2['url_campo2']],'alt'=>'Drogueria Sur S.A.','width'=>'100%']);

else
if ($import2['url_campo']!='')
echo $this->Html->image('publicaciones/'.$import2['imagen'],['url'=>['controller'=>$import2['url_controlador'],'action'=>$import2['url_metodo'],$import2['url_campo']],'alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
echo $this->Html->image('publicaciones/'.$import2['imagen'],['url'=>['controller'=>$import2['url_controlador'],'action'=>$import2['url_metodo']],'alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
?>
</div>

<div class="moda-footer-intro">
<button class="btn-continuar"onclick="closedivbutton(2)"  >Continuar</button>
</div>
</div>
</div>
</div>

<div class="product-thumb">
<div class='cliente_info_class2'>Importar desde Archivo de excel</div>
<?php 
echo $this->element('carrito_import_excel'); 
?>
</div> 
</div> 
</div>
<div class="col-md-3">
<div class="product-item-5"> 
<div class="product-content">
<div class="row">
<?php echo $this->element('cartresumbody'); ?>
</div> 
</div> 
</div>
<div class="product-item-5">	
<div class="product-content">
<div class='cliente_info_class3'>
<?php
echo $this->Html->image('ofertaagregarcarro.png');
?>
</div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row">   
<?php echo $this->element('botonescarro'); ?>
<div class="cartresul">			
<?php echo $this->element('cartresultbody'); ?>
</div>
</div> 
</div> 
</div> 
</div> 

<script>
var codigocliente =<?php  echo $this->request->session()->read('Auth.User.codigo');?>;
var $import1=0;
var $import2=0;

var $import1=<?php if(!empty($import1)){if(empty($this->request->session()->read('import1'))){echo '0';}else echo '1';}else echo '1';?>;
var $import2=<?php if(!empty($import2)){if(empty($this->request->session()->read('import2'))){echo '0';}else echo '1';}else echo '1';?>;
if($import1>0){document.getElementById("exampleModal").style.display="none"; window.scrollTo(0,0)}
if($import2>0){document.getElementById("exampleModal2").style.display="none"; window.scrollTo(0,0)}
$(document).ready(function(){



if($import1<1  && codigocliente ) {  $('#exampleModal').modal(
{backdrop: false 
},'show');}


if($import2<1  && codigocliente){   $('#exampleModal2').modal({
backdrop: false
},'show');}
});



function closediv(){
$('#exampleModal').modal('hide');  
$('#exampleModal2').modal('hide');
$('#exampleModal3').modal('hide');      	
}

function closedivbutton(i){
if(i>1){
$('#exampleModal'+i).modal('hide');   
}else{
$('#exampleModal').modal('hide');  
}
}
</script>