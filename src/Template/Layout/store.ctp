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
<meta name="google" content="notranslate" />
<meta name=description content>

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
var myBaseUrlsusersadd = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Users', 'action' => 'add')); ?>';
var myBaseUrlsuserschange = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Users', 'action' => 'change_password')); ?>';
var imgarticulos = '<?php echo \Cake\Routing\Router::url('/img/productos'); ?>';
var imggeneral = '<?php echo \Cake\Routing\Router::url('/img'); ?>';
var itemupdate = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'itemupdate')); ?>';
var myBaseUrlsclientecredito = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'clientecredito')); ?>';
var myBaseUrlsmedicamentos = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'medicamentos')); ?>';
var myBaseUrlsperfu = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'perfumesycosmetica')); ?>';
var myBaseUrleditacliente = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Clientes', 'action' => 'edit_email')); ?>';
var myBaseUrldeletefalta = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'deletefalta')); ?>';
var myBaseUrlsUpdateFalta = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'updatefaltas')); ?>';
var myBaseUrlsaveconditions = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Clientes', 'action' => 'saveconditions')); ?>';
var saveSessionPregunta = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Sorteos', 'action' => 'saveSessionPregunta')); ?>';
var validarParticipacion = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Sorteos', 'action' => 'validarParticipacion')); ?>';
var participandoEnd = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Sorteos', 'action' => 'participando')); ?>';
</script>
<?php echo $this->fetch('meta');
echo $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']);
echo $this->Html->css('jquery-ui.min');
echo $this->Html->script('jquery-1.11.3.min');
echo $this->Html->script('bootstrap');
echo $this->Html->script('select2.min');
echo $this->Html->script('jquery-ui-1.10.4.custom.min');
echo $this->Html->css('bootstrap');
echo $this->Html->css('normalize.min');
echo $this->Html->css('font-awesome.min');/*echo $this->Html->css('animate.min');*/
echo $this->Html->css('templatemo-misc.min');
echo $this->Html->css('templatemo-style.min.css?' . $filever2 = filesize('css/templatemo-style.min.css'));
echo $this->Html->css('stylebar.min');
echo $this->Html->script('modernizr-2.6.2.min');
echo $this->Html->script('jquery.quick.pagination.min');
echo $this->Html->css('alertify/alertify');
echo $this->Html->script('alertify/alertify');
echo $this->Html->script('functionsadd.js?' . $filever = filesize('js/functionsadd.js'));
echo $this->Html->script('sweetalert2.all.min');
//echo $this->Html->script('marquee3k.js'); 
echo $this->Html->css('layouts/store_footer');
?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
$(function() {
$("#fechahasta, #fechadesde, #fecha_recepcion").datepicker({
dateFormat: "dd/mm/yy",
dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
firstDay: 1,
gotoCurrent: true,
monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
});
$(".main-menu ul.menu li a").click(function() {
$(this).addClass("active")
})
});
</script>
<!-- link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel=stylesheet -->
</head>

<body>
<!--[if lt IE 7]>
<p class=chromeframe>Estas usando un <strong>anticuado</strong> Navegador. Por favor <a href=http://browsehappy.com/>actualice su navegador</a> o <a href="http://www.google.com/chromeframe/?redirect=true">active Google Chrome Frame</a>para mejor la experiencia.</p>
<![endif]-->
<header class=site-header>
<div class=main-header>
<div class=container>
<div class=row>
<?php echo $this->element('header'); ?>
</div>
</div>
</div>
<div class=main-nav>
<div class=container>
<div class=row>
<div class="col-md-12 col-sm-12">
<div class=list-menu>
<div id=cssmenu>
<ul>
<li class='active has-sub'>
<?= $this->Html->link(__('Compras'), ['controller' => 'Carritos', 'action' => 'index']) ?>
<ul>
<li><?= $this->Html->link(__('Importar Archivos'), ['controller' => 'Carritos', 'action' => 'import']) ?></li>
<li><?= $this->Html->link(__('Pañales PAMI'), ['controller' => 'Carritos', 'action' => 'pami']) ?></li>
<!-- li><?= $this->Html->link(__('PRIMAVERA SALE'), ['controller' => 'Carritos', 'action' => 'primaverasale']) ?></li -->
<li><?= $this->Html->link(__('Oferta Venc.Cercano'), ['controller' => 'Carritos', 'action' => 'ofertavc']) ?></li>
<li><?= $this->Html->link(__('Libreria'), ['controller' => 'Carritos', 'action' => 'libreria']) ?></li>
<li><?= $this->Html->link(__('Realizados'), ['controller' => 'Pedidos', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Historico'), ['controller' => 'Pedidos', 'action' => 'searchproduct']) ?></li>
<li><?= $this->Html->link(__('Faltas'), ['controller' => 'Carritos', 'action' => 'faltas']) ?>
<div class=notificacionfalta><?php
    if ($this->request->session()->read('Auth.User.notificacionfalta') > 0)
        echo $this->Html->image('notificacion_falta.png', ['title' => 'FALTA']);
    ?>
<?php
if ($this->request->session()->read('Auth.User.notificacionfalta') > 0) {
if ($this->request->session()->read('Auth.User.notificacionfalta') > 9)
echo '<div class=notificacionfaltacantidadmas>+9';
else
echo '<div class=notificacionfaltacantidad>' . $this->request->session()->read('Auth.User.notificacionfalta');
echo '</div>';
} ?>
</div>
</li>
<li><?= $this->Html->link(__('Productos Nuevos'), ['controller' => 'Articulos', 'action' => 'nuevos']) ?></li>
<li class='active has-sub'>
<?= $this->Html->link(__('Devol/Reclamos'), ['controller' => 'Tickets', 'action' => 'index']) ?>
<ul>
<li><?= $this->Html->link(__('Cargar'), ['controller' => 'Tickets', 'action' => 'add']) ?></li>
<li><?= $this->Html->link(__('Realizados'), ['controller' => 'Tickets', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Recalls'), ['controller' => 'Tickets', 'action' => 'recall']) ?></li>
<li><?= $this->Html->link(__('Convenio de Vencido '), ['controller' => 'Descargas', 'action' => 'descargarformato', 8]) ?></li>
<li><?= $this->Html->link(__('Lab. Adheridos '), ['controller' => 'Descargas', 'action' => 'descargarformato', 9]) ?></li>
</ul>
</li>
<li><?= $this->Html->link(__('Estadisticas'), ['controller' => 'Estadisticas', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Ofertas perdidas'), ['controller' => 'Estadisticas', 'action' => 'viewOfertsToLose']) ?></li>
</ul>
</li>
<li class='active has-sub'>
<?= $this->Html->link(__('Cta. Cte'), ['controller' => 'CtacteEstados', 'action' => 'index']) ?>
<ul>
<li><?= $this->Html->link(__('Estado Actual'), ['controller' => 'CtacteEstados', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Compra Semanal'), ['controller' => 'CtacteComprasSemanales', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Resumen Semanal'), ['controller' => 'CtacteResumenSemanales', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Resumen Cuentas a Pagar'), ['controller' => 'CtacteResumenCuentas', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Detalle de Factura'), ['controller' => 'Facturas', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Pagos'), ['controller' => 'CtactePagos', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Comprobantes'), ['controller' => 'Comprobantes', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Facturas PAMI'), ['controller' => 'Facturas', 'action' => 'pami']) ?></li>
<li><?= $this->Html->link(__('Banco Info'), ['controller' => 'CtactePagos', 'action' => 'info']) ?></li>
</ul>
</li>
<li class='active has-sub'>
<?= $this->Html->link(__('Transfers'), ['controller' => 'PatagoniaMed', 'action' => 'index']) ?>
<ul>
<li><?= $this->Html->link(__('Transfers Vigentes'), ['controller' => 'PatagoniaMed', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Descargar'), ['controller' => 'PatagoniaMed', 'action' => 'consolidado']) ?></li>
<li><?= $this->Html->link(__('Estado Transfer LAB Solicitado'), ['controller' => 'Facturas', 'action' => 'transfer']) ?></li>
<!-- li><?= $this->Html->link(__('EXPOSUR VIRTUAL12'), ['controller' => 'Pedidos', 'action' => 'expo']) ?></li -->
</ul>
</li>
<li class='active has-sub'>
<?= $this->Html->link(__('Delia Perfu'), ['controller' => 'DeliaPerfumerias', 'action' => 'index']) ?>
<ul>
<!-- li><?= $this->Html->link(__('Fragancias'), ['controller' => 'DeliaPerfumerias', 'action' => 'fragancia']) ?></li -->
<li class='active has-sub'>
<?= $this->Html->link(__('Fragancias'), ['controller' => 'DeliaPerfumerias', 'action' => 'fragancia']) ?>
<ul>
<li><?= $this->Html->link(__('Selectivas'), ['controller' => 'DeliaPerfumerias', 'action' => 'fragancia', 'select']) ?></li>
<li><?= $this->Html->link(__('Semiselectivas'), ['controller' => 'DeliaPerfumerias', 'action' => 'fragancia', 'semiselect']) ?></li>


</ul>
</li>
<li><?= $this->Html->link(__('Dermocosmética'), ['controller' => 'DeliaPerfumerias', 'action' => 'dermo']) ?></li>
<li><?= $this->Html->link(__('Estética'), ['controller' => 'DeliaPerfumerias', 'action' => 'estetica']) ?></li>
<li><?= $this->Html->link(__('Solares'), ['controller' => 'DeliaPerfumerias', 'action' => 'solares']) ?></li>
<li><?= $this->Html->link(__('Make Up'), ['controller' => 'DeliaPerfumerias', 'action' => 'makeup']) ?></li>
<!-- li><?= $this->Html->link(__('Oferta Venc.Cercano'), ['controller' => 'Carritos', 'action' => 'ofertavc']) ?></li -->
</ul>
</li>
<li class='active has-sub'>
<?= $this->Html->link(__('Bienestar'), ['controller' => 'Bienestar', 'action' => 'index']) ?>
<ul>
<li><?= $this->Html->link(__('Almohadilla/Manta'), ['controller' => 'Bienestar', 'action' => 'search', 55]) ?></li>
<li><?= $this->Html->link(__('Balanza'), ['controller' => 'Bienestar', 'action' => 'search', 56]) ?></li>
<li><?= $this->Html->link(__('Ejercicio'), ['controller' => 'Bienestar', 'action' => 'search', 60]) ?></li>
<li><?= $this->Html->link(__('Masajeador'), ['controller' => 'Bienestar', 'action' => 'search', 59]) ?></li>
<li><?= $this->Html->link(__('Nebulizador'), ['controller' => 'Bienestar', 'action' => 'search', 53]) ?></li>
<li><?= $this->Html->link(__('Oximetro'), ['controller' => 'Bienestar', 'action' => 'search', 79]) ?></li>
<li><?= $this->Html->link(__('Tensiometro'), ['controller' => 'Bienestar', 'action' => 'search', 58]) ?></li>
<li><?= $this->Html->link(__('Termometro'), ['controller' => 'Bienestar', 'action' => 'search', 57]) ?></li>
<li><?= $this->Html->link(__('Yoga'), ['controller' => 'Bienestar', 'action' => 'search', 61]) ?></li>
</ul>
</li>
<li class='active has-sub'>
<?= $this->Html->link(__('Nutrición'), ['controller' => 'Nutricion', 'action' => 'index']) ?>
<ul>
<li><?= $this->Html->link(__('Alimentos Saludables'), ['controller' => 'Nutricion', 'action' => 'search', 0, 80]) ?></li>
<li><?= $this->Html->link(__('Leches Maternizadas'), ['controller' => 'Nutricion', 'action' => 'search', 0, 81]) ?></li>
<li><?= $this->Html->link(__('Soportes Nutricionales'), ['controller' => 'Nutricion', 'action' => 'search', 0, 19]) ?></li>
<li><?= $this->Html->link(__('Suplementos Dietarios'), ['controller' => 'Nutricion', 'action' => 'search', 0, 83]) ?></li>
<li><?= $this->Html->link(__('Otros Alimentos'), ['controller' => 'Nutricion', 'action' => 'search', 0, 82]) ?></li>

</ul>
</li>

<li><?= $this->Html->link(__('Ortopedia'), ['controller' => 'Ortopedias', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Acc y Prod Médico'), ['controller' => 'AccesoriosYProductosMedicos', 'action' => 'index']) ?></li>
<li class='active has-sub'>
<?= $this->Html->link(__('Home & Deco'), ['controller' => 'HomeYDecos', 'action' => 'index']) ?>
<ul>
<li><?= $this->Html->link(__('Bazar'), ['controller' => 'HomeYDecos', 'action' => 'search', 0, 49]) ?></li>
<li><?= $this->Html->link(__('Bolsos y Mochilas'), ['controller' => 'HomeYDecos', 'action' => 'search', 0, 47]) ?></li>
<li><?= $this->Html->link(__('Difusores'), ['controller' => 'HomeYDecos', 'action' => 'search', 0, 44]) ?></li>
<li><?= $this->Html->link(__('Entretenimiento'), ['controller' => 'HomeYDecos', 'action' => 'search', 0, 51]) ?></li>
<li><?= $this->Html->link(__('Esencias'), ['controller' => 'HomeYDecos', 'action' => 'search', 0, 84]) ?></li>
<li><?= $this->Html->link(__('Home Spray'), ['controller' => 'HomeYDecos', 'action' => 'search', 0, 46]) ?></li>
<li><?= $this->Html->link(__('Humidificadores'), ['controller' => 'HomeYDecos', 'action' => 'search', 0, 45]) ?></li>
<li><?= $this->Html->link(__('Limpieza'), ['controller' => 'HomeYDecos', 'action' => 'search', 0, 72]) ?></li>
<li><?= $this->Html->link(__('Pilas y Baterias'), ['controller' => 'HomeYDecos', 'action' => 'search', 0, 48]) ?></li>
<li><?= $this->Html->link(__('Sahumerios'), ['controller' => 'HomeYDecos', 'action' => 'search', 0, 85]) ?></li>
</ul>
</li>
<li class='active has-sub' id=novedades>
<?= $this->Html->link(__('Novedades'), ['controller' => 'Novedades', 'action' => 'comunicado']) ?>
<?php if ($this->request->session()->read('notificacion') > 0) {
echo "<div id='novedades_ico'><div>";
echo "<div id='novedades_text'>" . $this->request->session()->read('notificacion') . "</div></div></div>";
} ?>
<ul>
<li><?= $this->Html->link(__('Eventos'), ['controller' => 'Eventos', 'action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Descargas'), ['controller' => 'Descargas', 'action' => 'archivo']) ?></li>
<li><?= $this->Html->link(__('Noticias'), ['controller' => 'Novedades', 'action' => 'comunicado']) ?></li>
<li><?= $this->Html->link(__('Terminos y condiciones'), ['controller' => 'Novedades', 'action' => 'condiciones']) ?></li>
</ul>
</li>
<li class='active has-sub'>
<?= $this->Html->link(__('Catalogos'), ['controller' => 'Catalogos', 'action' => 'revista']) ?>
<ul>
<li><?= $this->Html->link(__('Revista'), ['controller' => 'Catalogos', 'action' => 'revista']) ?></li>
<!-- li><?= $this->Html->link(__('HOTSALE'), ['controller' => 'Carritos', 'action' => 'hotsale']) ?></li -->
<!-- li><?= $this->Html->link(__('Fiestas 21/22'), ['controller' => 'Catalogos', 'action' => 'especial']) ?></li -->
<!-- li><?= $this->Html->link(__('Solares 20/21'), ['controller' => 'Catalogos', 'action' => 'especial2']) ?></li-->
<!-- li class='promoespecial'> <?php echo $this->Html->image('promoespecial.png', ['alt' => 'Día del Niño!!', 'url' => ['controller' => 'Catalogos', 'action' => 'especial']]); ?></li -->
</ul>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- div class="marquee3k" data-speed="1" date-reverse="true" >
<div ><div class= marquee3k-texto>•    CYBER MONDAY 2024    •</div><div class=marquee3k-fecha> 4, 5 Y 6 DE NOVIEMBRE</div></div>
</div -->
</header>
<div class=content-section>
<div class=container>
<div class=row>
<div id=mensaje style=display:none>
<?= $this->Flash->render('changepass'); ?>
</div>
<?= $this->fetch('content') ?>
</div>
</div>
</div>
<div class=content-section>
<div class=container>

<div id="dialog_carro" hidden="hidden" style="z-index:100; padding: 10px;">
<div class="col-md-12">
<div class="product-item-8" style="z-index:100;">
<div class="product-content4" style="z-index:100;">
<div class="row"><?php echo $this->element('cartresum'); ?></div>
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
<div class="stars" aria-hidden="true"></div>

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
<?= $this->Html->link('+54 9 291 425-4968', 'https://api.whatsapp.com/send?phone=5492914254968', ['style' => 'text-decoration: none; color: #757575;', 'target' => '_blank']); ?>
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
<div class="footer-text">
<p>Porque pensamos de manera innovadora, creamos vínculos sólidos y aportamos a una visión
completa del negocio. Ofrecemos un servicio integral y perfeccionado, diseñado para
clientes exigentes, comprometidos con la excelencia.
</p>
</div>
<div class="footer-social-icon">
<span>Síguenos</span>
<?= $this->Html->link('<i class="fab fa-facebook-f"></i>', 'https://www.facebook.com/p/Drogueria-Sur-SA-100064878302419', [
'class' => 'facebook-bg',
'target' => '_blank',
'escape' => false
]); ?>

<?= $this->Html->link('<i class="fab fa-twitter"></i>', 'https://x.com/DrogueriaSur/', [
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
<li><?php echo $this->Html->link('Eventos', ['controller' => 'eventos', 'action' => 'index']); ?></li>
<li><?php echo $this->Html->link('Contáctanos', 'mailto:contacto@drogueriasur.com.ar'); ?></li>
<li><?php echo $this->Html->link('Reclamos', ['controller' => 'tickets', 'action' => 'index']); ?></li>
<li><?php echo $this->Html->link('Home & Deco', ['controller' => 'HomeYDecos', 'action' => 'index']); ?></li>
<li><?php echo $this->Html->link('Últimas noticias', ['controller' => 'Novedades', 'action' => 'comunicado']); ?></li>
<li><?php echo $this->Html->link('Aplicación Movil', 'https://play.google.com/store/apps/details?id=com.nexosmart.drogueriasur', ['target' => '_blank']); ?></li>
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

<?php echo $this->Html->script('jquery.easing.1.3.min');
echo $this->Html->script('jquery-scrolltofixed.min');
echo $this->Html->css('jquery.notifyBar.min');
echo $this->Html->script('jquery.notifyBar.min');/*echo $this->Html->script('plugins.min');*/
echo $this->Html->script('main.min');
echo $this->Html->script('scriptbar.min');
echo $this->Html->script('modal'); ?>
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
//(function(d,e,j,h,f,c,b){d.GoogleAnalyticsObject=f;d[f]=d[f]||function(){(d[f].q=d[f].q||[]).push(arguments)},d[f].l=1*new Date();c=e.createElement(j),b=e.getElementsByTagName(j)[0];c.async=1;c.src=h;b.parentNode.insertBefore(c,b)})

//(window,document,"script","https://www.google-analytics.com/analytics.js","ga");

//ga("create","UA-54312928-1","auto"); ga('require', 'GTM-W56XFP5');ga("send","pageview");
</script>
<style>
.stars {
opacity: 60%;
position: fixed;
top: 0;
left: 0;
z-index: 5;
width: 120%;
height: 100%;
pointer-events: none;
}

.star {
position: absolute;
color: transparent;
text-shadow: -1px -1px 0 rgb(255, 224, 67), 1px -1px 0 rgba(240, 191, 61, 0.596), -1px 1px 0 rgba(248, 191, 35, 0.596), 1px 1px 0 rgba(255, 242, 109, 0.596);
animation: fall linear infinite;
}
</style>

<script>
/*
const starsContainer = document.querySelector('.stars');
const starCount = 50;
const starIcons = ['fa-star'];

for (let i = 0; i < starCount; i++) {
const star = document.createElement('i');
star.classList.add('star', 'fas', starIcons[Math.floor(Math.random() * starIcons.length)]);
star.style.left = `${Math.random() * 100}%`;
star.style.animationDuration = `${Math.random() * 10 + 10}s`;
star.style.animationDelay = `-${Math.random() * 10}s`;

const opacity = Math.random() * 0.3 + 0.1;
star.style.textShadow = `
-1px -1px 0 rgba(255, 224, 67, ${opacity}),
1px -1px 0 rgba(240, 191, 61, ${opacity}),
-1px 1px 0 rgba(248, 191, 35, ${opacity}),
1px 1px 0 rgba(255, 242, 109, ${opacity})
`;
star.style.fontSize = `${Math.random() * 20 + 10}px`;

starsContainer.appendChild(star);


setTimeout(() => {
star.style.opacity = '0';
star.style.transition = 'opacity 1s ease'; 
setTimeout(() => star.remove(), 1000); 
}, 7000); 


}*/
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-54312928-1"></script>
<script>
/*
document.addEventListener('DOMContentLoaded', function() {
Marquee3k.init();
//console.log(Marquee3k.t);
}); */
window.dataLayer = window.dataLayer || [];

function gtag() {
dataLayer.push(arguments);
}
gtag('js', new Date());
gtag('config', 'UA-54312928-1');
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2WQX5TKEVP"></script>
<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
dataLayer.push(arguments);
}
gtag('js', new Date());

gtag('config', 'G-2WQX5TKEVP');
</script>

</body>

</html>