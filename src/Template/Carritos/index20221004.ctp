<style>
#contador{	 width: 100%;    padding-bottom: 30px;}
.contador_fondo{ width: 100%; margin-bottom: 125px;}
.contador_num{ box-sizing: border-box;  margin: 0;  padding: 0;  text-align:center ; margin-top: -225px; }
.contador_num h1 {  font-weight: normal;}
.contador_num li {  display: inline-block;  font-size: 1.5em;  list-style-type: none;  padding: 1em;  text-transform: uppercase;}
.contador_num li span {  display: block; font-size: 4.5rem;}
.contador_num li span2 {  margin-top:20px;     display: block;}
.my-fixed-item {position: fixed; z-index:99;top:88%;left: 95%; }
.my-fixed-item  img{/*position:absolute;*/margin-right: 15px;}
.dialog-message2{overflow: hidden  !important; padding: 0; }
.eliminarbordes{border:0!important;background:#f8f9fc00!important;color:#f8f9fc0f!important}
.eliminarbordesbar{border:0!important;background:#f8f9fc00!important;color:#f8f9fc0f!important;top:35px!important;z-index:300}
.eliminarbordesbar .ui-dialog-title{display:none}
.eliminarbordesbar .ui-dialog-titlebar-close{background-color:#fff;color:#fff}
.btn-cancelar{height:20px;float:right;position:relative;top:-98%;margin-right:-119px;font-size:12px!important;font-weight:600;background-color:#005ca8;color:#fff;border-radius:5px;border-color:#005ca8;border-width:1px;text-decoration:none}
.ui-widget-overlay{background:#f8f9fc91;opacity:.2;filter:Alpha(Opacity=.3)}
.botonx{background-image:none!important}
.ui-widget-content a:hover{color:inherit}
.ui-widget-content img:hover{color:inherit}
.eliminarbordes .ui-dialog-buttonset button{display:none}

</style>
<div class=my-fixed-item align="center">
<?php echo $this->Html->image('icon_whatsapp.png',['url'=>'https://api.whatsapp.com/send?phone=5492914254968'],['target' => '_blank','_full'=> true,'escape' => true,'alt'=>'WHATSAPP']);?></div>
<div class="col-md-12">
<?php echo $this->element('banner_slider'); ?>
<div class="product-thumb" id="search-backf">
<?php echo $this->element('search'); ?>
</div> <!-- /.product-thumb -->
<!--div class="product-thumb" id="contador" >
<div class=contador_fondo align="center">
<?php 
//echo $this->Html->image('HSS_CUENTA_REGRESIVA.jpg',['alt'=>'Cuenta Regresiva']);
//echo $this->Html->image('YA-COMENZO-HACE-CLICK.jpg',['alt'=>'EXPOVIRTUAL 9.','url'=>'https://www.exposurvirtual.com.ar',['target' => '_blank','_full'=> true,'escape' => true]]);

?>
</div>
<div class=contador_num align=center style="z-index: 3; color: #000">
<ul>

<li><span id="days"></span><span2>Dias</span2></li>
<li><span id="hours"></span><span2>Horas</span2></li>
<li><span id="minutes"></span><span2>Minutos</span2></li>
<li><span id="seconds"></span><span2>Segundos</span2></li>
</ul>
</div>
</div -->
<div class="product-item-3">
<div class="product-content">
<?php if ($articulos!=null ){echo $this->element('carrito_search_result'); } else { echo $this->element('carrito_search_sin_result');}?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-12" id=seccionpp1 style="background-color:#f4f4f4 ;margin-top:15px;">
<?php echo $this->element('seccion_productos_promocion_div2',['titulo_seccion'=>'FRAGANCIAS SELECTIVAS','ofertasProms'=>$ofertasX,'ofertasArts'=>$ofertasY,'tipo_off'=>17,'autoplay'=>1]);?>
</div>
<div class="col-md-12" id=seccionpp2 style="background-color:#f4f4f4 ;margin-top:15px;">
<?php echo $this->element('seccion_productos_promocion_div2',['titulo_seccion'=>'PRODUCTOS QUE PUEDEN INTERESARTE','ofertasProms'=>$ofertasX,'ofertasArts'=>$ofertasY,'tipo_off'=>12,'autoplay'=>0]);?>
</div>
<div class="col-md-12" id=seccionpp3 style="background-color:#f4f4f4 ;margin-top:15px;">
<?php echo $this->element('seccion_productos_promocion_div2',['titulo_seccion'=>'ESTUCHES Y EXHIBIDORES','ofertasProms'=>$ofertasX,'ofertasArts'=>$ofertasY,'tipo_off'=>18,'autoplay'=>0]);?>
</div>
<div class="modal fade"  style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;"data-keyboard="false" data-backdrop="static" 
id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro"> <button type="button" class="close-intro" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
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
if (!is_null($sursale['laboratorio_id']))
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo']," ",$sursale['laboratorio_id']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
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
</div>
<div class="modal fade" style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;" data-keyboard="false" data-backdrop="static" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true"> × </span>
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
if (!is_null($sursale2['laboratorio_id']))
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo']," ",$sursale2['laboratorio_id']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
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

<div class="modal fade" style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;" data-keyboard="false" data-backdrop="static" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>

<!-- Modal body with image -->
<div class="modal-body-intro">
<?php if(!is_null($noticiaimportante)){?>
<div>
<?php foreach($novedades as $novedade):?>
<?php if(!is_null($noticiaimportante)&&($novedade['img_file']!="")) 
{
	if ($novedade['archivopdf']>0)
	{
	echo '<iframe  onclick="closediv()" src="https://docs.google.com/gview?url=https://200.117.237.178/ds/webroot/img/novedades/'.$novedade['img_file'].'&embedded=true" style="width:100%; min-height:550px;" frameborder="0"></iframe>';						
	}														
	else
		echo $this->Html->image('novedades/'.$novedade['img_file'], ["alt" => "COMUNIDADO", 'style'=>"width:100%;"]);
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
<div class="moda-footer-intro">
<button class="btn-continuar" onclick="closedivbutton(3)"> Continuar</button>
</div>
</div>
</div>
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
if($ingreso>0){document.getElementById("exampleModal").style.display="none";<?php echo $this->request->session()->write('ingreso',1)?>window.scrollTo(0,0)}
if($ingreso2>0){document.getElementById("exampleModal2").style.display="none";<?php echo $this->request->session()->write('ingreso2',1)?>window.scrollTo(0,0)}
if($ingreso3>0){document.getElementById("exampleModal3").style.display="none";<?php echo $this->request->session()->write('ingreso3',1)?>window.scrollTo(0,0)}
$(document).ready(function(){
if($ingreso<1 && $confirmX>0){  $('#exampleModal').modal(
        {backdrop: false 
},'show');}
    else
    if($ingreso<1 && $confirmX<1)
    {  $('#exampleModal').modal({
  backdrop: false
},'show');}

    if($ingreso2<1 && $confirmY>0){
    $('#exampleModal2').modal({
  backdrop: false
},'show');

    }
    else
    if($ingreso2<1 && $confirmY<1)
    {$('#exampleModal2').modal({
  backdrop: false
},'show');}

    if($ingreso3<1){$('#exampleModal3').modal({
  backdrop: false
},'show');
}
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
/*
function closediv(){
    //$('#dialog-message'+i).hide(); 

	$('.ui-dialog-content').dialog('close');
}


*/

var futuro = new Date(2022, 06, 03, 0, 00).getTime();
//actualiza el contador cada 4 segundos ( = 4000 milisegundos)
var actualiza = 1000;
// función que calcula y escribe el tiempo en días, horas, minutos y segundos
// que faltan para la variable futuro

function faltan() {
var ahora = new Date().getTime();
var faltan = futuro - ahora;

// si todavís no es futuro
if (faltan > 0) {
var segundos = Math.round(faltan / 1000);
var minutos = Math.floor(segundos / 60);
var segundos_s = segundos % 60;
var horas = Math.floor(minutos / 60);
var minutos_s = minutos % 60;
var dias = Math.floor(horas / 24) -31;
var horas_s = horas % 24;
// escribe los resultados
(segundos_s < 10) ? segundos_s = "0" + segundos_s : segundos_s = segundos_s;
(minutos_s < 10) ? minutos_s = "0" + minutos_s : minutos_s = minutos_s;
(horas_s < 10) ? horas_s = "0" + horas_s : horas_s = horas_s;
(dias < 10) ? dias = "0" + dias : dias = dias;

//var resultado = dias + " dias : " + horas_s + " horas : " + minutos_s + " minutos : " + segundos_s + " segundos";
//document.formulario.reloj.value = resultado;

document.getElementById('days').innerText = dias,
document.getElementById('hours').innerText = horas_s,
document.getElementById('minutes').innerText = minutos_s,
document.getElementById('seconds').innerText = segundos_s;

//actualiza el contador
setTimeout("faltan()", actualiza);
}
// estamos en el futuro
else {
//document.formulario.reloj.value = "00 dias : 00 horas : 00 minutos : 00 segundos";
}
}
//faltan();

/*
$("input").focus(function(){
    $("span").css("display", "inline").fadeOut(2000);
  });*/
</script>