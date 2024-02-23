<div class=container>
<div class="col-md-12" >
<div class="product-item-3">
<div class="product-content" >
<?php
echo '<div class=row >'.$this->element('homeydeco_search').'</div>';
echo '<div class=hide   id =farmaydeco_div_grupos_search> '.'</div>';
echo '<div class=row    id = farmaydeco_row_grupos ><br>'. $this->element('homeydeco_grupos');
echo $this->element('homeydeco_sin_result'); 
echo '</div>';
?>
</div> 
<div class="modal fade"  style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;"data-keyboard="false" data-backdrop="static" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;"role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro"data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<!-- Modal body with image -->
<div class="modal-body-intro">
<?php if(!is_null($sursale))
{
if ($sursale['url_campo']!='' && $sursale['url_campo2']!='')
{
if ($sursale['url_campo']!='preventa')
{
if ($sursale['url_controlador']=="PARTNER")
{
echo '<a href="'.$sursale['url_campo'].'" target ="_blank">'.$this->Html->image('publicaciones/'.$sursale['imagen'], ['alt' => 'LINK','width'=>'100%']) .'</a>';
}
else
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['url_campo'],$sursale['url_campo2']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else
if ($sursale['url_campo']!='')
{
if ($sursale['url_campo']!='preventa')
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['url_campo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
?>
</div>

<div class="moda-footer-intro">
<button class="btn-continuar"onclick="closedivbutton(1)"  >Continuar</button>
</div>
</div>
</div>
</div><!-- /.product-content -->

<div class="modal fade" style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;" data-keyboard="false" data-backdrop="static"
id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>

<!-- Modal body with image -->
<div class="modal-body-intro" onclick="closediv()">
<?php if(!is_null($sursale2))
{ 
if ($sursale2['url_campo']!='' && $sursale2['url_campo2']!='')
{
if ($sursale2['url_campo']!='preventa')
if ($sursale2['url_controlador']=="PARTNER")
{
echo '<a href="'.$sursale2['url_campo'].'" target ="_blank">'.$this->Html->image('publicaciones/'.$sursale2['imagen'], ['alt' => 'LINK','width'=>'100%']) .'</a>';
}
else
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['url_campo'],$sursale2['url_campo2']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['descripcion']],['style'=>'display: none','id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else
if ($sursale2['url_campo']!='')
{
if ($sursale2['url_campo']!='preventa')           
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['url_campo']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['descripcion']],['style'=>'display: none','id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
?>
</div>

<div class="moda-footer-intro">
<button class="btn-continuar"onclick="closedivbutton(2)"  >Continuar</button>
</div>
</div>
</div>
</div>
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<!--div class="col-md-3">
<?php //echo $this->element('carro'); ?>
</div> <!-- /.row -->
</div--> <!-- /.product-content -->
<?php echo $this->Html->script('paginacion'); ?>
<script>
var $ingreson=0;
var $ingreson2=0;
var $ingreson3=0;
var $ingreson=<?php if(!empty($sursale)){if(empty($this->request->session()->read('ingreson'))){echo '0';}else echo '1';}else echo '1';?>;
var $ingreson2=<?php if(!empty($sursale2)){if(empty($this->request->session()->read('ingreson2'))){echo '0';}else echo '1';}else echo '1';?>;
var $ingreson3=<?php if(!empty($noticiaimportante)){if(empty($this->request->session()->read('ingreson3'))){echo '0';}else echo '1';}else echo '1';?>;
var $confirmX=<?php if(!empty($sursale)){if($sursale['url_campo']!='preventa')echo '0';else echo '1';}else echo '0';?>;
var $confirmY=<?php if(!empty($sursale2)){if($sursale2['url_campo']!='preventa')echo '0';else echo '1';}else echo '0';?>;
if($ingreson>0){document.getElementById("exampleModal").style.display="none";<?php echo $this->request->session()->write('ingreson',1)?>window.scrollTo(0,0)}
if($ingreson2>0){document.getElementById("exampleModal2").style.display="none";<?php echo $this->request->session()->write('ingreson2',1)?>window.scrollTo(0,0)}

$(document).ready(function(){
if($ingreson<1 && $confirmX>0){  $('#exampleModal').modal(
{backdrop: false 
},'show');}
else
if($ingreson<1 && $confirmX<1)
{  $('#exampleModal').modal({
backdrop: false
},'show');}
if($ingreson2<1 && $confirmY>0){
$('#exampleModal2').modal({
backdrop: false
},'show');
}
else
if($ingreson2<1 && $confirmY<1)
{$('#exampleModal2').modal({
backdrop: false
},'show');}
});
</script>