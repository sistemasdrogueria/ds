<!-- style>
#fondobf{	}
#fondobf img {width: 260px; padding-top:15px; margin-left: auto;
    margin-right: auto;
    display: block;}
.contadorbf{ box-sizing: border-box;  margin: 0;  padding: 0;  height: 90px;  }
.contadorbf h1 {  font-weight: normal;}
.contadorbf li {  display: inline-block;  font-size: 1.5em;  list-style-type: none;  padding: 1em;  text-transform: uppercase;}
.contadorbf li span {  display: block; font-size: 4.5rem;}
.contadorbf li span2 {  margin-top:20px; display: block;}
dl, menu, ol, ul { margin: 0px;}
</style>
<div class="product-item-3" style="margin-bottom:15px;">
<div class="product-thumb" id="fondobf">
<div style="width: 20%; float : left;  " >
<?php //echo $this->Html->image('LOGO-HOT-SUR-SALE.png',['alt'=>'HOT SUR SALE ESTA LLEGANDO.','style'=>'width: 180px;']);?>
</div>
<div style="width: 20%; float : left" >
<?php //echo $this->Html->image('QUEDAN.png',['alt'=>'HOT SUR SALE ESTA LLEGANDO.','style'=>'width: 180px; margin-top:40px;']);?>
</div>
<div class=contadorbf align=center style="width: 60%; float: right; margin-top:40px;">
<ul>
<li><span id="days"></span><span2>Dias</span2></li>
<li><span id="hours"></span><span2>Horas</span2></li>
<li><span id="minutes"></span><span2>Minutos</span2></li>
<li><span id="seconds"></span><span2>Segundos</span2></li>
</ul>
</div>
</div>
</div>
<script>
var futuro = new Date(2021, 04, 13, 00, 01).getTime();
//actualiza el contador cada 4 segundos ( = 4000 milisegundos)
var actualiza = 1000;
// función que calcula y escribe el tiempo en días, horas, minutos y segundos
// que faltan para la variable futuro
//alert(futuro);
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
        var dias = Math.floor(horas / 24);
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
</script -->

<div class="product-item-3" style="margin-bottom:15px;">
<div id=slider_contenedor style="width:100%">
<div id="slider2_container" style="visibility: hidden; position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1860px; height: 280px; overflow: hidden;">
<div data-u="slides" style="position: absolute; left: 0px; top: 0px; width: 1860px; height: 280px; overflow: hidden;">
<?php foreach ($banner_slider as $slider): 
if ($slider['url_controlador']!= "")
{
if ($slider['url_controlador']== "EXPO")
{
  echo '<div><a href="'.$slider['url_campo'].'" target = _blank _full=true>'.$this->Html->image('publicaciones/'.$slider['imagen'], ['data-u'=>'image']) .'</a></div>';

}
else
{
  if ($slider['url_campo']=="EAN_MULTIPLE")
  echo '<div>'.$this->Html->image('publicaciones/'.$slider['imagen'],['url'=>['controller'=>$slider['url_controlador'], 'action'=>$slider['url_metodo'],"","", $slider["url_campo2"]],'data-u'=>'image'],['target' => '_blank','_full' => true,'escape' => false]).'</div>';
  else
  echo '<div>'.$this->Html->image('publicaciones/'.$slider['imagen'],['url'=>['controller'=>$slider['url_controlador'], 'action'=>$slider['url_metodo'], $slider["url_campo"]],'data-u'=>'image'],['target' => '_blank','_full' => true,'escape' => false]).'</div>';
}
}
else
//echo '<div>'.$this->Html->image('publicaciones/'.$slider['imagen'],['url'=>['controller'=>$slider['url_campo']],'data-u'=>'image'],['target' => '_blank','_full' => true,'escape' => false]).'</div>';
echo '<div><a href="'.\Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'index')).''.$slider['url_campo'].'">'.$this->Html->image('publicaciones/'.$slider['imagen'], ['data-u'=>'image']) .'</a></div>';


endforeach; ?>
</div>
<style>
.jssorb031 {position:absolute;}
.jssorb031 .i {position:absolute;cursor:pointer;}
.jssorb031 .i .b {fill:#000;fill-opacity:0.5;stroke:#fff;stroke-width:1200;stroke-miterlimit:10;stroke-opacity:0.3;}
.jssorb031 .i:hover .b {fill:#fff;fill-opacity:.7;stroke:#000;stroke-opacity:.5;}
.jssorb031 .iav .b {fill:#fff;stroke:#000;fill-opacity:1;}
.jssorb031 .i.idn {opacity:.3;}
</style>
<div data-u="navigator" class="jssorb031" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
<div data-u="prototype" class="i" style="width:16px;height:16px;">
</div>
</div>
</div>
</div>
</div> 

<script>
$(document).ready(function(){
 
  $("a").on('click', function(event) {
    var nav = $('#seccionpp2');
    if(nav.length){

    if (this.hash !== "") {
    
      event.preventDefault();

    
      var hash = this.hash;
    

      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
   
        window.location.hash = hash;
      });

    }
    } 
  });
});
</script>