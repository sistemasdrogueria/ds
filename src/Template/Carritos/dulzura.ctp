<div class="col-md-12">
<div class="product-item-3" >
<div class="product-thumb">
<?php echo $this->element('banner_laboratorio'); ?>
</div> <!-- /.product-thumb -->
<div class="product-content" style ="background-color: #ddd;">
<?php if (!empty($articulos)){echo $this->element('carrito_dulzura_result_img'); }?>
</div><!-- /.product-content -->
</div> <!-- /.col-md-3 -->
</div>
<?php echo $this->Html->script('jssor.slider.min');?>
<script> jQuery(document).ready(function ($) {
var options = {
$FillMode: 2,$AutoPlay: 1,$Idle: 1000,$PauseOnHover: 1,$ArrowKeyNavigation: 1,$SlideEasing: $Jease$.$OutQuint,$SlideDuration: 800,$MinDragOffsetToSlide: 20,$SlideSpacing: 0,$UISearchMode: 1,$PlayOrientation: 1,$DragOrientation: 1,
$BulletNavigatorOptions: {$Class: $JssorBulletNavigator$,$ChanceToShow: 2,$SpacingX: 8,$Orientation: 1},
$ArrowNavigatorOptions: {$Class: $JssorArrowNavigator$,$ChanceToShow: 2}
};
var jssor_sliderZ = new $JssorSlider$("slider2_container", options);
//responsive code begin you can remove responsive code if you don't want the slider scales while window resizing
function ScaleSliderZocalo() {
var bodyWidth = document.body.clientWidth;
jssor_sliderZ.$scale
jssor_sliderZ.$ScaleWidth($("#slider_contenedor").width());
}
ScaleSliderZocalo();
$(window).bind("load", ScaleSliderZocalo);
$(window).bind("resize", ScaleSliderZocalo);
$(window).bind("orientationchange", ScaleSliderZocalo);
//responsive code end*/
});
</script>