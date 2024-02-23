<style>
#contador{	 width: 100%;    padding-bottom: 30px;}
.contador_fondo{ width: 100%; overflow: hidden; }
.contador_num{ box-sizing: border-box; margin: 0;  padding: 0;  text-align:center ; width: 60%; color: #000; float:right ;} 
.contador_num_logo { box-sizing: border-box; z-index: 100 !important; margin: 0;  padding: 0;  text-align:center ; width: 40%; color: #000 ; float: left; }
.contador_num h1 {  font-weight: normal;}
.contador_num li {  display: inline-block;  font-size: 1.4em;  list-style-type: none;  padding: 1.1em;  text-transform: uppercase;}
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
#container {  width: 100%;}
.header { display: flex;  flex-direction: row;  justify-content: space-between; background-color: white; margin-top: -120px;}
.background-image { width: 100%;  height: 100%; overflow: hidden;}
@media (max-width: 1600px) {.contador_num{  width: 60%;} .contador_num_logo { width: 40%; }.contador_num li {  font-size: 1.1em; padding: 1em; }.contador_num li span {  font-size: 3.5rem;}.header{   margin-top: -90px;}.contador_num li span2 {  margin-top:10px;} .header{   margin-top: -100px;}}

@media (max-width: 1300px) {.contador_num{  width: 60%;} .contador_num_logo { width: 40%; }.contador_num li {  font-size: 1em; padding: 0.9em; }.contador_num li span {  font-size: 3rem;}.header{   margin-top: -90px;}.contador_num li span2 {  margin-top:10px;}}
@media (max-width: 1100px) {.contador_num{  width: 60%;} .contador_num_logo { width: 40%; }.contador_num li {  font-size: 1em; padding: 0.9em; }.contador_num li span {  font-size: 3rem;}.header{   margin-top: -90px;}.contador_num li span2 {  margin-top:10px;}}
@media (max-width: 1000px) {.contador_num{  width: 70%;} .contador_num_logo { width: 30%; }.contador_num li {  font-size: 0.9em;  }.contador_num li span {  font-size: 2.5rem;}.contador_num li span2 {  margin-top:10px;}.header{   margin-top: -80px;}}
</style>

<div  class="product-thumb" id="container">
<div class="background-image">
  <?php echo $this->Html->image('EXPO11_FONDO-CUENTA-REGRESIVA.jpg',['alt'=>'EXPOVIRTUAL 11.','url'=>'https://www.exposurvirtual.com.ar',['target' => '_blank','_full'=> true,'escape' => true]]); ?>
</div>
<div class="header">
<div class="contador_num_logo"></div>
<div class=contador_num align=center>
<ul>
<li><span id="days"></span><span2>Dias</span2></li>
<li><span id="hours"></span><span2>Horas</span2></li>
<li><span id="minutes"></span><span2>Minutos</span2></li>
<li><span id="seconds"></span><span2>Segundos</span2></li>
</ul>
</div>
</div>
</div>



<!-- div class="product-item-3" style="margin-bottom:15px;">
<div id=slider_contenedor style="width:100%">
<div id="slider2_container" style="visibility: hidden; position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1200px; height: 180px; overflow: hidden;">
<div data-u="slides" style="position: absolute; left: 0px; top: 0px; width: 1200px; height: 180px; overflow: hidden;">
<?php /* foreach ($banner_slider as $slider): 
if ($slider['url_controlador']!= "")
{
if ($slider['url_controlador']== "EXPO")
{
  echo '<div><a href="'.$slider['url_campo'].'" target = _blank _full=true>'.$this->Html->image('publicaciones/'.$slider['imagen'], ['data-u'=>'image']) .'</a></div>';

}
else
  {
    if ($slider['url_campo']=="EAN_MULTIPLE")
    echo '<div>'.$this->Html->image('publicaciones/'.$slider['imagen'],['url'=>['controller'=>$slider['url_controlador'], 'action'=>$slider['url_metodo'],0,0,$slider["url_campo2"]],'data-u'=>'image'],['target' => '_blank','_full' => true,'escape' => false]).'</div>';
    else
    echo '<div>'.$this->Html->image('publicaciones/'.$slider['imagen'],['url'=>['controller'=>$slider['url_controlador'], 'action'=>$slider['url_metodo'], $slider["url_campo"]],'data-u'=>'image'],['target' => '_blank','_full' => true,'escape' => false]).'</div>';
  
  
  }
}
else
echo '<div><a href="'.\Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'index')).''.$slider['url_campo'].'">'.$this->Html->image('publicaciones/'.$slider['imagen'], ['data-u'=>'image']) .'</a></div>';


endforeach; */ ?>
</div -->

<style>
/*.jssorb031 {position:absolute;}
.jssorb031 .i {position:absolute;cursor:pointer;}
.jssorb031 .i .b {fill:#000;fill-opacity:0.5;stroke:#fff;stroke-width:1200;stroke-miterlimit:10;stroke-opacity:0.3;}
.jssorb031 .i:hover .b {fill:#fff;fill-opacity:.7;stroke:#000;stroke-opacity:.5;}
.jssorb031 .iav .b {fill:#fff;stroke:#000;fill-opacity:1;}
.jssorb031 .i.idn {opacity:.3;}*/
</style>
<!--div data-u="navigator" class="jssorb031" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
<div data-u="prototype" class="i" style="width:16px;height:16px;">
</div>
</div>
</div>
</div>
</div --> 

<script>
$(document).ready(function(){
$("a").on('click', function(event) {
var nav = $('#seccionpp2');
if(nav.length){
if (this.hash !== "") {
event.preventDefault();
var hash = this.hash;
$('html, body').animate({scrollTop: $(hash).offset().top}, 800, function(){window.location.hash = hash;});
}
} 
});
});
</script>

<script>
var futuro = new Date(2023, 04, 23, 00, 00).getTime();
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
faltan();

</script>