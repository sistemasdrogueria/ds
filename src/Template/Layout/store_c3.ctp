<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<title>Drogueria Sur</title>
<meta charset="utf-8">
<meta name="description" content="">
<?php	echo $this->fetch('meta');
echo $this->Html->meta(  'favicon.ico','/favicon.ico', ['type' => 'icon']);
echo $this->Html->css('jquery-ui'); 
echo $this->Html->script('jquery-1.11.3'); 
echo $this->Html->css('nanogallery2'); 
echo $this->Html->script('jquery'); 
echo $this->Html->script('jquery.nanogallery2');
echo $this->Html->css('jquery-ui');
echo $this->Html->script('jquery-ui-1.10.4.custom.min'); 
echo $this->Html->css('bootstrap'); 
echo $this->Html->css('normalize.min'); 
echo $this->Html->css('font-awesome.min'); 
echo $this->Html->css('animate');
echo $this->Html->css('templatemo-misc');
echo $this->Html->css('templatemo-style.min'); 
echo $this->Html->script('modernizr-2.6.2.min');	
echo $this->Html->script('jquery.quick.pagination.min');
?>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet">
</head>
<body id="body_container">
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<header class="site-header">
<div class="main-header">
<div class="container">
<div class="row">

<div class="col-md-4 col-sm-3 col-xs-3">
<div class="logo">
<?php echo $this->Html->image('logo2.png', ['alt' => 'Drogueria Sur S.A.','url'=>['controller'=>'Carritos','action'=>'index']]);?>
</div> <!-- /.logo -->
</div> <!-- /.col-md-4 -->
<div class="col-md-8 col-sm-9 col-xs-9">
<div class="main-menu">
<!-- a href="#" class="toggle-menu">
<i class="fa fa-bars"></i>
</a -->
<ul class="menu">
<li><?= $this->Html->link(__('VOLVER'), ['controller' => 'Carritos', 'action' => 'index']) ?></li>
<li style='float: right;  height:40px; margin:0 5px 0 5px;'> <?php echo $this->Html->image('icono_salir.png', ['url'=>['controller' => 'Carritos', 'action' => 'index']],['alt' => 'Cerrar Sesión','class'=>'codrops-icon codrops-icon-back']);?></li>
<li style='float: right;  height:40px; margin:0 5px 0 5px;'> <?php echo $this->Html->image('icono_configurar.png', ['url'=>['controller'=>'Clientes','action'=>'view']],['alt' => 'Ver Evento']);?></li>
<li style="float: right;  height:40px; margin:0 5px 0 5px;"> <?php echo $this->Html->image('logo_cs.png', ['url'=>['controller' => 'ComunidadSur', 'action' => 'index']], ['alt' => 'Comunidad Sur']);?></li>


</ul>
</div> <!-- /.main-menu -->
</div> <!-- /.col-md-8 -->
</div> <!-- /.row -->
</div> <!-- /.container -->
</div> <!-- /.main-header -->

</header> <!-- /.site-header -->
<div class="content-section">
<div class="container">
<div class="row">
<div id="mensaje" style="display:none;">
<?= $this->Flash->render('changepass'); ?>
</div>
<?= $this->fetch('content') ?>
</div> <!-- /.row -->
</div> <!-- /.container -->
</div> <!-- /.content-section -->

<footer class="site-footer">
<div class="bottom-footer">
<div class="container">
<div class="row">
<div class="col-md-12 text-center">
<span>Droguería Sur SA © <?php echo date("o"); ?>  . Villarino 46/58 (B8000JIB) - Bahía Blanca - Buenos Aires </span> 
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
</div> <!-- /.container -->
</div> <!-- /.bottom-footer -->
</footer> <!-- /.site-footer -->
<!--div id="dialog-message">
<?php //if (!is_null($sursale))
//echo $this->Html->image('sursale/'.$sursale['imagen'], ['url'=>['controller'=>'Carritos','action'=>'sale'],'alt' => 'Drogueria Sur S.A.','width'=>'90%']);?>	 
</div-->
<!--div id="dialog-message2">
<?php //if (!is_null($noticiaimportante)) {?>
<div>
<?php //foreach ($novedades as $novedade): ?>
<div class="member wow bounceInUp animated">
<div class="member-container" data-wow-delay=".1s">
<div class="inner-container">

<div class="member-details">
<div class="member-top">	
<h6>Bahia Blanca 
<?php 
//echo ', '.date_format($novedade['fecha'],'d-m-Y');
?></h6>									
<h4 class="name" style=" color: #C00; ">
<?php //h($novedade->titulo) ?>
</h4>
<span class="designation">
<?php //h($novedade->tipo) ?>
</span>
</div><!-- /.member-top -->

<p class="texto">
<?php // $this->Text->autoParagraph(h($novedade->descripcion)); ?>
</p>
<p class="texto">
<?php // $this->Text->autoParagraph(h($novedade->descripcion_completa)); ?>
</p>
</div><!-- /.member-details -->
</div><!-- /.inner-container -->
</div><!-- /.member-container -->
</div><!-- /.member -->
<?php //endforeach; ?>
<!--/div>
<?php //}?>
</div -->
<?php
//<script> window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')</script>
echo $this->Html->script('jquery.easing.1.3');
echo $this->Html->script('jquery-scrolltofixed');
echo $this->Html->css('jquery.notifyBar');
echo $this->Html->script('jquery.notifyBar');
echo $this->Html->script('bootstrap');
echo $this->Html->script('plugins');

?>
<script> 


$(function() {
var UI=document.getElementById('flashmensajesuccess');
if (UI != null)
{
if (UI.innerHTML != '')
{
$.notifyBar({ cssClass: "success", html: UI.innerHTML ,position: "bottom"});
}
}
var UI2=document.getElementById('flashmensajeerror');
if (UI2 != null)
{
if (UI2.innerHTML != '')
{
$.notifyBar({ cssClass: "error", html: UI2.innerHTML, close: true, closeOnClick: false });
}
}
var UI3=document.getElementById('flashmensajewarning');
if (UI3 != null)
{
if (UI3.innerHTML != '')
{
$.notifyBar({ cssClass: "warning", html: UI3.innerHTML });
}
}   
});

</script>
</body>
</html>