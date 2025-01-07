<?php echo $this->element('banner_slider_nutricion'); ?>
<div class=container>
<div class="col-md-12">
<div class="product-item-3">
<div class="product-content">
<?php 
echo '<div class=row>'.$this->element('nutricion_search').'</div>';
?>
</div> 
<div class="product-content" style="background-color: #f3f3f3;" >  
<?php 
if ($this->request->session()->read('marcaid')>0)
{
echo $this->element('seccion_marcas_div',['autoplay'=>'0']);
}
else
if (!is_null($articulos) )
{
    echo $this->element('seccion_marcas_div',['autoplay'=>'0']);
}

if ($this->request->session()->read('marcaid')>0)
{
if (!is_null($articulos) )
{
echo $this->element('carrito_search_result_img',['articulos'=>$articulos,'laboratorios'=>$laboratorios,'categorias'=>$categorias]); 
}
else
{echo $this->element('carrito_search_sinresult'); }
}
else
if (!is_null($articulos) )
{
echo $this->element('carrito_search_result_img',['articulos'=>$articulos,'laboratorios'=>$laboratorios,'categorias'=>$categorias]); 
}
else
echo '<div class=row id=nutricion_row_marcas> <br>'. $this->element('nutricion_marcas'). '</div>';
?>
</div> <!-- /.product-content -->
<div class="product-content">
<?php echo $this->element('referencia'); ?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-9 -->

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
