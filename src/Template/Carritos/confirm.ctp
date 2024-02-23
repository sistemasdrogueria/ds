<div class="col-md-5">
<div class="product-item-3"> 
<div class="product-content">
<div class="row">
<div class="col-md-12 col-sm-12">
<?php echo $this->element('carrito_confirm_client'); ?>
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
</div> <!-- /.product-content -->
<div class="product-content">
<div class="row">    
<?= $this->Form->create('pedidos',['url'=>['controller'=>'Pedidos','action'=>'add']]); ?>
<div class="col-md-12 col-sm-12">
<?php echo $this->element('carrito_confirm_clientenvio'); ?>
</div> <!-- /.col-md-12 -->
<div class="buttons-holder">
<div class="button-holder">
<?= $this->Html->link(__('Continuar Comprando'), ['controller' => 'Carritos', 'action' => 'index'],['class'=>'red-btn']) ?>
</div>		 
<div class="button-holder">
<?= $this->Form->submit('Confirmar Pedido',['class'=>'sendbtn','onclick'=>"return control();"]);?>
<?= $this->Form->end() ?>	
</div> <!-- /.button-holder -->
</div> <!-- /.buttons-holder -->
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="modal fade"  style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;"data-keyboard="false" data-backdrop="static" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
</div>
<!-- Modal body with image -->
<div class="modal-body-intro">
<?php 
if(!is_null($confirm1))
{
if ($confirm1['url_campo']!='' && $confirm1['url_campo2']!='')
{
if ($confirm1['url_campo']!='preventa')
{
if ($confirm1['url_controlador']=="URL")
{
echo '<a href="'.$confirm1['url_campo'].'" target ="_blank">'.$this->Html->image('publicaciones/'.$confirm1['imagen'], ['alt' => 'LINK','width'=>'100%']) .'</a>';
}
else
echo $this->Html->image('publicaciones/'.$confirm1['imagen'],['url'=>['controller'=>$confirm1['url_controlador'],'action'=>$confirm1['url_metodo'],$confirm1['url_campo'],$confirm1['url_campo2']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
else
{
echo $this->Html->link('linkoculto',['controller'=>$confirm1['url_controlador'],'action'=>$confirm1['url_metodo'],$confirm1['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$confirm1['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else
if ($confirm1['url_campo']!='')
{
if ($confirm1['url_campo']!='preventa')
echo $this->Html->image('publicaciones/'.$confirm1['imagen'],['url'=>['controller'=>$confirm1['url_controlador'],'action'=>$confirm1['url_metodo'],$confirm1['url_campo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$confirm1['url_controlador'],'action'=>$confirm1['url_metodo'],$confirm1['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$confirm1['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else
if (!is_null($confirm1['laboratorio_id']))
echo $this->Html->image('publicaciones/'.$confirm1['imagen'],['url'=>['controller'=>$confirm1['url_controlador'],'action'=>$confirm1['url_metodo']," ",$confirm1['laboratorio_id']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
echo $this->Html->image('publicaciones/'.$confirm1['imagen'],['id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
?>
</div>

<div class="moda-footer-intro">
<button class="btn-continuar"onclick="closedivbutton(1)"  >Continuar</button>
</div>
</div>
</div>
</div>
<div class="modal fade" style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;" data-keyboard="false" data-backdrop="static" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro"data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<!-- Modal body with image -->
<div class="modal-body-intro" onclick="closediv()">
<?php if(!is_null($confirm2))
{
if ($confirm2['url_campo']!='' && $confirm2['url_campo2']!='')
{
if ($confirm2['url_campo']!='preventa')
{
if ($confirm2['url_controlador']=="URL")
{
echo '<a href="'.$confirm2['url_campo'].'" target ="_blank">'.$this->Html->image('publicaciones/'.$confirm2['imagen'], ['alt' => 'LINK','width'=>'100%']) .'</a>';
}
else
echo $this->Html->image('publicaciones/'.$confirm2['imagen'],['url'=>['controller'=>$confirm2['url_controlador'],'action'=>$confirm2['url_metodo'],$confirm2['url_campo'],$confirm2['url_campo2']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
else
{
echo $this->Html->link('linkoculto',['controller'=>$confirm2['url_controlador'],'action'=>$confirm2['url_metodo'],$confirm2['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$confirm2['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else
if ($confirm2['url_campo']!='')
{
if ($confirm2['url_campo']!='preventa')
echo $this->Html->image('publicaciones/'.$confirm2['imagen'],['url'=>['controller'=>$confirm2['url_controlador'],'action'=>$confirm2['url_metodo'],$confirm2['url_campo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$confirm2['url_controlador'],'action'=>$confirm2['url_metodo'],$confirm2['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$confirm2['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else
if (!is_null($confirm2['laboratorio_id']))
echo $this->Html->image('publicaciones/'.$confirm2['imagen'],['url'=>['controller'=>$confirm2['url_controlador'],'action'=>$confirm2['url_metodo']," ",$confirm2['laboratorio_id']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
echo $this->Html->image('publicaciones/'.$confirm2['imagen'],['id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
?>

</div>

<div class="moda-footer-intro">
<button class="btn-continuar"onclick="closedivbutton(2)"  >Continuar</button>
</div>
</div>
</div>
</div>

<div class="col-md-7">
<div class="product-item-3">
<div class="product-thumb">
<?php echo $this->element('carrito_confirm_resum'); ?>
</div> <!-- /.product-thumb -->
<div class="product-content">
<?php echo $this->element('carrito_confirm_result'); ?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<script>
var codigocliente =<?php  echo $this->request->session()->read('Auth.User.codigo');?>;
var $confirm1=0;
var $confirm2=0;
var $confirm1=<?php if(!empty($confirm1)){if(empty($this->request->session()->read('confirm1'))){echo '0';}else echo '1';}else echo '1';?>;
var $confirm2=<?php if(!empty($confirm2)){if(empty($this->request->session()->read('confirm2'))){echo '0';}else echo '1';}else echo '1';?>;
var $confirmX=<?php if(!empty($confirm1)){if($confirm1['url_campo']!='preventa')echo '0';else echo '1';}else echo '0';?>;
if($confirm1>0){document.getElementById("exampleModal").style.display="none";<?php //echo $this->request->session()->write('confirm1',1)?>window.scrollTo(0,0)}
if($confirm2>0){document.getElementById("exampleModal2").style.display="none";<?php //echo $this->request->session()->write('confirm1',1)?>window.scrollTo(0,0)}
$(document).ready(function(){
/*if($confirm1<1 && $confirmX<1){$("#dialog-message").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,

buttons:	{
'Continuar'			: function(){$(this).dialog("close")},
'Agregar al Carrito': function(){

var conf1 = document.getElementById('conf_img1');
if (conf1 instanceof HTMLImageElement)
{
// Using parentNode to get the image element parent - the anchor element.
//alert(conf1.parentNode.getAttribute('href'));
//console.log(el.parentNode.getAttribute('href'));
}

location.href = conf1.parentNode.getAttribute('href');  $(this).dialog("close")}
}
});
window.scrollTo(0,0)}*/
if($confirm1<1 && $confirmX<1 && codigocliente !==65862 )
{  $('#exampleModal').modal(
{backdrop: false 
},'show');}
if($confirm1<1 && $confirmX>0  && codigocliente !==65862){$('#exampleModal').modal(
{backdrop: false 
},'show');}
if($confirm2<1  && codigocliente !==65862){   $('#exampleModal2').modal({
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