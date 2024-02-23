<style>
/*este estilo es para no modificar en los otros elementos el alertify y el flotante*/
#flotante{ font-size: 14px; width: 460px; }
.alertify-notifier .ajs-message.ajs-warning{color:#68f152;font-size:15px;}
.alertify-notifier.ajs-center{ left: 36% !important; top: 35% !important; width: 310px; }
.alertify-notifier .ajs-message.ajs-warning{background-color: #5e636e;border-color: #111213;}
.a-x{position: absolute;top: 2px;right: 8px;color: #66cd6b;}
.clientes_novedades{display: inline-block; border-bottom: 1px solid #ddd;}
.clientes_novedades_fecha{ float: left; }
.clientes_novedades_titulo{ float: left; margin-left: 30px; font-weight: bold;}
.clientes_novedades_detalle{ float: left; width: 100%; margin: 15px; }
.modal.show { display: flex !important; flex-direction: column; justify-content: center; align-content: center; align-items: flex-start; }
.modal.in { opacity: 1 !important;  }
.color { background-color: #808080; }
#teminosycondiciones {display: none; }
</style>
<?php echo $this->Html->script('https://www.google.com/recaptcha/api.js?render=6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB'); ?>
<div class="col-md-7">
<div class="product-item-3">
<div class="product-content3">
<div class="row">
<h3 align="center">Descarga de archivos</h3>
<table class="link">
<tr>
<td width="250px" height="40" align="left" valign="top">
<div id="descripcion-campo"><B>Productos</B></div>
</td>
<td width="50px" height="40" align="left" valign="top">
<?php echo $this->Html->image('txtv2.png',['title'=>'Descargar TXT',/*'onmouseover'=>'showdiv(event);','onMouseOut'=>'hiddenDiv();',*/ 'url'=>['controller'=>'Descargas','action'=>'descargarlistado',3]]);
?>
</td>
<td width="150px" height="40" align="left" valign="top">
<?php echo 'TODO'. $this->Html->image('excel.png',['title'=>'Descargar Excel','style'=>'cursor:pointer;', 'onsubmit'=>'return false','onclick'=>'descargarexcel(1);']);?>
</td>
<td width="150px" height="40" align="left" valign="top">
<?php echo 'PERFUMERIA' . $this->Html->image('excel.png', ['title'=>'Descargar Excel','onsubmit'=>'return false', 'style'=>'cursor:pointer;','onclick'=>'descargarexcel(2);']); ?>
</td>
</tr>
<tr>
<td height="40" align="left" valign="top">
<div id="descripcion-campo"><B>Actualizaciones de precio</B></div>
</td>
<td height="40" align="left" valign="top">
<?php echo $this->Html->image('txtv2.png',['title'=>'Descargar TXT',/*'onmouseover'=>'showdiv(event);','onMouseOut'=>'hiddenDiv();',*/ 'url'=>['controller'=>'Descargas', 'action'=>'descargarlistado',1]]);?>
</td>
<td>
</td>
</tr>
<tr>
<td height="40" align="left" valign="top">
<div id="descripcion-campo"><B>Descuentos Patagonia Med</B></div>
</td>
<td height="40" align="left" valign="top">
<?php echo $this->Html->image('txtv2.png', ['title'=>'Descargar TXT'/*,'onmouseover'=>'showdiv(event);','onMouseOut'=>'hiddenDiv();'*/, 'url'=>['controller'=>'Descargas', 'action'=>'descargarlistado',2]]); ?>
</td>
<td>
</td>
</tr>
</table>
<h3 align="center" id=TituloTermino>Términos y Condiciones de Uso</h3>
<div id =teminosycondiciones>

<p><strong><u>Declaraci&oacute;n</u></strong></p>
<p><strong><u>Uso de informaci&oacute;n</u></strong></p>
<p>&nbsp;</p>
<p>Con motivo de la relaci&oacute;n comercial vigente (en adelante, la Relaci&oacute;n) entre Drogueria Sur S.A. (en adelante, la Droguer&iacute;a) y <?php echo $this->request->session()->read('Auth.User.razon'); ?> (en adelante, la Farmacia), la Farmacia podr&aacute; tener acceso a datos y/o informaci&oacute;n comercial -tales como stock de productos, precios de venta, etc.- (en adelante, la Informaci&oacute;n) de la Droguer&iacute;a encuadrados dentro de las disposiciones de la Ley N&deg; 25.326, as&iacute; como cualquier otra normativa que regule el tratamiento de datos personales, registros, bases de datos y archivos; en tal sentido la Farmacia acepta y se hace responsable respecto de los siguientes puntos:</p>
<p>&nbsp;</p>
<ul>
<li>guardar&aacute; la m&aacute;xima reserva y secreto sobre la Informaci&oacute;n a la que acceda en virtud de la Relaci&oacute;n;</li>
<li>utilizar&aacute; la Informaci&oacute;n &uacute;nica y exclusivamente para uso interno;</li>
<li>proteger&aacute; la Informaci&oacute;n de toda forma de procesamiento ilegal, incluyendo recolecci&oacute;n innecesaria, transferencia, o procesamiento;</li>
<li>no ceder&aacute; la Informaci&oacute;n a terceras personas, ni siquiera a efectos de su conservaci&oacute;n; y</li>
<li>solo usar&aacute; la Informaci&oacute;n de acuerdo a las instrucciones brindadas por la Droguer&iacute;a, bajo apercibimiento que, de no cumplir con dicha obligaci&oacute;n, la Farmacia deba responder por los da&ntilde;os y perjuicios.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
<div class="col-md-5">
<div class="product-item-3">
<div class="product-content3">
<div class="row">
<h3 align="center">Novedades</h3>
<?php foreach ($clientesnovedades as $clientesnovedade): ?>
<div class=clientes_novedades>
<div class=clientes_novedades_fecha><?php echo date_format($clientesnovedade['fecha'],'d-m-Y'); ?></div>
<div class=clientes_novedades_titulo><?php echo $clientesnovedade['titulo'];?> </div>
<div class=clientes_novedades_detalle> <?php echo nl2br($clientesnovedade['descripcion']);?></div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</div>

<div class="col-md-7">
<div class="product-item-3">
<div class="product-content3">
<div class="row">

<h3 align="center">Descargas de Formatos</h3>
<table>
<tr>
<TD WIDTH="250px" height="40" align="left" valign="top">
<div id="descripcion-campo"><B>Factura Digital</B></div>
</td>
<td WIDTH="350px" height="40" align="left" valign="top">
<div style="float:left;  width:100px">
<?php echo 'ver1 ' . $this->Html->image('pdfv2.png', ['title'=>'Descargar pdf','url'=>['controller'=>'Descargas','action'=>'descargarformato',1]]); ?>
</div>
<div style="float:left;  width:60px">
<?php echo 'ver2 ' . $this->Html->image('pdf.png', ['title'=>'Descargar pdf', 'url'=>['controller'=>'Descargas', 'action'=>'descargarformato',2]]);?>
</div>
<div style="float:left; color:red;margin-left:4px;font-weight:bold;">Nuevo</div>
</td>
</tr>
<tr>
<td height="40" align="left" valign="top">
<div id="descripcion-campo"><B>Pedido, Respuesto y Falta</B></div>
</td>
<td height="40" align="left" valign="top">
<?php echo $this->Html->image('pdf.png',['title'=>'Descargar pdf', 'url'=>['controller'=>'Descargas','action'=>'descargarformato',3]]);?>
</td>
</tr>
<tr>
<td height="40" align="left" valign="top">
<div id="descripcion-campo"><B>Trazabiliad</B></div>
</td>
<td height="40" align="left" valign="top">
<?php echo $this->Html->image('txt2.png',['title'=>'Descargar pdf', 'onmouseover'=>'showdiv(event);', 'onMouseOut'=>'hiddenDiv();', 'url'=>['controller'=>'Descargas', 'action'=>'descargarformato',4]]);?>
</td>
</tr>
<tr>
<td height="40" align="left" valign="top">
<div id="descripcion-campo"><B>Productos</B></div>
</td>
<td height="40" align="left" valign="top" style="display:inline-flex;align-items:center;">
<?php echo $this->Html->image('pdf.png',['title'=>'Descargar pdf', 'url'=>['controller'=>'Descargas', 'action'=>'descargarformato',5]]);?>
</td>
</tr>
</table>
</div>
</div>
</div>
</div>
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
</div>
<div class="modal-body" style="display: flex; flex-direction: column; flex-wrap: wrap; align-content: center; justify-content: center; align-items: center;">
<?php 
echo $this->Html->image('loading-waiting.gif', ['title'=>'cargando por favor, espere.', 'alt'=>'', 'style'=>'width:40px;height:40px;']);
echo "<p>Estamos preparando su archivo, por favor, espere.</p>";
?>
</div>
<div class="modal-footer">
</div>
</div>
</div>

</div>
<div id="flotante" ></div>
<style>
.modal.show  { display:flex!important;  flex-direction:column; justify-content:center; align-content:center; align-items: flex-start; }
.modal.in { opacity:1 !important; }
.color{ background-color: #808080;}
</style>
<script>
/*
window.onload=disableClicks;
var cont = document.getElementsByClassName('link')[0];
function disableClicks() {
cont.style.pointerEvents = "none";
}
const myTimeout = setTimeout(bloquea, 6000);
function bloquea(){
cont.style.pointerEvents = "auto";
}
*/
document.getElementById('TituloTermino').addEventListener('click', function() {
var divOculto = document.getElementById('teminosycondiciones');
if (divOculto.style.display === 'none') {
divOculto.style.display = 'block';
} else {
divOculto.style.display = 'none';
}
});


function descargarexcel(cat){
$('.product-content3').addClass('color');
$('#myModal').modal({backdrop: 'static',keyboard: false})
$('#myModal').modal({show:true});
$('#myModal').addClass('show');
grecaptcha.ready(function() {
grecaptcha.execute('6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB', {
action: 'submit'
}).then(function(token) {
$.ajax({
data: {
cat:cat,
recaptcha:token
},
dataType:"json",
url: "<?php echo \Cake\Routing\Router::url(array('controller'=>'descargas', 'action'=>'excel')); ?>",
type: "post",
}).done(function(data){
$('#myModal').modal('toggle');
$('#myModal').removeClass('show');
var $a = $("<a>");
$a.attr("href",data.file);
$("body").append($a);
$a.attr("download","productos.xlsx");
$a[0].click();
$a.remove();
$('#imagencargando').addClass('hide');
$('.product-content3').removeClass('color');
});
});
});
}
function ocultarimg(){
$('#imagencargando').addClass('hide');
$('.product-content3').removeClass('color');
}

function showdiv(event, text) {

//determina un margen de pixels del div al raton
margin = 0;
//La variable IE determina si estamos utilizando IE
var IE = document.all ? true : false;
var tempX = 0;
var tempY = 0;
//document.body.clientHeight = devuelve la altura del body
if (IE) { //para IE
IE6 = navigator.userAgent.toLowerCase().indexOf('msie 6');
IE7 = navigator.userAgent.toLowerCase().indexOf('msie 7');
if (IE6 > 0 || IE7 > 0) {
tempX = event.x
tempY = event.y
if (window.pageYOffset) {
tempY = (tempY + window.pageYOffset);
tempX = (tempX + window.pageXOffset);
} else {
tempY = (tempY + Math.max(document.body.scrollTop, document.documentElement.scrollTop));
tempX = (tempX + Math.max(document.body.scrollLeft, document.documentElement.scrollLeft));
}
} else {
//IE8
tempX = event.x
tempY = event.y
}
} else { //para netscape
//window.pageYOffset = devuelve el tamaño en pixels de la parte superior no visible (scroll) de la pagina
//document.captureEvents(Event);
tempX = event.pageX;
tempY = event.pageY;
//console.log(tempX,tempY);
}
if (tempX < 0) {
tempX = 0;
}
if (tempY < 0) {
tempY = 0;
}

var flotante = document.getElementById('flotante').innerHTML = "<div id='flotante_text1'>A partir del día 01-10-2022, el formato de factura digital v2 tendrán un cambio.</div>";
document.getElementById('flotante').style.top = (tempY - 50) + "px";
document.getElementById('flotante').style.left = (tempX - 30) + "px";
document.getElementById('flotante').style.display = 'block';
return;
}

function hiddenDiv(){
document.getElementById('flotante').style.display='none';
}
/*
var canDismiss = true;
alertify.set('notifier','position', 'bottom-center');
var notification = alertify.warning('A partir del día 01-10-2022, el formato de factura digital v2 </b> Tendrán un cambio.');
$('.alertify-notifier .ajs-message').append('<span><a class="a-x" onclick="cerraralertify();" href="#">X</a></span>');
notification.ondismiss = function(){ return canDismiss; };
setTimeout(function(){canDismiss = true;}, 5000);
*/
function cerraralertify(){
notification.ondismiss = function(){ return true;};

}
</script>