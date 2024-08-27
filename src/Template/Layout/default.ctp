<!--DOCTYPE html -->
<?php echo $this->Html->docType('html5'); ?>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class=no-js> <!--<![endif]-->
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, maximum-scale=1">
<?php  /*
session_cache_limiter('public');
session_start();
// cache for 3600 seconds
header("Cache-Control: s-maxage=3600, public, max-age=3600");
$expire_time = new DateTime('UTC');
$expire_time->add(new DateInterval('PT3600S')); // add 3600 seconds
$expire_time = $expire_time->format(DateTimeInterface::RFC7231);
header("Expires: $expire_time"); */
?>
<meta charset="utf-8">
<meta name="facebook-domain-verification" content="jz3sw0qxjwjo7dorjuu5iguwb12aiq" />
<meta property="og:title" content="DROGUERIA SUR SA" />
<meta property="og:description" content="DROGUERIA SUR SA" />
<meta property="og:image" content="https://www.drogueriasur.com.ar/ds/img/logo_ds_simple.png" />
<meta property="og:url" content="https://www.drogueriasur.com.ar/ds" />

<title>DROGUERIA SUR</title>
<?php
echo $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']);
echo $this->fetch('meta');
?>
<script type="text/javascript">
var MydataIg = '<?php if (isset($ipClien)) {
echo $ipClien;
} else {
}  ?>';
var onloadCallback = function() {
      // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
      // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
/*
      grecaptcha.render('example3_catcha', {
        'sitekey': '6Lf0c0EUAAAAAGN6LqoAB0U-m2T1HXNgIHivpHmo',
        'callback': verifyCallback,
        'theme': 'white'
      });
      */

     grecaptcha.ready(function() {
    function getNewRecaptchaToken() {
        grecaptcha.execute('6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB', {action: 'submit'}).then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
        });
    }

    // Inicialmente obtener el token
    getNewRecaptchaToken();
    document.getElementById('loginusers').style.display = 'block';
    // Vuelve a obtener el token cada cierto tiempo (por ejemplo, cada 2 minutos)
    setInterval(getNewRecaptchaToken, 2 * 60 * 1000); // 2 minutos en milisegundos
    });
    };
</script>
<!--[if lt IE 9]>
<?php
echo $this->Html->script('respond-1.1.0.min');
echo $this->Html->script('html5shiv');
echo $this->Html->script('html5element');
?>
<![endif]-->
<script type=application/ld+json>
{
"@context": "https://schema.org",
"@type": "Organization",
"url": "https://www.drogueriasur.com.ar",
"contactPoint": {
"@type": "ContactPoint",
"telephone": "+54-0291-458-3077",
"contactType": "Customer service"
},
"logo": "https://www.drogueriasur.com.ar/ds/img/logods.png",
"address": {
"@type": "PostalAddress",
"addressLocality": "Bahia Blanca, Buenos Aires, Argentina",
"postalCode": "8000",
"streetAddress": "Villarino 52"
},
}
</script>
<style>
.my-fixed-item{position:fixed;z-index:99;top:90%;left:90%;}
.my-fixed-item img {margin-right: 15px;}
#loading-modal {display: none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background-color: rgba(0, 0, 0, 0.5);/* Fondo semitransparente */z-index: 9999;}
.modal-content-loading {position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);background-color: white;/* Color de fondo del modal */padding: 20px;border-radius: 8px;}
#example3_catcha { position: absolute;top: 4%;margin-top: 15px;float: right;margin-left: 40%;}
@media only screen and (max-width: 768px) {
#example3_catcha {top: 10%;margin-left: 20%;}}
@media only screen and (min-width: 600px) and (max-width: 767px) {
#example3_catcha {top: 170%;margin-left: 20%;}}
@media only screen and (min-width: 769px) and (max-width: 1024px) {
#example3_catcha {top: 150%;margin-left: 27%;}
.top_cont_outer {margin-top: 4%;}}
@media only screen and (max-width: 600px) {
#example3_catcha {top: 15%;margin-left: 10%;position: relative;}
.top_cont_outer {margin-top: 4%;}}
#loginusers{display:none;}
</style>
</head>

<body>
<!--Header_section-->
<header id="header_wrapper">
<div class="container">
<div class="header_box">
<div style="float: left">
<div class="logo" style="margin-top: 25px "> <?php echo $this->Html->image('logo_ds.png', ['url' => ['controller' => 'pages', 'action' => 'display']], ['alt' => 'Drogueria Sur S.A.']); ?> </div>
</div>
<div style="float: right">
<nav class="navbar navbar-inverse" role="navigation">
<div class="navbar-header">
<button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
</div>
<div id="main-nav" class="collapse navbar-collapse navStyle">
<ul class="nav navbar-nav" id="mainNav">
<li class="active"><a href="#hero_section" class="scroll-link">Inicio</a></li>
<li><a href="#aboutUs" class="scroll-link">La empresa</a></li>
<li><a href="#service" class="scroll-link">Servicios</a></li>
<li><?= $this->Html->link('Trabajar con nosotros', ['controller' => 'Jobs', 'action' => 'index'], ['class' => 'scroll-link']) ?></li>
<li><a href="#contact" class="scroll-link">Contacto</a></li>
</ul>
</div>
</nav>
<div id="mensaje" style="display:none;"> <?= $this->Flash->render('changepass'); ?> </div>
<?= $this->Form->create(null, ['url' => ['controller' => 'users', 'action' => 'login'], 'name' => 'confirmInput', 'id' => 'loginusers']) ?>

<div class="input_text_login">
<div class="input_text_input">
<?= $this->Form->input('username', ['class' => 'input-text2', 'id' => 'username', 'label' => '', 'type' => 'text', 'placeholder' => 'Usuario *']); ?>
</div>
<div class="input_text_input">
<?= $this->Form->password('password', ['class' => 'input-text2', 'id' => 'password', 'label' => '', 'type' => 'password', 'placeholder' => 'Contraseña *']); ?>
</div>
          <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
<div class="input_text_input">
<?= $this->Form->button('Ingresar', ['class' => 'buttonlogin', 'type' => 'submit']) ?>
<form action="?" method="POST">
<div id="example3_catcha"></div>
<br>
</form>



</div>
<?= $this->Form->end(['data-type' => 'hidden']) ?>
</div>
<?= $this->Flash->render() ?>
<div style="float: right;display: block;margin: 10px;"> ¿Todavía no sos cliente? <br>Hacé <?= $this->Html->link(__("click acá"), ['controller' => 'ClientesAltas', 'action' => 'add']) ?> para serlo.</div>
</div>
</div>
</div>
</header>
<!--Header_section-->
<!--Hero_Section-->
<div class=my-fixed-item align="center"><?php echo $this->Html->image('icon_whatsapp.png', ['url' => 'https://api.whatsapp.com/send?phone=5492914254968'], ['target' => '_blank', '_full' => true, 'escape' => true, 'alt' => 'WHATSAPP']); ?></div>
<section id="hero_section" class="top_cont_outer">
<div class="hero_wrapper">
<!-- div class="container" -->
<div class="hero_section">
<div class="row" style=" margin-right: 0px; margin-left: 0px;">
<div class="col-lg-12 col-sm-12" style="padding-right: 0px; padding-left: 0px;">
<div class="imagen_pres">
<div style=" height: 100%; width: 100% ;margin: 0 auto;">
<div id="gallery" style="margin: 0 auto; ">
<style>
/* jssor slider loading skin spin css */
.jssorl-009-spin img {
animation-name: jssorl-009-spin;
animation-duration: 1.6s;
animation-iteration-count: infinite;
animation-timing-function: linear;
}
@keyframes jssorl-009-spin {from {transform: rotate(0deg);}
to {transform: rotate(360deg);}}
</style>
<div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
<!-- Loading Screen -->
<!-- Slides Container -->
<div data-u="slides" style="position: absolute; left: 0px; top: 0px; width: 1300px; height: 500px; overflow: hidden;">
<?php
if (!empty($inicio_slider) && !is_null($inicio_slider))
foreach ($inicio_slider as $slider) :
if (($slider["url_controlador"] == "") && ($slider["url_metodo"] == "")) {
if ($slider["url_campo"] == "")
echo '<div>' . $this->Html->image('inicio/' . $slider['imagen'], ['data-u' => 'image', 'loading' => 'lazy']) . '</div>';
else
echo '<div>' . $this->Html->image('inicio/' . $slider['imagen'], ['url' => $slider["url_campo"], 'data-u' => 'image', 'loading' => 'lazy'], ['target' => '_blank', '_full' => true, 'escape' => false, 'loading' => 'lazy']) . '</div>';
} else 
if (($slider["url_controlador"] != "") && ($slider["url_metodo"] != ""))
echo '<div>' . $this->Html->image('inicio/' . $slider['imagen'], ['url' => ['controller' => 'Carritos', 'action' => 'search'], 'data-u' => 'image', 'loading' => 'lazy'], ['target' => '_blank', '_full' => true, 'escape' => false, 'loading' => 'lazy']) . '</div>';
if ($slider['url_controlador']=="URL")
{
echo '<div><a href="'.$slider['url_campo'].'" target ="_blank">'.$this->Html->image('inicio/'.$slider['imagen'], ['alt' => 'LINK','width'=>'100%','target' => '_blank', '_full' => true, 'escape' => false, 'loading' => 'lazy'] ) .'</a></div>';
}

endforeach;
?>
</div>
<!--#region Bullet Navigator Skin Begin -->
<style>
.jssorb031 {position: absolute;}
.jssorb031 .i {position: absolute;cursor: pointer;}
.jssorb031 .i .b {fill: #000;fill-opacity: 0.5;stroke: #fff;stroke-width: 1200;stroke-miterlimit: 10;stroke-opacity: 0.3;}
.jssorb031 .i:hover .b {fill: #fff;fill-opacity: .7;stroke: #000;stroke-opacity: .5;}
.jssorb031 .iav .b {fill: #fff;stroke: #000;fill-opacity: 1;}
.jssorb031 .i.idn {opacity: .3;}
</style>
<div data-u="navigator" class="jssorb031" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
<div data-u="prototype" class="i" style="width:16px;height:16px;">
<svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
<circle class="b" cx="8000" cy="8000" r="5800"></circle>
</svg>
</div>
</div><!--#endregion Bullet Navigator Skin End -->
<!--#region Arrow Navigator Skin Begin -->
<style>
</style>
</div><!-- Jssor Slider End -->
</div>
</div>
</div>
</div>
</div>
</div>
</div><!-- /div --></div>
</section>
<?php echo $this->element('page_index_promos'); ?>
<!--Hero_Section-->
<section id=aboutUs>
<div class=inner_wrapper>
<div class=container>
<h2>La Empresa</h2>
<div class=inner_section>
<div class=row>
<div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 pull-right">
<p><strong>Identificación con las marcas y comercialización legitima:</strong></p>
<p class=texto>Comercializamos productos de laboratorios de reconocidas marcas existentes en el mercado, garantizando la autenticidad por adquirirlos exclusivamente de su productor original.</p>
<br>
<p><strong>Compromiso real con el ambiente:</strong></p>
<p class=texto>Trabajamos bajo estrictas normas que aseguren dentro de nuestra actividad, la conservación y preservación del medio ambiente, asumiendo como principio de responsabilidad empresaria la divulgación de toda agresión a los recursos no renovables y al ambiente en si, participando en la cultura y toma de conciencia de toda la población.</p>
<br>
<p class=slogan><strong>"PORQUE PENSAMOS DIFERENTE, DESARROLLAMOS VINCULOS CONVINCENTES Y CONTRIBUIMOS A LA VISION ABSOLUTA DEL NEGOCIO. SIMPLEMENTE OFRECEMOS UN SERVICIO INTEGRAL Y PERFECCIONADO, PARA CLIENTES SOFISTICADOS COMPROMETIDOS CON LA EXCELENCIA."</strong> </p>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
<div class="delay-01s animated fadeInDown wow animated">
<p class=texto>Somos una droguería integral, de capitales independientes, fundada en el año 1970 en la ciudad de Bahía Blanca, provincia de Buenos Aires.</p>
<p class=texto>Con flota propia y planta automatizada de 7000m2 ubicada en el corazón céntrico de la ciudad, abastecemos diariamente a 7 provincias:
Buenos Aires, La Pampa, Neuquén, Rio Negro, Chubut, Santa Cruz y Tierra del Fuego. </p>
<p class=texto>Contamos con un staff de más de 200 colaboradores que hacen posible que cada día los 1400 clientes activos de la droguería, reciban sus pedidos.</p>
<p class=texto>Con la misión de brindar un servicio diferente y perfeccionado, distribuimos mensualmente más de 2.000.000 de unidades, recorriendo aproximadamente 163.000 kilómetros lo que equivale a 5 vueltas al mundo.</p>
<br>
<p><strong>Integralidad:</strong></p>
<p class=texto>Comercializamos todos los productos existentes en el mercado, ya sean ambulatorios, otc, tratamientos especiales, oncología, perfumería, accesorios, etc. </p>
</br>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!--Aboutus-->
<!--Service-->
<section id=service>
<div class=container>
<h2>SOBRE NUESTROS SERVICIOS</h2>
<div class=service_wrapper>
<div class=row>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
<p>• Atención personalizada y servicio diseñado a medida.</p>
<p>• Asesoramiento sobre compras iniciales y mantenimiento de niveles óptimos de stock.</p>
<p>• Acreditación directa en cuenta corriente de las ventas con tarjeta de crédito/débito. </p>
<p>• Departamento de Telemarketing para toma de pedidos. </p>
<p>• Departamento exclusivo para venta de transfers y negocios especiales.</p>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
<p>• Emisión mensual de revista con contenido de ofertas e información de interés general.</p>
<p>• Entregas diarias a 160 localidades.</p>
<p>• Sitio de E-commerce perfeccionado, intuitivo y amigable.</p>
<p>• Amplia disponibilidad de stock. </p>
<p>• Club de beneficios Comunidad Sur: canje de puntos por premios.</p>
</div>
</div>
</div>
</div>
</section>
<!--Service-->
<!--page_section-->
<section class="page_section team" id="novedades"><!--main-section team-start-->
<?= $this->fetch('content') ?>
</section> <!--/Team-->
<!--Footer-->
<footer class="footer_wrapper" id="contact">
<div class="container">
<section class="page_section contact" id="contact">
<div class="contact_section">
<h2>CONTACTANOS</h2>
</div>
<div class="row">
<div class="col-lg-12 wow fadeInLeft delay-06s">
<?php
echo $this->Form->create('contacto', ['url' => ['controller' => 'contactos', 'action' => 'enviar_mail'], 'id' => "contactanos"]);
$opciones = ['Departamento de Cobranzas', 'Departamento de Ventas', 'Departamento de Compras', 'Departamento de Patagonia Med', 'Departamento de Perfumeria', 'Departamento de Sistemas'];
echo $this->Form->input('departamento', ['class' => 'input-text', 'type' => 'hidden']);
echo $this->Form->input('nombre', ['class' => 'input-text', 'placeholder' => 'Nombre *']);
echo $this->Form->input('telefono', ['class' => 'input-text', 'placeholder' => 'Telefono *']);
echo $this->Form->input('email', ['class' => 'input-text', 'placeholder' => 'Email *', 'type' => 'email']);
echo $this->Form->textarea('detalle', ['class' => 'input-text text-area', 'placeholder' => 'Detalle *', 'type' => 'text']);
echo $this->Form->button('Enviar mensaje', ['class' => 'input-btn']);
echo $this->Form->end();
?>
</div>
</div>
</section>
</div>
<div id="loading-modal">
<div class="modal-content-loading">
<?php echo
$this->Html->image('cargando.gif', ['width' => 50]); ?>
</div>
</div>
<div class="container">
<div class="footer_bottom">
<div class="contact_section">
<?php echo '<div style="  display: flex;  height: 100%;  justify-content: center;  align-items: center;">' . $this->Html->image('logo_ds_blanco.png', ['data-u' => 'image']) . '</div>'; ?>
</div>
<div class="col-md-4" style="text-align: center;">
<div class="member wow bounceInUp animated">
<div class="member-container" data-wow-delay=".1s">
<div class="inner-container">
<div style="margin-top: 10px;"> Villarino 46/58 (B8000JIB) </br>Bahía Blanca - Buenos Aires</br>(0291) 458 3077 </br>
<a href="mailto:sursa@drogueriasur.com.ar">sursa@drogueriasur.com.ar</a> </br>
</div>
</div><!-- /.inner-container -->
</div><!-- /.member-container -->
</div><!-- /.member -->
</div>
<div class="col-md-4" style="text-align: center;">
<div class="member wow bounceInUp animated">
<div class="member-container" data-wow-delay=".1s">
<div class="inner-container">
<h4>Call Center</h4>
<h5>Línea General: (0291) 458 3077</br></br> </h5></br>
</div><!-- /.inner-container -->
</div><!-- /.member-container -->
</div><!-- /.member -->
</div>
<div class="col-md-4" style="text-align: center;">
<div class="member wow bounceInUp animated">
<div class="member-container" data-wow-delay=".1s">
<div class="inner-container">
<h4>Horario de atención:</h4> Lunes a Viernes de 8 a 21 hs. </br>
<div class=iconos_redes>
<?php
echo '<div class=icon_redes><a href="https://www.facebook.com/Drogueria-Sur-SA-1755094597880789" target ="_blank">' . $this->Html->image('icon_FACEBOOK.png', ['width' => 40]) . '</a></div>';
echo '<div class=icon_redes><a href="https://www.instagram.com/drogueria.sur/" target ="_blank">' . $this->Html->image('icon_IG.png', ['width' => 40]) . '</a></div>';
echo '<div class=icon_redes><a href="https://www.youtube.com/channel/UCUx38S2H5I5STL407bBWN8A/featured" target ="_blank">' . $this->Html->image('icon_YOUTUBE.png', ['width' => 40]) . '</a></div>';
echo '<div class=icon_redes><a href="https://twitter.com/a_drogueria?s=20" target ="_blank">' . $this->Html->image('icon_TWITTER.png', ['width' => 40]) . '</a></div>';
?>
</div>
</div><!-- /.inner-container -->
</div><!-- /.member-container -->
</div><!-- /.member -->
</div>
<div class="col-md-12">
<span>Droguería Sur SA © <?php echo date("o"); ?></span>
</div>
</div>
</div>
</footer>
<?php
echo $this->Html->script('jquery-1.11.0.min');
echo $this->Html->script('jquery-ui.min');
echo $this->Html->css('bootstrap');
echo $this->Html->css('style.min');
echo $this->Html->script('bootstrap.min');
echo $this->Html->script('jquery-scrolltofixed.min');
echo $this->Html->script('jquery.nav.min');
echo $this->Html->script('jquery.easing.1.3.min');
echo $this->Html->script('jquery.isotope.min');
echo $this->Html->script('wow.min');
echo $this->Html->script('custom2.min');
echo $this->Html->script('bjqs-1.3.min');
echo $this->Html->script('jquery.notifyBar.min');
echo $this->Html->css('jquery-ui.min');
echo $this->Html->script('sweetalert2.all.min');
echo $this->Html->css('jquery.notifyBar.min');
echo $this->Html->script('https://www.google.com/recaptcha/api.js?render=6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB');
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-54312928-1"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
</script>
<script type="text/javascript">
function encodeEmail(email) {
// Split the email into two parts: before and after the @ symbol
var parts = email.split('@');

if (parts.length !== 2) {
// Not a valid email format
return email;
}
var namePart = parts[0];
var domainPart = parts[1];
// Determine the number of characters to show before the asterisks
var visibleCount = Math.min(4, namePart.length);
// Create a string of asterisks for the hidden part
var hiddenPart = namePart.substring(visibleCount).replace(/./g, '*');
// Reassemble the email
return namePart.substring(0, visibleCount) + hiddenPart + '@' + domainPart;
}
async function showAlertCode(email, validate, id) {
var encodedEmail = encodeEmail(email);
const {
value: accept
} = await Swal.fire({
title: "Solicitar código de validación.",
input: "checkbox",
inputPlaceholder: `
Confirmar solicitud de codigo
<br>
tu email es :` + encodedEmail + `
`,
inputValue: 0,
confirmButtonText: `
Continuar&nbsp;<i class="fa fa-arrow-right"></i>
`,
inputValidator: (result) => {
return !result && "Necesitas confirmar, para recibir un código.";
}
});
if (accept) {
var sendEmail = enviaremail(email, validate, id);
}
}
function mostrarImagenCarga() {
var loadingModal = document.getElementById('loading-modal');
loadingModal.style.display = 'block';
}
function ocultarImagenCarga() {
var loadingModal = document.getElementById('loading-modal');
loadingModal.style.display = '';
}
// Llamar a esta función después de que la página haya cargado
document.getElementById('loginusers').addEventListener('submit', function(event) {
event.preventDefault(); // Previene el envío automático del formulario
// Se realiza la validación y se procede si es exitosa
if (validatePassChange()) {
// Aquí podrías implementar una llamada AJAX para enviar el formulario de manera asíncrona
// o simplemente enviar el formulario como lo haces actualmente:
this.submit();
}
});
// Función para validar los campos del formulario
function enviaremail(email, token, id) {
mostrarImagenCarga();
$.ajax({
type: 'POST',
url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Users', 'action' => 'mailtosend')); ?>',
data: {
email: email,
token: token,
id: id,
},
dataType: 'json',
success: function(response) {
if (response.status === 'success') {
showAlertCodigo(id, email);
} else {
// Mostrar mensaje de error
alert(response.message);
}
},
error: function(xhr, status, error) {
// Manejar otros posibles errores
//  alert('Ha ocurrido un error en la petición.');
}
});

}

async function showAlertCodigo(id, email) {
ocultarImagenCarga();
var id = id;
const {
value: texto,
} = await Swal.fire({
title: "Validar código.",
input: "text",
inputLabel: "Ingresa el código enviado, no cierres esta pestaña.",
inputPlaceholder: "Ingresa el código",
allowOutsideClick: false, // Evita cerrar al hacer clic fuera del modal
allowEscapeKey: false, // Evita cerrar con la tecla ESC
allowEnterKey: true, // Permite cerrar con la tecla ENTER
inputValidator: (result) => {
return !result && "Necesitas Ingresar un codigo, para confirmar.";
}
});

if (texto && texto.trim() !== "") {
showAlertCodigoSend(texto, id);
} else {
// El texto está vacío o contiene solo espacios en blanco
// Realiza alguna acción, como mostrar un mensaje de error o manejarlo de otra manera
console.log("El texto está vacío o no es válido.");
}
}
function showAlertCodigoSend(texto, id) {
$.ajax({
type: 'POST',
url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Users', 'action' => 'validateLogin')); ?>',
data: {
token: texto,
id: id,
},
dataType: 'json',
success: function(response) {
if (response.status === 'success') {
if (response.message === 'valido') {
Swal.fire({
position: "top-end",
icon: "success",
title: "Código valido, ingresando al sistema.",
showConfirmButton: false,
timer: 1500
});
var form = document.getElementById('loginusers');
var input = document.createElement('input');

// Establecer el nombre y el valor del nuevo input
input.setAttribute('type', 'hidden'); // Tipo de input oculto
input.setAttribute('name', 'tokensinrecatpcha'); // Nombre del input
input.setAttribute('value', texto); // Valor del input

// Agregar el nuevo input al formulario
form.appendChild(input);

form.submit();
}
} else {
Swal.fire({
position: "top-end",
icon: "error",
title: "Código invalido, intente nuevamente.",
showConfirmButton: false,
timer: 1500
});
}
},
error: function(xhr, status, error) {
// Manejar otros posibles errores
alert('Ha ocurrido un error en la petición.');
}
});
}
function validatePassChange() {
var username = document.getElementById('username').value;
var password = document.getElementById('password').value;
if (typeof grecaptcha !== 'undefined') {
var recaptcha = document.getElementById('g-recaptcha-response').value;
} else {
if (username.trim() !== "" && password.trim() !== "") {

$.ajax({
type: 'POST',
url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Users', 'action' => 'loginValidacion')); ?>', // Asegúrate de que esta URL es correcta para tu aplicación
data: {
username: username,
password: password
},
dataType: 'json',
success: function(response) {
if (response.status === 'success') {
if (response.email) {

showAlertCode(response.email, response.validate, response.datadi);
} else {
Swal.fire({
icon: "error",
title: "Oops...",
text: "No tienes ningun email almacenado, comunicate con tu agente de ventas para almacenar un email.",
});
}
} else if (response.status === 'error') {
Swal.fire({
position: "top-end",
icon: "error",
title: "Contraseña o usuario incorrecto.",
showConfirmButton: false,
timer: 1500
});
} else {
}
},
error: function(xhr, status, error) {
// Manejar otros posibles errores
alert('Ha ocurrido un error en la petición.');
}
});
}
return false;
}
/*
if (MydataIg) {
if (MydataIg == '200.117.237.178' || MydataIg == '200.51.41.202') {
return true;
}
}*/
if (username.trim() === "") {
Swal.fire({
icon: "error",
title: "Oops...",
text: "Por favor, ingrese su nombre de usuario.",
footer: ''
});
return false;
}
if (password.trim() === "") {
Swal.fire({
icon: "error",
title: "Oops...",
text: "Por favor, ingrese su contraseña.",
footer: ''
});
return false;
}
if (recaptcha.trim() === "") {
// Usar SweetAlert2 para una mejor experiencia de usuario
Swal.fire({
icon: "error",
title: "Oops...",
text: "Por favor, valide el captcha.",
footer: ''
});
return false;
}
return true;
}
// Callback para verificar el reCAPTCHA
var verifyCallback = function(response) {
// Suponiendo que 'loginusers' es el id del formulario
var form = document.getElementById('loginusers');
// Busca si ya existe un input para el 'g-recaptcha-response'
var existingInput = form.querySelector('input[name="g-recaptcha-response"]');
// Si existe, actualiza su valor, si no, crea uno nuevo
if (!existingInput) {
existingInput = document.createElement('input');
existingInput.type = 'hidden';
existingInput.name = 'g-recaptcha-response';
form.appendChild(existingInput);
}
existingInput.value = response;
};
document.addEventListener('DOMContentLoaded', (event) => {
// El DOM está completamente cargado, pero otros recursos como imágenes podrían todavía no estarlo.
// Muestra el formulario de login

});
$(function() {
var UI = document.getElementById('flashmensajesuccess');
if (UI != null) {
if (UI.innerHTML != '') {
$.notifyBar({
cssClass: "success",
html: UI.innerHTML,
position: "bottom"
});
}
}
var UI2 = document.getElementById('flashmensajeerror');
if (UI2 != null) {
if (UI2.innerHTML != '') {
$.notifyBar({
cssClass: "error",
html: UI2.innerHTML,
close: true,
closeOnClick: false
});
}
}
var UI3 = document.getElementById('flashmensajewarning');
if (UI3 != null) {
if (UI3.innerHTML != '') {
$.notifyBar({
cssClass: "warning",
html: UI3.innerHTML
});
}
}
});
window.dataLayer = window.dataLayer || [];
function gtag() {
dataLayer.push(arguments);
}
gtag('js', new Date());
gtag('config', 'UA-54312928-1');
</script>
<?php echo $this->Html->script('docs.min'); ?>
<?php echo $this->Html->script('ie10-viewport-bug-workaround'); ?>
<?php echo $this->Html->script('jssor.slider.min'); ?>
<script>
jQuery(document).ready(function($) {
var options = {
$FillMode: 2,$AutoPlay: 1,$Idle: 1000,$PauseOnHover: 1,$ArrowKeyNavigation: 1,$SlideEasing: $Jease$.$OutQuint,$SlideDuration: 800,$MinDragOffsetToSlide: 20,$SlideSpacing: 0,
$UISearchMode: 1,$PlayOrientation: 1,$DragOrientation: 1,$BulletNavigatorOptions: {$Class: $JssorBulletNavigator$,$ChanceToShow: 2,$SpacingX: 8,$Orientation: 1},$ArrowNavigatorOptions: {$Class: $JssorArrowNavigator$,
$ChanceToShow: 2}
};
var jssor_slider1 = new $JssorSlider$("slider1_container", options);

function ScaleSlider() {
var bodyWidth = document.body.clientWidth;
if (bodyWidth)
jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
else
window.setTimeout(ScaleSlider, 30);
}
ScaleSlider();
$(window).bind("load", ScaleSlider);
$(window).bind("resize", ScaleSlider);
$(window).bind("orientationchange", ScaleSlider);
});
</script>
<script>
document.getElementById('contactanos').addEventListener('submit', function(event) {
event.preventDefault(); // Previene el envío inmediato del formulario
let nombre = document.querySelector('[name="nombre"]').value.trim();
let telefono = document.querySelector('[name="telefono"]').value.trim();
let email = document.querySelector('[name="email"]').value.trim();
let detalle = document.querySelector('[name="detalle"]').value.trim();
if (!nombre || !telefono || !email || !detalle) {
alert('Por favor, complete todos los campos requeridos.');
return; // Exit the event listener
}
grecaptcha.ready(function() {
grecaptcha.execute('6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB', {
action: 'submit'
}).then(function(token) {
// Agrega el token al formulario o reemplaza si ya existe
var form = document.getElementById('contactanos');
var existingInput = form.querySelector('input[name="g-recaptcha-response"]');
if (existingInput) {
existingInput.value = token;
} else {
var input = document.createElement('input');
input.type = 'hidden';
input.name = 'g-recaptcha-response';
input.value = token;
form.appendChild(input);
}
form.submit();
});
});
});
/*
document.getElementById('loginusers').addEventListener('submit', function(event) {
event.preventDefault(); // Previene el envío inmediato del formulario
grecaptcha.ready(function() {
grecaptcha.execute('6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB', {
action: 'submit'
}).then(function(token) {
// Agrega el token al formulario o reemplaza si ya existe
var form = document.getElementById('loginusers');
var existingInput = form.querySelector('input[name="g-recaptcha-response"]');
if (existingInput) {
existingInput.value = token;
} else {
var input = document.createElement('input');
input.type = 'hidden';
input.name = 'g-recaptcha-response';
input.value = token;
form.appendChild(input);
}
form.submit();
});
});
});
*/
</script>
</body>
</html>