<!--DOCTYPE html -->
<?php echo $this->Html->docType('html5');?>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class=no-js> <!--<![endif]-->
<head>
<meta name=viewport content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<title>DROGUERIA SUR</title>
<meta charset=utf-8>
<meta name=description content>
<?php echo $this->fetch('meta');echo $this->Html->meta('favicon.ico','/favicon.ico',['type'=>'icon']);

echo $this->Html->css('jquery-ui.min');echo $this->Html->script('jquery-1.11.3.min');

//echo $this->Html->script('jquery.min');
//echo $this->Html->css('jquery-ui');
//echo $this->Html->script('jquery-ui');
echo $this->Html->css('bootstrap');
echo $this->Html->css('normalize.min');
echo $this->Html->css('font-awesome');/*echo $this->Html->css('animate');*/
echo $this->Html->css('templatemo-misc');echo $this->Html->css('templatemo-style2.min');
echo $this->Html->css('stylebar2.min');/*echo $this->Html->script('modernizr-2.6.2');echo $this->Html->script('jquery.quick.pagination');*/?>
<script>$(function(){$("#fechahasta, #fechadesde, #fecha_recepcion").datepicker({dateFormat:"dd/mm/yy",dayNames:["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"],dayNamesMin:["Do","Lu","Ma","Mi","Ju","Vi","Sa"],firstDay:1,gotoCurrent:true,monthNames:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Deciembre"]});$(".main-menu ul.menu li a").click(function(){$(this).addClass("active")})});</script>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel=stylesheet>
</head>
<body>
<!--[if lt IE 7]>
<p class=chromeframe>You are using an <strong>outdated</strong> browser. Please <a href=http://browsehappy.com/>upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->




<header class=site-header>





<div class=main-header>
<div class=container>
<div class=row>
<?php echo $this->element('header'); ?>
<!-- div class="col-md-3 col-sm-3 col-xs-3">
<div class=logods>
<?php echo $this->Html->image('logods.png',['alt'=>'Drogueria Sur S.A.','id'=>'logo_web','url'=>['controller'=>'Carritos','action'=>'index']]);?>
</div>
</div>
<div class="col-md-4 col-sm-3 col-xs-3">
<div class=logods align=right>
<?php echo $this->Html->image('CORONAVIRUS-BANNER.gif',['alt'=>'Drogueria Sur S.A.','url'=>['controller'=>'Carritos','action'=>'index']]);?>

</div>
</div>
<div class="col-md-5 col-sm-9 col-xs-9">
<div class=main-menu>
<ul class=menu>
<li><div class=clientname><?php echo $this->request->session()->read('Auth.User.codigo')?></div></li>
<li><?=$this->Html->link(__('Inicio'),['controller'=>'Carritos','action'=>'index'])?></li>
<li><?=$this->Html->link(__('Mi Cuenta'),['controller'=>'Clientes','action'=>'view'])?></li>
<?php if ($this->request->session()->read('Auth.User.comunidadsur')>0)	echo '<li>'.
$this->Html->image('comunidadsur.png', ['alt' => 'Comunidad Sur','url'=>'http://www.drogueriasur.com.ar/cs'])
.'</li>';?>
<li><?=$this->Html->link(__('Salir'),['controller'=>'Users','action'=>'logout'])?></li>
</ul>
</div>
</div -->
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
<?=$this->Html->link(__('Compras'),['controller'=>'Carritos','action'=>'index'])?>
<ul>
<li><?=$this->Html->link(__('Importar Archivos'),['controller'=>'Carritos','action'=>'import'])?></li>
<li><?=$this->Html->link(__('Pañales PAMI'),['controller'=>'Carritos','action'=>'pami'])?></li>
<li><?=$this->Html->link(__('Insumos'),['controller'=>'Carritos','action'=>'insumos'])?></li>
<li><?=$this->Html->link(__('Realizados'),['controller'=>'Pedidos','action'=>'index'])?></li>
<li><?=$this->Html->link(__('Historico'),['controller'=>'Pedidos','action'=>'searchproduct'])?></li>
<li><?=$this->Html->link(__('Faltas de la Semana'),['controller'=>'Pedidos','action'=>'faltas'])?></li>
<li><?=$this->Html->link(__('Productos Nuevos'),['controller'=>'Articulos','action'=>'nuevos'])?></li>
</ul>
</li>
<li class='active has-sub'>
<?=$this->Html->link(__('Cta. Cte'),['controller'=>'CtacteEstados','action'=>'index'])?>
<ul>
<li><?=$this->Html->link(__('Estado Actual'),['controller'=>'CtacteEstados','action'=>'index'])?></li>
<li><?=$this->Html->link(__('Compra Semanal'),['controller'=>'CtacteComprasSemanales','action'=>'index'])?></li>
<li><?=$this->Html->link(__('Resumen Semanal'),['controller'=>'CtacteResumenSemanales','action'=>'index'])?></li>
<li><?=$this->Html->link(__('Resumen Cuentas a Pagar'), ['controller' => 'CtacteResumenCuentas', 'action' => 'index']) ?></li>
<li><?=$this->Html->link(__('Detalle de Factura'),['controller'=>'Facturas','action'=>'index'])?></li>
<li><?=$this->Html->link(__('Transfer'),['controller'=>'Facturas','action'=>'transfer'])?></li>
<li><?=$this->Html->link(__('Pagos'),['controller'=>'CtactePagos','action'=>'index'])?></li>
<li><?=$this->Html->link(__('Comprobantes'),['controller'=>'Comprobantes','action'=>'index'])?></li>
<li><?=$this->Html->link(__('Facturas PAMI'), ['controller' => 'Facturas', 'action' => 'pami']) ?></li>
<li><?=$this->Html->link(__('Banco Info'), ['controller' => 'CtactePagos', 'action' => 'info']) ?></li>
</ul>
</li>
<li class='active has-sub'>
<?= $this->Html->link(__('Transfers'), ['controller' => 'PatagoniaMed', 'action' => 'index']) ?>
<ul>
<li><?=$this->Html->link(__('Consolidados'),['controller'=>'PatagoniaMed','action'=>'index'])?></li>
<li><?=$this->Html->link(__('Descargar'),['controller'=>'PatagoniaMed','action'=>'consolidado'])?></li>
</ul>
</li>
<li class='active has-sub'>
<?=$this->Html->link(__('Perfumeria'),['controller'=>'DeliaPerfumerias','action'=>'index'])?>
<ul>
<li><?=$this->Html->link(__('Oferta Venc.Cercano'),['controller'=>'Carritos','action'=>'ofertavc'])?></li>
<?php if(!empty($sursale))echo '<li>'.$this->Html->link(__('Sur Sale'),['controller'=>'Carritos','action'=>'sale']).'</li>';?>
<li><?=$this->Html->link(__('Incorporaciones'),['controller'=>'Novedades','action'=>'perfumeria'])?></li>
<li><?=$this->Html->link(__('Frag. Selectivas'),['controller'=>'DeliaPerfumerias','action'=>'fragancia'])?></li>
<!--li><?=$this->Html->link(__('Día del Padre'),['controller'=>'Catalogos','action'=>'especial'])?></li-->
<!--li><?=$this->Html->link(__('Fiesta 17/18'),['controller'=>'Catalogos','action'=>'especial'])?></li-->
<!--li><?= $this->Html->link(__('Navidad y Reyes 17/18'), ['controller' => 'Catalogos', 'action' => 'especial2']) ?></li -->
</ul>
<li class='active has-sub'>
<?=$this->Html->link(__('Nutrición'),['controller'=>'NutricionYDeportes','action'=>'index'])?>
</li>
<li class='active has-sub'>
<?=$this->Html->link(__('Ortopedia'),['controller'=>'Ortopedias','action'=>'index'])?>
</li>
<?php //if(!empty($sursale))echo '<li>'.$this->Html->link(__('Sur Sale'),['controller'=>'Carritos','action'=>'sale']).'</li>';?>
<li class='active has-sub' id=novedades>
<?=$this->Html->link(__('Novedades'),['controller'=>'Novedades','action'=>'comunicado'])?>
<?php if($this->request->session()->read('notificacion')>0){echo "<div id='novedades_ico'><div>";echo "<div id='novedades_text'>".$this->request->session()->read('notificacion')."</div>";}?>
<ul>
<li><?=$this->Html->link(__('Descargas'),['controller'=>'Descargas','action'=>'archivo'])?></li>
<li><?=$this->Html->link(__('Noticias'),['controller'=>'Novedades','action'=>'comunicado'])?></li>
<li><?=$this->Html->link(__('Expo Sur'),['controller'=>'Novedades','action'=>'exposur'])?></li>
<li><?= $this->Html->link(__('Revista'), ['controller' => 'Catalogos', 'action' => 'revista']) ?></li>
</ul>
</li>
<li class='active has-sub'>
<?=$this->Html->link(__('Devol/Reclamos'),['controller'=>'Tickets','action'=>'index'])?>
<ul>
<li><?=$this->Html->link(__('Cargar'),['controller'=>'Tickets','action'=>'add'])?></li>
<li><?=$this->Html->link(__('Realizados'),['controller'=>'Tickets','action'=>'index'])?></li>
</ul>
</li>
<li class='active has-sub'>
<?=$this->Html->link(__('Catalogos'),['controller'=>'Catalogos','action'=>'revista'])?>
<ul>
<!--li><?=$this->Html->link(__('Día de la Madre'),['controller'=>'Catalogos','action'=>'especial'])?></li -->
<!-- li><?=$this->Html->link(__('Fiestas 2018-19'),['controller'=>'Catalogos','action'=>'especial2'])?></li -->
<!--li><?=$this->Html->link(__('Solares'),['controller'=>'Catalogos','action'=>'especial'])?></li-->
<li><?=$this->Html->link(__('Rev. Mayo'),['controller'=>'Catalogos','action'=>'revista'])?></li>
</ul>
</li>
<?php if ($this->request->session()->read('Auth.User.farmapoint')==1) 
echo '<li>'.$this->Html->link(__('Farma Point'), ['controller' => 'Carritos', 'action' => 'farmapoint']).'</li>';?>
<!--li class='promoespecial'> <?php echo $this->Html->image('promoespecial.png', ['alt' => 'Día del Niño!!','url'=>['controller' => 'Catalogos', 'action' => 'especial']]);?></li -->
<!--li><?= $this->Html->link(__('Navidad y Reyes 17/18'), ['controller' => 'Catalogos', 'action' => 'especial']) ?></li-->
<!--li><?= $this->Html->link(__('Día de la Madrer'), ['controller' => 'Catalogos', 'action' => 'especial']) ?></li -->
<li><?=$this->Html->link(__('Eventos'),['controller'=>'Novedades','action'=>'exposur'])?></li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
</header>
<div class=content-section>
<div class=container>
<div class=row>
<div id=mensaje style=display:none>
<?=$this->Flash->render('changepass');?>
</div>
<?=$this->fetch('content')?>
</div>
</div>
</div>
<div class=content-section>
<div class=container>
<?php //if($this->request->session()->read('ofertaspatagonias')!=null){echo $this->element('ofertapatagonia');}?></div </div>
</div>
<footer class=site-footer>
<div class=bottom-footer>
<div class=container>
<div class=row>
<div class="col-md-12 text-center">
<span>Droguería Sur SA © <?php echo date("o");?> . Villarino 46/58 (B8000JIB) - Bahía Blanca - Buenos Aires </span>
</div>
</div>
</div>
</div>
</footer>
<?php echo $this->Html->css('jquery.notifyBar.min');echo $this->Html->script('jquery.notifyBar.min');echo $this->Html->script('bootstrap');
 echo $this->Html->script('scriptbar');?>
<script> //$(document).ready(main);
var contador = 0;
/*
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
}*/
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