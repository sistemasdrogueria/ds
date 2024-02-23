<div class="col-md-9">
<div class="product-item-3">  
<div class="product-content">
<div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto; top: 0px; left: 0px; width: 900px; height: 280px; overflow: hidden; margin-bottom: 20px;">
<!-- Slides Container -->
<div data-u="slides" style="position: absolute; left: 0px; top: 0px; width: 900px; height: 280px; overflow: hidden;">
<?php
foreach ($publication_slider as $publication): 
        echo '<div>'. $this->Html->image('publicaciones/'.$publication['imagen'],['data-u'=>'image','width'=>'100%']).'</div>';
		//echo '<div>'.$this->Html->image('incorporations/nutricion/'.$incorporation['imagen'],['data-u'=>'image']).'</div>';
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

<?php 
if ($tipo_oferta !='TD'&&$tipo_oferta !='TH' && $tipo_oferta !='OR' )
{
    echo $this->element('carrito_search_result');  
    
    /*{
    if ($tipo_oferta !='SF')
        if ($tipo_oferta =='P' )
        echo $this->element('carrito_search_result');    
    else
        echo $this->element('carrito_farmapoint_result');
    }
    else
     {
        if ($indice !='1' )
            echo $this->element('carrito_search_result');    
        else
            echo $this->element('carrito_farmapoint_result');
        

     }*/   

}
else
{

 echo $this->element('patagonia_med_result'); 
 echo $this->element('referencia'); 
}
?> 
							
</div> <!-- /.product-content -->							
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-3">
<div class="product-item-5"> 
<div class="product-content">
<div class="row">
<?php echo $this->element('cartresum'); ?>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div>
<div class="product-item-5">	
<div class="product-content">
<div class='cliente_info_class3'>
<?php echo $this->Html->image('ofertaagregarcarro.png');?>
</div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row">   
<?php echo $this->element('botonescarro'); ?>
<div class="cartresul">			
<?php echo $this->element('cartresult'); ?>
</div>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->


<?php echo $this->Html->script('jssor.slider.min');?>
<script> jQuery(document).ready(function ($) {
var options = {
$FillMode: 2,//[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
$AutoPlay: 1,//[Optional] Auto play or not, to enable slideshow, this option must be set to greater than 0. Default value is 0. 0: no auto play, 1: continuously, 2: stop at last slide, 4: stop on click, 8: stop on user navigation (by arrow/bullet/thumbnail/drag/arrow key navigation)
$Idle: 800,//[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
$PauseOnHover: 1,//[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
$ArrowKeyNavigation: 1,//[Optional] Steps to go for each navigation request by pressing arrow key, default value is 1.
$SlideEasing: $Jease$.$OutQuint,                    //[Optional] Specifies easing for right to left animation, default value is $Jease$.$OutQuad
$SlideDuration: 800,//[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
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
/*function ScaleSlider() {
var bodyWidth = document.body.clientWidth;
if (bodyWidth)
jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
else
window.setTimeout(ScaleSlider, 30);

}*/

function ScaleSlider() {
var bodyWidth = document.body.clientWidth;
var content =  bodyWidth * 0.68;
/*
if (bodyWidth>1800)
	var content = 1300;
if (bodyWidth<1800 && bodyWidth>1700)
	var content = 1200;
if (bodyWidth<1700 && bodyWidth>1600)
	var content = 1150;
if (bodyWidth<1600 && bodyWidth>1500)
	var content = 1050;
if (bodyWidth<1500 && bodyWidth>1400)
	var content = 1000;

if (bodyWidth<1400 && bodyWidth>1300)
	var content = 950;
if (bodyWidth<1300 && bodyWidth>1200)
	var content = 900;
if (bodyWidth<1200 && bodyWidth>1078)
	var content = 700;
if (bodyWidth<1078 && bodyWidth>890)
	var content = 500;*/
if (bodyWidth<890)
	var content =  bodyWidth * 1.8 -bodyWidth;


if (bodyWidth)
jssor_slider1.$ScaleWidth(Math.min(bodyWidth, content));
else
window.setTimeout(ScaleSlider, 30);
}
/*
function ScaleSlider() {
var bodyWidth = document.body.clientWidth;

var content =  bodyWidth * 1.45-bodyWidth;

if (bodyWidth)
jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
else
window.setTimeout(ScaleSlider, 30);
}
*/
ScaleSlider();
$(window).bind("load", ScaleSlider);
$(window).bind("resize", ScaleSlider);
$(window).bind("orientationchange", ScaleSlider);
//responsive code end
});
</script>