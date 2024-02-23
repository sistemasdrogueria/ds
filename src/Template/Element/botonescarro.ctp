<style> .notificacionfalta{ float: right; margin-right: 10px;  margin-top: -29px; z-index: 100;  width: 30px; height: 30px; text-align: center }
.notificacionfaltacantidad{ margin-left: 23px; z-index: 120; margin-top: -33px; color:white} 
.notificacionfaltacantidadmas{ margin-left: 17px; z-index: 120;  margin-top: -33px; color:white} 
</style>
<div class="col-md-12 col-sm-12">
<?= $this->Form->create('Confirmar', ['url' => ['controller' => 'Carritos', 'action' => 'confirm'], 'id' => 'enviarbtnenviar', 'onsubmit' => 'return false;']); ?>
<div class="button-holder7">
<?php if( $_SESSION['Auth']['User']['codigo'] == 21199 || $_SESSION['Auth']['User']['codigo']==51896){echo $this->Html->link(__('Enviar'), ['class'=>'red-btn','controller' => 'Carritos', 'action' => 'confirm']);  }else{echo '<a class="red-btn" href="#" onsubmit="return false;" onclick="confirmarofertasperdidas()">Enviar</a>';}?>    
</div>
<?= $this->Form->end() ?>
<div class="button-holder4">
<?= $this->Html->link(__('Ver Carro'),['controller' => 'Carritos', 'action' => 'view'], ['id' => 'vercarro','class'=>'red-btn']) ?>
</div>
<div class="button-holder6">
<a href="#"  class="vaciar" onclick="preguntarSI(<?php echo $_SESSION['Auth']['User']['cliente_id']?>)">Vaciar</a>
<?php // $this->Html->link('Vaciar',['controller' => 'Carritos', 'action' => 'vaciar'],['confirm' => 'Esta seguro de vaciar el carrito'])?>
</div>
<div class="button-holder8">
<?= $this->Html->link(__('Faltas'),['controller' => 'Carritos', 'action' => 'faltas'], ['id' => 'vercarro','class'=>'red-btn']) ?>
<div class=notificacionfalta><?php 
if ($this->request->session()->read('Auth.User.notificacionfalta')>0) 
echo $this->Html->image('notificacion_falta.png',['title' => 'FALTA'] );	
?>
<?php 
if ($this->request->session()->read('Auth.User.notificacionfalta')>0)
{
if ($this->request->session()->read('Auth.User.notificacionfalta')>9)  
echo '<div class=notificacionfaltacantidadmas>+9';
else
echo '<div class=notificacionfaltacantidad>'.$this->request->session()->read('Auth.User.notificacionfalta');
echo '</div>';
}?>
</div>
</div> 
</div>

<script>
function confirmarofertasperdidas() {
//variable de la url actual.
var URLactual = window.location.toString();
//variable que contiene las imagenes con la clase de off.perdida.
var imagen = document.querySelectorAll('#tablaprueba tbody tr .carrito_item_descripcion img.off_perdida');
//variable que contiene las imagenes con la clase de off.perdida al actualizar con itenmupdate se elimina el tbody de la tabla.
var imagentable = document.querySelectorAll('#table tr .carrito_item_descripcion img.off_perdida');

//validar si exite algun dato en imagen
if (imagen.length > 0) {
var img = imagen;
} else {
var img = imagentable;
}

total = 0;
searchText = "img/oferta_perdida.png";
searchTextpagina = "carritos/view";
//comparamos la  busqueda de la url de la imagen
for (let j = 0; j < img.length; j++) {
var imgtitle = img[j].currentSrc;
if (imgtitle.indexOf(searchText) > -1) {
//hacemos un contador para saber cuantas  imagenes de oferta perdida se encuentran en el dom.
total++;
}

}

if (total > 0) {
if(total>1){
var ofertas = "OFERTAS";
}else{
var ofertas = "OFERTA";
}
alertify.confirm(
'<?php echo $this->Html->image('oferta_perdida_grande.png', ['title' => 'Oferta Perdida']); ?>',
"<b>Usted Está <FONT COLOR='red'>Perdiendo <u>"+total +" "+ofertas+".</u></FONT> ¿Desea continuar o prefiere revisar el carro de compras? </b><br>",
function() {

if (URLactual.search(searchTextpagina) > -1) {
var link =$("#vercarro");
var linkoriginal=   link.attr("href");
link.attr("href",linkoriginal+"?asSAWCsas13s=1");

} else { 
var link =$("#vercarro");
var linkoriginal=   link.attr("href");
link.attr("href",linkoriginal+"?asSAWCsas13s=1");
//simula click en botton ver carro
document.getElementById("vercarro").click();
$('#tab1').focus();
}

},
function() {
}
).set('labels', {
ok: 'Revisar Carro',
cancel: 'Continuar'
}).set({
'closableByDimmer': false
}).closeOthers();
} else {
//envia el form o en su defecto se dirigue a la pagina de cofirm
document.getElementById("enviarbtnenviar").submit();

}
}
//al llamar esta funcion se recarga la pagina enviando el parametro id
function modificaoferta(idarticulo) {
location.href = `view?art=${idarticulo}`;
}


//Se ejecuta al cargar la pagina completamente.
$(function() {
// Crear un objeto URL con la ubicación de la página
let url = new URL(window.location.href);
// Busca si existe el parámetro
let art = url.searchParams.get('art');
let link = url.searchParams.get('asSAWCsas13s');        
if (art) {
// Si se encontró, entonces ejecuta la función
focusarticulo(art);
}else if(link){
focusarticulolink();
}
});

//al hacer click al boton ajs.cancel envia el submit
$(document).on('click', '.ajs-cancel', function() {

//valida si el botton contiene en su texto Continuar
if($(this).text()==="Continuar"){
document.getElementById("enviarbtnenviar").submit();}
});



function focusarticulo(art) {
// hace focus en el data-id.
$('input[data-id=' + art + ']').focus();
}

function focusarticulolink() {
// hace focus en el data-id.
$('#tab2').focus();
}
</script>