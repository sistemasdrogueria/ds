
<div class=container>
<div class="col-md-9" >
<div class="product-item-3">
<div class="product-content" style="text-align: center; width: 100%; align-items: center; display: flex; justify-content: center;">
<?php
echo '<div class=row>';
echo '<div style="float: left;min-height: 100px;	width: 100%;height: 100%; margin-bottom: 10px;">';
echo '<div style="margin: auto; width: 250px;">';
echo $this->Html->image('COMUNIDAD-SUR.png',['width'=>'250px']).'</div>';
if ($this->request->session()->read('Auth.User.comunidadsur')>0)	
//echo '<div style="margin: auto; width: 250px;">'.$this->Html->image('Consulta-CSur.png', ['width'=>'250px','alt' => 'Comunidad Sur','url'=>'https://www.drogueriasur.com.ar/cs/']).'</div>';
echo '<div style="margin: auto; width: 250px;">' . 
    $this->Html->link(
        $this->Html->image('Consulta-CSur.png', ['width' => '250px', 'alt' => 'Comunidad Sur']),
        'https://www.comunidadsur.com.ar/',
        ['escape' => false, 'target' => '_blank']
    ) 
. '</div>';



echo '</div>';
echo $this->element('partner_marcas');
echo $this->element('partner_sin_result'); 
echo '</div>';
?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-3">
<div id=slider_contenedor >
<div id="slider2_container" style="visibility: hidden; position: relative; margin: 0 auto; top: 0px; left: 0px; width: 400px; height: 800px; overflow: hidden;">
<!-- Slides Container -->
<div data-u="slides" style="position: absolute; left: 0px; top: 0px; width: 400px; height: 800px; overflow: hidden;">
<?php
foreach ($publications_partner as $publication): 
//echo '<div>'.$this->Html->image('publicaciones/'.$promo2['imagen'],['url'=>['controller'=>$promo2['url_controlador'],'action'=>$promo2['url_metodo'],$promo2['url_campo']],'data-u'=>'image','alt'=>'Drogueria Sur S.A.','width'=>'100%']).'</div>';
if ($publication['url_metodo']!='')    
{
if ($publication['url_campo']!='')
echo '<div>'. $this->Html->image('publicaciones/'.$publication['imagen'],['url'=>['controller'=>$publication['url_controlador'],'action'=>$publication['url_metodo'],$publication['url_campo']],'data-u'=>'image','alt'=>'Drogueria Sur S.A.','width'=>'100%']).'</div>';
else
echo '<div>'. $this->Html->image('publicaciones/'.$publication['imagen'],['url'=>['controller'=>$publication['url_controlador'],'action'=>$publication['url_metodo']],'data-u'=>'image','alt'=>'Drogueria Sur S.A.','width'=>'100%']).'</div>';
}
else
echo '<div>'. $this->Html->image('publicaciones/'.$publication['imagen'],['data-u'=>'image','width'=>'100%']).'</div>';
//echo '<div>'.$this->Html->image('incorporations/perfumerias/'.$incorporation['imagen'],['data-u'=>'image']).'</div>';
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
</div> <!-- /.col-md-4 -->

</div>

<?php echo $this->Html->script('jssor.slider.min');?>
<script> jQuery(document).ready(function ($) {
var options = {
$FillMode: 2,//[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
$AutoPlay: 1,//[Optional] Auto play or not, to enable slideshow, this option must be set to greater than 0. Default value is 0. 0: no auto play, 1: continuously, 2: stop at last slide, 4: stop on click, 8: stop on user navigation (by arrow/bullet/thumbnail/drag/arrow key navigation)
$Idle: 1500,//[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
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
var jssor_slider1 = new $JssorSlider$("slider2_container", options);
//responsive code begin you can remove responsive code if you don't want the slider scales while window resizing
function ScaleSlider() {
var bodyWidth = document.body.clientWidth;
jssor_slider1.$scale
jssor_slider1.$ScaleWidth($("#slider_contenedor").width());
}
ScaleSlider();
$(window).bind("load", ScaleSlider);
$(window).bind("resize", ScaleSlider);
$(window).bind("orientationchange", ScaleSlider);
//responsive code end
});
</script>
