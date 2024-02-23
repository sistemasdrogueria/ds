<style>
.my-fixed-item {position: fixed; z-index:99;top:88%;left: 95%; }
.my-fixed-item  img{/*position:absolute;*/margin-right: 15px;}
</style>
<div class=my-fixed-item align="center">
<?php echo $this->Html->image('icon_whatsapp.png',['url'=>'https://api.whatsapp.com/send?phone=5492914254968'],['target' => '_blank','_full'=> true,'escape' => true,'alt'=>'WHATSAPP']);?></div>
<div class="col-md-12">
<?php echo $this->element('banner_slider'); ?>
<div class="product-thumb" id="search-backf">
<?php echo $this->element('search'); ?>
</div> <!-- /.product-thumb -->
<div class="product-item-3">
<div class="product-content">
<?php if ($articulos!=null ){echo $this->element('carrito_search_result'); } else { echo $this->element('carrito_search_sin_result');}?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-12" id=seccionpp1 style="background-color:#f4f4f4 ;margin-top:15px;">
<?php echo $this->element('seccion_productos_promocion_div',['titulo_seccion'=>'IMPERDIBLES DEL MES','ofertasProms'=>$ofertasX,'ofertasArts'=>$ofertasY,'tipo_off'=>17]);?>
</div>
<div class="col-md-12" id=seccionpp2 style="background-color:#f4f4f4 ;margin-top:15px;">
<?php 
//PRODUCTOS QUE PUEDEN INTERESARTE
//ESTUCHES Y EXHIBIDORES
echo $this->element('seccion_productos_promocion_div',['titulo_seccion'=>'PRODUCTOS QUE PUEDEN INTERESARTE','ofertasProms'=>$ofertasX,'ofertasArts'=>$ofertasY,'tipo_off'=>12]);?>
</div>
<div class="col-md-12" id=seccionpp3 style="background-color:#f4f4f4 ;margin-top:15px;">
<?php echo $this->element('seccion_productos_promocion_div',['titulo_seccion'=>'ESTUCHES Y EXHIBIDORES','ofertasProms'=>$ofertasX,'ofertasArts'=>$ofertasY,'tipo_off'=>18]);?>
</div>
<div id=dialog-message>
<?php if(!is_null($sursale))
{
if ($sursale['url_campo']!='' && $sursale['url_campo2']!='')
{
if ($sursale['url_campo']!='preventa')
{
if ($sursale['url_controlador']=="PARTNER")
{
echo '<a href="'.$sursale['url_campo'].'" target ="_blank">'.$this->Html->image('publicaciones/'.$sursale['imagen'], ['alt' => 'LINK','width'=>'95%']) .'</a>';
}
else
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['url_campo'],$sursale['url_campo2']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
}
else
if ($sursale['url_campo']!='')
{
if ($sursale['url_campo']!='preventa')
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['url_campo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
}
else
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
?>
</div>
<div id=dialog-message2>
<?php if(!is_null($sursale2))
{ 
if ($sursale2['url_campo']!='' && $sursale2['url_campo2']!='')
{
if ($sursale2['url_campo']!='preventa')
if ($sursale2['url_controlador']=="PARTNER")
{
echo '<a href="'.$sursale2['url_campo'].'" target ="_blank">'.$this->Html->image('publicaciones/'.$sursale2['imagen'], ['alt' => 'LINK','width'=>'95%']) .'</a>';
}
else
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['url_campo'],$sursale2['url_campo2']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['descripcion']],['style'=>'display: none','id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
}
else
if ($sursale2['url_campo']!='')
{
if ($sursale2['url_campo']!='preventa')           
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['url_campo']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['descripcion']],['style'=>'display: none','id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
}
else
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
?>
</div>

<div id=dialog-message3>
<?php if(!is_null($noticiaimportante)){?>
<div>
<?php foreach($novedades as $novedade):?>
<?php if(!is_null($noticiaimportante)&&($novedade['img_file']!="")) 
{
	if ($novedade['archivopdf']>0)
	{
	echo '<iframe src="https://docs.google.com/gview?url=https://200.117.237.178/ds/webroot/img/novedades/'.$novedade['img_file'].'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe>';						
	}														
	else
		echo $this->Html->image('novedades/'.$novedade['img_file'], ["alt" => "COMUNIDADO", 'style'=>"width:95%;"]);
}
?>
<div class="member wow bounceInUp animated">
<div class=member-container data-wow-delay=.1s>
<div class=inner-container>
<div class=member-details>
<?php if(!is_null($noticiaimportante)&&($novedade['img_file']=="")) 
{
echo '<div class=member-top>';
echo '<h4 class=name style=color:#C00>'.$novedade->titulo.'</h4>';
echo '<span class=designation>'.$novedade->tipo.'</span>';
echo '</div>';
echo '<p class=texto>'.$this->Text->autoParagraph(h($novedade->descripcion)).'</p>';
echo '<p class=texto>'.$this->Text->autoParagraph(h($novedade->descripcion_completa)).'</p>';
echo '<h6>Bahia Blanca, '.date_format($novedade['fecha'],'d-m-Y').'</h6>';
}
?>
</div>
</div>
</div>
</div>
<?php endforeach;?>
</div>
<?php }?>
</div>
<script>
var $ingreso=0;
var $ingreso2=0;
var $ingreso3=0;
var $ingreso=<?php if(!empty($sursale)){if(empty($this->request->session()->read('ingreso'))){echo '0';}else echo '1';}else echo '1';?>;
var $ingreso2=<?php if(!empty($sursale2)){if(empty($this->request->session()->read('ingreso2'))){echo '0';}else echo '1';}else echo '1';?>;
var $ingreso3=<?php if(!empty($noticiaimportante)){if(empty($this->request->session()->read('ingreso3'))){echo '0';}else echo '1';}else echo '1';?>;
var $confirmX=<?php if(!empty($sursale)){if($sursale['url_campo']!='preventa')echo '0';else echo '1';}else echo '0';?>;
var $confirmY=<?php if(!empty($sursale2)){if($sursale2['url_campo']!='preventa')echo '0';else echo '1';}else echo '0';?>;
if($ingreso>0){document.getElementById("dialog-message").style.display="none";<?php echo $this->request->session()->write('ingreso',1)?>window.scrollTo(0,0)}
if($ingreso2>0){document.getElementById("dialog-message2").style.display="none";<?php echo $this->request->session()->write('ingreso2',1)?>window.scrollTo(0,0)}
if($ingreso3>0){document.getElementById("dialog-message3").style.display="none";<?php echo $this->request->session()->write('ingreso3',1)?>window.scrollTo(0,0)}
$(document).ready(function(){
	if($ingreso<1 && $confirmX>0){$("#dialog-message").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*0.9,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,
	
	buttons:	{
				'Continuar'			: function(){$(this).dialog("close")},
				'Comprar preventa': function(){
                    var conf1 = document.getElementById("conf_img1");
					location.href = conf1.href;
                    $(this).dialog("close")}
					}
	});
	window.scrollTo(0,0)}
    else
    if($ingreso<1 && $confirmX<1)
    {$("#dialog-message").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*0.9,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso',1);?>window.scrollTo(0,0)}

    if($ingreso2<1 && $confirmY>0){$("#dialog-message2").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*0.8,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,
	
	buttons:	{
				'Continuar'			: function(){$(this).dialog("close")},
				'Comprar preventa': function(){
                    var conf2 = document.getElementById("conf_img2");
					location.href = conf2.href;
                    $(this).dialog("close")}
					}
	});
	window.scrollTo(0,0)}
    else
    if($ingreso2<1 && $confirmY<1)
    {$("#dialog-message2").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*0.9,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso2',1);?>window.scrollTo(0,0)}
    if($ingreso3<1){$("#dialog-message3").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*0.9,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso3',1);?>window.scrollTo(0,0)}
	});
</script>

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
/*
var jssor_slider1 = new $JssorSlider$("slider1_container", options);
//responsive code begin you can remove responsive code if you don't want the slider scales while window resizing
function ScaleSlider() {
var bodyWidth = document.body.clientWidth;
jssor_slider1.$scale
jssor_slider1.$ScaleWidth($("#slider_contenedor1").width());
}
ScaleSlider();
$(window).bind("load", ScaleSlider);
$(window).bind("resize", ScaleSlider);
$(window).bind("orientationchange", ScaleSlider);*/
//responsive code end

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