<style>/* jssor slider loading skin spin css */
.jssorl-009-spin img {animation-name: jssorl-009-spin;animation-duration: 1.6s;animation-iteration-count: infinite;animation-timing-function: linear;}
@keyframes jssorl-009-spin {from {transform: rotate(0deg);}to {transform: rotate(360deg);}}
.jssorb031 {position:absolute;}
.jssorb031 .i {position:absolute;cursor:pointer;}
.jssorb031 .i .b {fill:#000;fill-opacity:0.5;stroke:#fff;stroke-width:1200;stroke-miterlimit:10;stroke-opacity:0.3;}
.jssorb031 .i:hover .b {fill:#fff;fill-opacity:.7;stroke:#000;stroke-opacity:.5;}
.jssorb031 .iav .b {fill:#fff;stroke:#000;fill-opacity:1;}
.jssorb031 .i.idn {opacity:.3;}
.col-item {padding: 0;/*border: 5px solid #fff;*/background: 0 0;/*margin-bottom: 15px;*/}
.col-item .photo {position: relative;max-width : 250px;text-align: center;font-size: 15px;}
.col-item .photo a .bg_promo {position: absolute;left: 0;right: 0;top: 0;bottom: 0;background-color: #0d1217;opacity: 0;z-index: 2;}
.col-item .photo a .btn_bg_promo {position: absolute;left: 0;right: 0;margin: 0 auto;top: 130px;width: 130px;padding: 10px 20px 8px;background: #1b82c5;color: #fff;text-align: center;z-index: 3;opacity: 0;}
.col-item .photo a img, .col-item .photo img {margin: 0 auto;/*width: 100%;*/z-index: 1;}
.contenido3 {align-items: center;  display: flex;    flex-wrap: wrap;  justify-content: center; }
.row {/*margin-top : 15px;display: flex;*/}
.contx{ margin: 5px;  }
</style>
<div class="col-md-12">
<!-- div class="product-item-3" --> 
<div class="product-content3">
<div class="hero_wrapper">
<!-- div class="container" -->
<div class="hero_section">
<div class="row" style=" margin-right: 0px; margin-left: 0px; margin-top: 0px;" >
<div class="col-lg-12 col-sm-12" style="padding-right: 0px; padding-left: 0px;">
<div class="imagen_pres">
<div style=" height: 100%; width: 100% ;margin: 0 auto;">
<div id="gallery" style="margin: 0 auto; " >
<div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1300px; height: 480px; overflow: hidden;">
<!-- Slides Container -->
<div data-u="slides" style="position: absolute; left: 0px; top: 0px; width: 1300px; height: 480px; overflow: hidden;">
<?php
foreach ($incorporations as $incorporation): 
$directorio="incorporations/";
switch ($incorporation['incorporations_tipos_id']) {
case 1:
$directorio.='selectivas/';
break;
case 2:
$directorio.='semiselectivas/';
break;
case 3:
$directorio.='dermo/';
break;
case 4:
$directorio.='makeup/';
break;
case 5:
$directorio.='solares/';
break;
case 6:
$directorio.='perfumerias/';
break;
case 14:
$directorio.='estetica/';
break;
}
//echo '<div>'.$this->Html->image($directorio.$incorporation['imagen'],['data-u'=>'image']).'</div>';
if ($incorporation['url_metodo']!='')    
{
if ($incorporation['url_campo']!='')
{
echo '<div>'. $this->Html->image($directorio.$incorporation['imagen'],['url'=>['controller'=>$incorporation['url_controlador'],'action'=>$incorporation['url_metodo'],$incorporation['url_campo']],'data-u'=>'image','alt'=>'Drogueria Sur S.A.','width'=>'100%']).'</div>';
}
else
if ($incorporation['url_metodo']!='search')
echo '<div>'. $this->Html->image($directorio.$incorporation['imagen'],['url'=>['controller'=>$incorporation['url_controlador'],'action'=>$incorporation['url_metodo']],'data-u'=>'image','alt'=>'Drogueria Sur S.A.','width'=>'100%']).'</div>';
else
echo '<div>'. $this->Html->image($directorio.$incorporation['imagen'],['data-u'=>'image','width'=>'100%']).'</div>';
}
else
echo '<div>'. $this->Html->image($directorio.$incorporation['imagen'],['data-u'=>'image','width'=>'100%']).'</div>';
/*if ($incorporation['descripcion']=="PARTNERS")
{
echo '<div><a href="'.$incorporation['url_campo'].'" target ="_blank">'.$this->Html->image($directorio.$incorporation['imagen'], ['alt' => 'Ferreira','width'=>'95%']) .'</a></div>';
}
else*/
endforeach; ?>
</div>
<div data-u="navigator" class="jssorb031" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
<div data-u="prototype" class="i" style="width:16px;height:16px;">
<svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
<circle class="b" cx="8000" cy="8000" r="5800"></circle>
</svg>
</div>
</div><!--#endregion Bullet Navigator Skin End -->
</div><!-- Jssor Slider End -->
</div>
</div>
</div>
</div>
</div> 
</div>
</div><!-- /div -->
</div> <!-- product-content3 -->
<!-- BOTONES RECTANGULAR CON IMAGEN FONDO NEGRO-->
<div class="product-item-3"> 
<div class="product-content3">
<div class=row style="margin-top : 30px; margin-bottom : 10px;" >
<div class="contenido3">
<div class="contx">
<div class="col-item">
<div class="photo">
<?php echo " ";?>   
<?php echo $this->Html->image('BOTON-DELIA-RECTANGULAR-FRAGANCIAS.png',['url'=>['controller'=>'DeliaPerfumerias','action'=>'fragancia']], ['alt' => '']);?>
</div>
</div>   
</div> <!-- /.col-md-3 -->
<div class="contx">
<div class="col-item">
<div class="photo">
 
<?php echo $this->Html->image('BOTON-DELIA-RECTANGULAR-DERMO.png',['url'=>['controller'=>'DeliaPerfumerias','action'=>'dermo']], ['alt' => '']);?>
</div>
</div>   
</div> <!-- /.col-md-3 -->
<div class="contx">
<div class="col-item">
<div class="photo">
 <?php echo $this->Html->image('BOTON-DELIA-RECTANGULAR-ESTETICA2.png',['url'=>['controller'=>'DeliaPerfumerias','action'=>'estetica']], ['alt' => '']);?>
</div>
</div>   
</div> <!-- /.col-md-3 -->
<div class="contx">
<div class="col-item">
<div class="photo">
<?php echo $this->Html->image('BOTON-DELIA-RECTANGULAR-SOLARES.png',['url'=>['controller'=>'DeliaPerfumerias','action'=>'solares']], ['alt' => '']);?>
</div>
</div>   
</div> <!-- /.col-md-3 -->

<div class="contx">
<div class="col-item">
<div class="photo">
<?php echo $this->Html->image('BOTON-DELIA-RECTANGULAR-MAKEUP.png',['url'=>['controller'=>'DeliaPerfumerias','action'=>'makeup'] ], ['alt' => '']);?>
</div>
</div>   
</div> <!-- /.col-md-3 -->
</div>
</div> <!-- /.row -->
</div>
</div>

<div class="product-item-3"> 
<div class="product-content3">
<!--div class='row'><div class=contenido3><h3>Fragancias Selectivas</h3></div></div></br -->
<div class=row style="margin-top : 15px;" >
<div class="contenido3"> 
<?php
echo $this->Html->image('logo_delia_p.png', ['alt' => '','width' => 125]);?>
</div>
<!--div class="contenido3">
<?php //foreach ($marcas2 as $marca): ?>
<div class="fraganciamarcadiv">
<div  align="center">
<?php 
//$uploadPath = 'marcas/';
//if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$marca['imagen'] ))
//echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 125]);
//else
//echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 125, 'url' => ['controller' => 'DeliaPerfumerias', 'action' => 'resultfragancia',$marca['id'] ,0]]);
?> 
</div> 
</div>
<?php //endforeach; ?>
</br><div class='' style='text-align: right;'>
</div>
</div -->
</div> <!-- /.row -->
</div>
</div>
</div> <!-- col-md-12 -->
<!--/div -->
<!--/div -->	
<!--/div -->
<?php echo $this->Html->script('jssor.slider.min');?>
<script> jQuery(document).ready(function ($) {
var options = {
$FillMode: 2,//[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
$AutoPlay: 1,//[Optional] Auto play or not, to enable slideshow, this option must be set to greater than 0. Default value is 0. 0: no auto play, 1: continuously, 2: stop at last slide, 4: stop on click, 8: stop on user navigation (by arrow/bullet/thumbnail/drag/arrow key navigation)
$Idle: 1000,//[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
$PauseOnHover: 1,//[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
$ArrowKeyNavigation: 1,//[Optional] Steps to go for each navigation request by pressing arrow key, default value is 1.
$SlideEasing: $Jease$.$OutQuint,                    //[Optional] Specifies easing for right to left animation, default value is $Jease$.$OutQuad
$SlideDuration: 1500,//[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
$MinDragOffsetToSlide: 20,//[Optional] Minimum drag offset to trigger slide, default value is 20
$SlideSpacing: 0,//[Optional] Space between each slide in pixels, default value is 0
$UISearchMode: 1,//[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
$PlayOrientation: 1,//[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
$DragOrientation: 1,//[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)
$BulletNavigatorOptions: {//[Optional] Options to specify and enable navigator or not
$Class: $JssorBulletNavigator$,//[Required] Class to create navigator instance
$ChanceToShow: 2,//[Required] 0 Never, 1 Mouse Over, 2 Always
$SpacingX: 8,//[Optional] Horizontal space between each item in pixel, default value is 0
$Orientation: 1//[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
},
$ArrowNavigatorOptions: {//[Optional] Options to specify and enable arrow navigator or not
$Class: $JssorArrowNavigator$,//[Requried] Class to create arrow navigator instance
$ChanceToShow: 2//[Optional] Steps to go for each navigation request, default value is 1
}
};
var jssor_slider1 = new $JssorSlider$("slider1_container", options);
//responsive code begin you can remove responsive code if you don't want the slider scales while window resizing
function ScaleSlider() {
var bodyWidth = document.body.clientWidth;
if (bodyWidth)
jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
else
window.setTimeout(ScaleSlider, 30);
}
ScaleSlider();
$(window).bind("load", ScaleSlider);
$(window).bind("resize", ScaleSlider);
$(window).bind("orientationchange", ScaleSlider);
//responsive code end
});
</script>