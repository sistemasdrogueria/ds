<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class=no-js> <!--<![endif]-->

<head>
<meta name=viewport content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<title>DROGUERIA SUR</title>
<meta charset=utf-8>
<meta name=description content>
<?php echo $this->fetch('meta');
echo $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']);
echo $this->Html->css('jquery-ui.min');
echo $this->Html->script('jquery-1.11.3.min');
echo $this->Html->css('bootstrap');
echo $this->Html->script('bootstrap');
echo $this->Html->script('jquery-ui-1.10.4.custom.min');
echo $this->Html->css('alertify/alertify');
echo $this->Html->css('normalize.min');
echo $this->Html->css('font-awesome.min');
echo $this->Html->css('templatemo-misc.min');
echo $this->Html->css('templatemo-style-delia.min');
echo $this->Html->css('stylebar.min');
echo $this->Html->script('functionsadd.js?' . $filever = filesize('js/functionsadd.js'));
echo $this->Html->css('layouts/store_delia_footer');
?>
<script type="text/javascript">
var myBaseUrlsSearch_ajax = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'search_ajax')); ?>';
var myBaseUrlsitemupdateofertas = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'itemupdateofertas')); ?>';
var myBaseUrlsitemupdate = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'itemupdate')); ?>';
var myBaseUrlsbuscarpatagoniamed = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarpatagoniamed')); ?>';
var myBaseUrlsbuscarnutricionydeportes = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarnutricionydeportes')); ?>';
var myBaseUrlsbuscarperfumesdelia = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarperfumesdelia')); ?>';
var myBaseUrlsbuscarprodmedico = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarprodmedico')); ?>';
var myBaseUrlsbuscarcarritospromocion = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarcarritospromocion')); ?>';
var myBaseUrlsbuscarcarritos = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarcarritos')); ?>';
var myBaseUrlsbuscarcarritospoint = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarcarritospoint')); ?>';
var myBaseUrlsbuscarvista4 = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarvista4')); ?>';
var myBaseUrlsvaciar = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'vaciar')); ?>';
var myBaseUrlsvaciardeletecarritotemps = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'deletecarritotemps')); ?>';
var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'delete')); ?>';
var imgborrarcar = '<?php echo \Cake\Routing\Router::url('/img/delete_ico.png'); ?>';
var myBaseUrlsitemupdatetemps = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'itemupdatetemps')); ?>';
var imgarticulos = '<?php echo \Cake\Routing\Router::url('/img/productos'); ?>';
var imggeneral = '<?php echo \Cake\Routing\Router::url('/img'); ?>';
var itemupdate = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'itemupdate')); ?>';
var myBaseUrlsclientecredito = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'clientecredito')); ?>';
var myBaseUrlsmedicamentos = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'medicamentos')); ?>';
var myBaseUrlsperfu = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'perfumesycosmetica')); ?>';
var myBaseUrlsusersadd = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Users', 'action' => 'add')); ?>';
var myBaseUrlsuserschange = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Users', 'action' => 'change_password')); ?>';
var myBaseUrleditacliente = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Clientes', 'action' => 'edit_email')); ?>';
var myBaseUrldeletefalta = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'deletefalta')); ?>';
var myBaseUrlsUpdateFalta = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'updatefaltas')); ?>';
</script>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel=stylesheet>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
<!--[if lt IE 7]>
<p class=chromeframe>Estas usando un <strong>anticuado</strong> Navegador. Por favor <a href=http://browsehappy.com/>actualice su navegador</a> o <a href="http://www.google.com/chromeframe/?redirect=true">active Google Chrome Frame</a>para mejor la experiencia.</p>
<![endif]-->
<header class=site-header style="background :#000;">
<div class=main-header style="background :#000;">
<div class=container>
<div>
<div class="col-md-5 col-sm-3 col-xs-3">
<!-- div class=logods -->
<div>
<?php echo $this->Html->image('logo_delia.png', ['alt' => 'Drogueria Sur S.A.', 'id' => 'logo_delia', 'url' => ['controller' => 'DeliaPerfumerias', 'action' => 'index']]); ?>
</div>
</div>
<div class="col-md-2 col-sm-3 col-xs-3">
<!-- div class=logods -->
<div id=titulo_logo style=" text-align:center; height: 50px;">
</div>
</div>
<?php echo $this->element('headerDelia'); ?>
</div>
</div>
</div>
</header>
<div class=content-section>
<!-- div class=container -->
<div class=row>
<div id=mensaje style="display:none">
<?= $this->Flash->render('changepass'); ?>
</div>
<?= $this->fetch('content') ?>
</div>
<!-- /div-->
</div>
<div class=content-section>
<div class=container>

<div id="dialog_carro" hidden="hidden" style="z-index:100;">
<div class="col-md-12">
<div class=product-item-8 style="z-index:100;">
<div class=product-content4 style="z-index:100;">
<div class=row><?php echo $this->element('cartresum'); ?></div>
</div>
<div class="product-content4">
<div class="row"> <?php echo $this->element('botonescarro'); ?>
    <div class="cartresul"> <?php echo $this->element('cartresult'); ?> </div>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
<footer class="footer-section">
<div class="container-footer">
<div class="footer-cta">
<div class="cta-flex">
<div class="single-cta">
<i class="fas fa-map-marker-alt cta-icon"></i>
<div class="cta-text">
<h4>Encontranos</h4>
<?= $this->Html->link('Buenos Aires, Bahía Blanca, Villarino 46/58 (B8000JIB)', 'https://maps.app.goo.gl/S5nDzfQfqkZcukX56', ['style' => 'text-decoration: none; color: #757575;', 'target' => '_blank']); ?>
</div>
</div>
<div class="single-cta">
<i class="fa-brands fa-whatsapp cta-icon"></i>
<div class="cta-text">
<h4>Whatsapp</h4>
<?= $this->Html->link('+54 9 291 425-4968', 'https://api.whatsapp.com/send?phone=5492914254968', ['style' => 'text-decoration: none; color: #757575;']); ?>
</div>
</div>
<div class="single-cta">
<i class="fas fa-phone cta-icon"></i>
<div class="cta-text">
<h4>Llamanos</h4>
<?= $this->Html->link('+54 9 291 574-4844', 'tel:+5492915744844', ['style' => 'text-decoration: none; color: #757575;']); ?>
</div>
</div>
<div class="single-cta">
<i class="far fa-envelope-open cta-icon"></i>
<div class="cta-text">
<h4>Correo</h4>
<?= $this->Html->link('contacto@drogueriasur.com.ar', 'mailto:contacto@drogueriasur.com.ar', ['style' => 'text-decoration: none; color: #757575;']); ?>
</div>
</div>
</div>
</div>
<div class="footer-content">
<div class="footer-flex">
<div class="footer-widget">
<div style="display: flex;align-items: flex-end;gap: 100px;">
<div class="footer-logo">
    <?= $this->Html->link(
        $this->Html->image('logo_ds_blanco.png', [
            'class' => 'imglogostore',
            'alt' => 'logo',
            'fullBase' => true
        ]),
        ['controller' => 'carritos', 'action' => 'index'],
        ['escape' => false]
    ); ?>
</div>

<div class="footer-logo">
    <?= $this->Html->link(
        $this->Html->image('logo_delia_p.png', [
            'class' => 'imglogostore',
            'alt' => 'logo',
            'style' => 'width:100px',
            'fullBase' => true
        ]),
        ['controller' => 'DeliaPerfumerias', 'action' => 'index'],
        ['escape' => false]
    ); ?>
</div>
</div>
<div class="footer-text">
<p>Porque pensamos de manera innovadora, creamos vínculos sólidos y aportamos a una visión
    completa del negocio. Ofrecemos un servicio integral y perfeccionado, diseñado para
    clientes exigentes, comprometidos con la excelencia.</p>
</div>
<div class="footer-social-icon">
<span>Síguenos</span>
<?= $this->Html->link('<i class="fab fa-facebook-f"></i>', 'https://www.facebook.com/p/Drogueria-Sur-SA-100064878302419', [
    'class' => 'facebook-bg',
    'target' => '_blank',
    'escape' => false
]); ?>

<?= $this->Html->link('<i class="fab fa-twitter twitter-bg"></i>', 'https://x.com/DrogueriaSur/', [
    'class' => 'twitter-bg',
    'target' => '_blank',
    'escape' => false
]); ?>

<?= $this->Html->link('<i class="fab fa-instagram"></i>', 'https://www.instagram.com/drogueria.sur/', [
    'class' => 'instagram-bg',
    'target' => '_blank',
    'escape' => false
]); ?>
</div>
</div>
<div class="footer-widget">
<div class="footer-widget-heading">
<h3>Enlaces útiles</h3>
</div>
<ul>
<li><?php echo $this->Html->link('Home', ['controller' => 'carritos', 'action' => 'index']); ?></li>
<li><?php echo $this->Html->link('Fragancias', ['controller' => 'DeliaPerfumerias', 'action' => 'fragancias']); ?></li>
<li><?php echo $this->Html->link('Dermo', ['controller' => 'DeliaPerfumerias', 'action' => 'dermo']); ?></li>
<li><?php echo $this->Html->link('Estetica', ['controller' => 'DeliaPerfumerias', 'action' => 'estetica']); ?></li>
<li><?php echo $this->Html->link('Solares', ['controller' => 'DeliaPerfumerias', 'action' => 'solares']); ?></li>
<li><?php echo $this->Html->link('Make Up', ['controller' => 'DeliaPerfumerias', 'action' => 'makeup']); ?></li>
</ul>
</div>
</div>
</div>
</div>
<div class="copyright-area">
<div class="container-footer">
<div class="footer-flex">
<div class="copyright-text">
<p>Copyright &copy; <?php echo date("o"); ?>, Todos los derechos reservados <?php echo $this->Html->link('DrogueriaSur', ['controller' => 'Carritos', 'action' => 'index'], ['style' => 'color: #2a80b9; text-decoration: none;']); ?>
</div>
<div class="footer-menu">
<ul>
<li><?php echo $this->Html->link('Términos y condiciones', ['controller' => 'Novedades', 'action' => 'condiciones']); ?></li>
</ul>
</div>
</div>
</div>
</div>
</footer>
<?php //echo $this->Html->script('jquery.easing.1.3.min');
echo $this->Html->script('modernizr-2.6.2.min');
echo $this->Html->script('jquery.quick.pagination.min');
echo $this->Html->script('jquery-scrolltofixed.min');
echo $this->Html->script('modal');
echo $this->Html->css('jquery.notifyBar.min');
echo $this->Html->script('jquery.notifyBar.min');

//echo $this->Html->script('plugins.min');
echo $this->Html->script('alertify/alertify');
//echo $this->Html->script('main.min');
//echo $this->Html->script('scriptbar');
?>
<script>
$(document).ready(main);
var contador = 0;

function main() {
$(".menu_bar").click(function() {
if (contador == 0) {
$("nav").animate({
left: "-110%"
});
contador = 1
} else {
contador = 0;
$("nav").animate({
left: "0"
})
}
})
}
$(document).ready(function() {
$(".formcartcant, .formcartcantof").keydown(function(a) {
if (a.keyCode == 46 || a.keyCode == 8 || a.keyCode == 9 || a.keyCode == 27 || a.keyCode == 13 || (a.keyCode == 65 && a.ctrlKey === true) || (a.keyCode >= 35 && a.keyCode <= 39)) {
if (a.keyCode == 9) {}
return
} else {
if (a.shiftKey || (a.keyCode < 48 || a.keyCode > 57) && (a.keyCode < 96 || a.keyCode > 105)) {
a.preventDefault()
}
}
});
$(".formcarritocant, .formcartcantof").keydown(function(a) {
if (a.keyCode == 46 || a.keyCode == 8 || a.keyCode == 9 || a.keyCode == 27 || a.keyCode == 13 || (a.keyCode == 65 && a.ctrlKey === true) || (a.keyCode >= 35 && a.keyCode <= 39)) {
if (a.keyCode == 9) {}
return
} else {
if (a.shiftKey || (a.keyCode < 48 || a.keyCode > 57) && (a.keyCode < 96 || a.keyCode > 105)) {
a.preventDefault()
}
}
})
});
$(function() {
var c = document.getElementById("flashmensajesuccess");
if (c != null) {
if (c.innerHTML != "") {
$.notifyBar({
cssClass: "success",
html: c.innerHTML,
position: "bottom"
})
}
}
var b = document.getElementById("flashmensajeerror");
if (b != null) {
if (b.innerHTML != "") {
$.notifyBar({
cssClass: "error",
html: b.innerHTML,
close: true,
closeOnClick: false
})
}
}
var a = document.getElementById("flashmensajewarning");
if (a != null) {
if (a.innerHTML != "") {
$.notifyBar({
cssClass: "warning",
html: a.innerHTML
})
}
}
});
(function(d, e, j, h, f, c, b) {
d.GoogleAnalyticsObject = f;
d[f] = d[f] || function() {
(d[f].q = d[f].q || []).push(arguments)
}, d[f].l = 1 * new Date();
c = e.createElement(j), b = e.getElementsByTagName(j)[0];
c.async = 1;
c.src = h;
b.parentNode.insertBefore(c, b)
})(window, document, "script", "https://www.google-analytics.com/analytics.js", "ga");
ga("create", "UA-54312928-1", "auto");
ga('require', 'GTM-W56XFP5');
ga("send", "pageview");
</script>
</body>

</html>