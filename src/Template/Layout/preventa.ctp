<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title>EXPO SUR 08/11/2019</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="Drogueria Sur" />
<?php	
echo $this->fetch('meta');
echo $this->Html->meta(  'favicon.ico','/favicon.ico', ['type' => 'icon']);
echo $this->Html->css('jquery-ui'); 
//echo $this->Html->script('jquery-ui-1.10.4.custom.min'); 
echo $this->Html->css('pv/normalize');
echo $this->Html->css('pv/component'); 
echo $this->Html->css('pv/exposur'); 
//echo $this->Html->script('modernizr-2.6.2.min');	
//echo $this->Html->css('normalize.min');
echo $this->Html->css('templatemo-style.min'); 
echo $this->Html->css('bootstrap'); 
?>
</head>
<body>
<div class="container" style="position: absolute;  top: 0px; z-index: 100;">						
<ul id="gn-menu" class="gn-menu-main">
<li class="gn-trigger">
<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
<nav class="gn-menu-wrapper">
<div class="gn-scroller">
<ul class="gn-menu">
<li>
<a class="gn-icon gn-icon-archive">Transfer</a>
<ul class="gn-submenu">
<li><?= $this->Html->link(__('Nuevo'), ['controller' => 'Transfers', 'action' => 'add'],['class'=>'gn-icon gn-icon-article']) ?></li>
<li><?= $this->Html->link(__('Realizados'), ['controller' => 'Transfers', 'action' => 'realizados'],['class'=>'gn-icon gn-icon-article']) ?></li>
</ul>
</li>
<li>
<a class="gn-icon gn-icon-download">Informes</a>
<ul class="gn-submenu">
<li><?= $this->Html->link(__('Excel Detalle'), ['controller' => 'Transfers', 'action' => 'exceldetalle'],['class'=>'gn-icon gn-icon-article']) ?></li>
<li><?= $this->Html->link(__('Excel Resumen'), ['controller' => 'Transfers', 'action' => 'excelresumen'],['class'=>'gn-icon gn-icon-article']) ?></li>
<!-- li><a class="gn-icon gn-icon-illustrator">En Excel</a></li -->
<!--li><a class="gn-icon gn-icon-photoshop">En pdf</a></li -->
</ul>
</li>
<!-- li>
<a class="gn-icon gn-icon-archive">Transfer</a>
<ul class="gn-submenu">
<li><?= $this->Html->link(__('Importar'), ['controller' => 'Transfers', 'action' => 'import'],['class'=>'gn-icon gn-icon-article']) ?></li>
<li><?= $this->Html->link(__('Modificar'), ['controller' => 'Transfers', 'action' => 'modificar'],['class'=>'gn-icon gn-icon-article']) ?></li>
</ul>
</li -->
<li><?= $this->Html->link(__('Configuración'), ['controller' => 'Transfers', 'action' => 'change_password'],['class'=>'gn-icon gn-icon-cog']) ?></li>

</ul>
</div><!-- /gn-scroller -->
</nav>
</li>
<li>
<?php echo $this->Html->image('exposur.png', ['alt' => 'Drogueria Sur S.A.','url'=>['controller'=>'Transfers','action'=>'index']]);?></li>
<li><a class="codrops-icon codrops-icon-prev" href=""><span>Previous</span></a></li>
<li><?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'logout'],['class'=>'codrops-icon codrops-icon-back']) ?></li>
</ul>
</div>
<div class="content-section" style="position: relative;  top: 60px; z-index: 1;">
<div class="container">
<div class="row" >
<div id="mensaje" style="display:none;">
<?= $this->Flash->render('changepass'); ?>
</div>
<?= $this->fetch('content') ?>
</div> <!-- /.row -->
</div> <!-- /.container -->
</div> <!-- /.content-section -->
<?php 
echo $this->Html->script('jquery'); 
echo $this->Html->script('pv/classie');	
echo $this->Html->script('pv/gnmenu');	
echo $this->Html->script('jquery.quick.pagination.min');
echo $this->Html->script('jquery.easing.1.3');echo $this->Html->script('jquery-scrolltofixed');echo $this->Html->css('jquery.notifyBar.min');echo $this->Html->script('jquery.notifyBar.min');echo $this->Html->script('bootstrap');
?>
<script>
new gnMenu( document.getElementById( 'gn-menu' ) );
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