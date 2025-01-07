
<style>
.all_nutricion {display: flex;flex-wrap: wrap;justify-content: center; /* Centrar horizontalmente */gap: 10px; /* Espacio entre elementos */text-decoration: none;}
.one_nutricion {display: flex;justify-content: center;align-items: center;width: 24%;margin: 5px;text-align: center;}
.one_nutricion a {font: 13px/21px "Open Sans", Arial, sans-serif;font-weight: bold;height: 150px;width: 100%;color: #154c72;font-size: 21px;display: flex;align-items: center;justify-content: center;border: 5px solid #bcd266;border-radius: 5px;text-align: center;}
</style>
<?php echo $this->element('banner_slider_nutricion'); ?>
<div class=container>
<div class="col-md-12">
<div class="product-item-3">
<div class="product-content" >
<?php
echo '<div class=row>'.$this->element('nutricion_search').'</div>';
echo '<div class=all_nutricion>';
foreach ($grupos2 as $grupo): 
echo '<div class=one_nutricion>';
echo $this->Html->link($grupo['descripcion'],['controller' => 'Nutricion', 'action' => 'search',0 ,$grupo['id'],'_full' => true]);
echo '</div>';
endforeach; 
echo '</div>';
?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
</div>
<div class="modal fade"  style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;"data-keyboard="false" data-backdrop="static" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true"> × </span>
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
if ($sursale['url_controlador']=="URL")
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
if ($sursale['url_campo']!='URL')
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

<div class="modal fade" style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;" data-keyboard="false" data-backdrop="static" id="exampleModal2"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    
function closedivbutton(i){
if(i>1){
$('#exampleModal'+i).modal('hide');   
}else{
$('#exampleModal').modal('hide');  
}
}
</script>
<?php echo $this->Html->script('jssor.slider.min');?>
<script>
jQuery(document).ready(function($) {
var options = {
$FillMode: 2,
$AutoPlay: 1,
$Idle: 1500,
$PauseOnHover: 1,
$ArrowKeyNavigation: 1,
$SlideEasing: $Jease$.$OutQuint,
$SlideDuration: 1500,
$MinDragOffsetToSlide: 20,
$SlideSpacing: 0,
$UISearchMode: 1,
$PlayOrientation: 1,
$DragOrientation: 1,
$BulletNavigatorOptions: {
$Class: $JssorBulletNavigator$,
$ChanceToShow: 2,
$SpacingX: 8,
$Orientation: 1
},
$ArrowNavigatorOptions: {
$Class: $JssorArrowNavigator$,
$ChanceToShow: 2
}
};
var jssor_sliderZ = new $JssorSlider$("slider2_container", options);

function ScaleSliderZocalo() {
var bodyWidth = document.body.clientWidth;
jssor_sliderZ.$scale
jssor_sliderZ.$ScaleWidth($("#slider_contenedor").width());
}
ScaleSliderZocalo();
$(window).bind("load", ScaleSliderZocalo);
$(window).bind("resize", ScaleSliderZocalo);
$(window).bind("orientationchange", ScaleSliderZocalo);
});
</script>