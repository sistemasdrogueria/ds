<div class="col-md-9">
<?php echo $this->element('banner_slider'); ?>
<div class="product-thumb" id="search-backf">
<?php echo $this->element('search'); ?>
</div>
<div class="product-item-3">
<div class="product-content" style ="background-color: #f3f3f3;">
<?php if ($articulos!=null )
{echo $this->element('carrito_search_result_img'); }
else
{echo $this->element('searchsinresult'); } ?>
</div> 
<div class="product-content">
<?php echo $this->element('referencia'); ?>
</div> 
</div>
</div>
<div class="col-md-3">
<div class="product-item-5"> 
<div class="product-content">
<div class="row"> <?php echo $this->element('cartresumbody'); ?></div>
</div>
</div>
<div class="product-item-5">		
<div class="product-content">
<div class='cliente_info_class3'><?php echo $this->Html->image('icono_carrito_view.png'); ?></div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row"> <?php echo $this->element('botonescarro'); ?>
<div class="cartresul"><?php echo $this->element('cartresultbody'); ?>
</div>
</div> 
</div> 
<div id=slider_contenedor1 >
<div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto; top: 0px; left: 0px; width: 450px; height: 900px; overflow: hidden;">
<!-- Slides Container -->
<div data-u="slides" style="position: absolute; left: 0px; top: 0px; width: 450px; height: 900px; overflow: hidden;">
<?php
foreach ($this->request->session()->read('publicationsearch') as $publication): 
if ($publication['url_metodo']!='')    
{
if ($publication['url_campo']!='')
echo '<div>'. $this->Html->image('publicaciones/'.$publication['imagen'],['url'=>['controller'=>$publication['url_controlador'],'action'=>$publication['url_metodo'],$publication['url_campo']],'data-u'=>'image','alt'=>'Drogueria Sur S.A.','width'=>'100%']).'</div>';
else
echo '<div>'. $this->Html->image('publicaciones/'.$publication['imagen'],['url'=>['controller'=>$publication['url_controlador'],'action'=>$publication['url_metodo']],'data-u'=>'image','alt'=>'Drogueria Sur S.A.','width'=>'100%']).'</div>';
}
else
if ($publication['url_controlador']== "URL")
{
  echo '<div><a href="'.$publication['url_campo'].'" target = _blank _full=true>'.$this->Html->image('publicaciones/'.$publication['imagen'], ['data-u'=>'image']) .'</a></div>';
}
else
echo '<div>'. $this->Html->image('publicaciones/'.$publication['imagen'],['data-u'=>'image','width'=>'100%']).'</div>';
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
<div>
</div>
</div> 
</div> 
<?php echo $this->Html->script('jssor.slider.min');?>
<script> jQuery(document).ready(function ($) {
var options = {
$FillMode: 2,$AutoPlay: 1,$Idle: 1500,$PauseOnHover: 1,$ArrowKeyNavigation: 1,$SlideEasing: $Jease$.$OutQuint,
$SlideDuration: 1500,$MinDragOffsetToSlide: 20,
$SlideSpacing: 0,$UISearchMode: 1,$PlayOrientation: 1,$DragOrientation: 1,
$BulletNavigatorOptions: {$Class: $JssorBulletNavigator$,$ChanceToShow: 2,$SpacingX: 8,$Orientation: 1},
$ArrowNavigatorOptions: {$Class: $JssorArrowNavigator$,$ChanceToShow: 2}};
var jssor_slider1 = new $JssorSlider$("slider1_container", options);
//responsive code begin you can remove responsive code if you don't want the slider scales while window resizing
function ScaleSliderSearch() {
var bodyWidth = document.body.clientWidth;
jssor_slider1.$scale
jssor_slider1.$ScaleWidth($("#slider_contenedor1").width());
}
ScaleSliderSearch();
$(window).bind("load", ScaleSliderSearch);
$(window).bind("resize", ScaleSliderSearch);
$(window).bind("orientationchange", ScaleSliderSearch);
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