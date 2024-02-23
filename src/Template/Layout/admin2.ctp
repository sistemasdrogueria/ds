<!doctype html>
<html lang=es-ES>
<head>
<meta name=viewport content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta charset="utf-8"/>
<title>Admin Drogueria Sur</title>
<?php echo $this->Html->meta('icon');
echo $this->Html->meta('favicon.ico','/favicon.ico', ['type' => 'icon']);
echo $this->fetch('meta'); ?>
<!--[if lt IE 9]>
<?php echo $this->Html->css('adminie',['media'=>'screen']); ?>
<?php echo $this->Html->script('html15'); ?>
<![endif]-->
<?php 
echo $this->Html->css('admin'); 	
echo $this->Html->css('jquery-ui'); 
echo $this->Html->script('jquery-1.11.3'); 
echo $this->Html->css('alertify/alertify');
echo $this->Html->script('alertify/alertify');
echo $this->Html->script('jquery-ui-1.10.4.custom.min'); 	
echo $this->Html->script('jquery.tablesorter.min',['plugin' => false]); 
echo $this->Html->script('jquery.equalHeight.min',['plugin' => false]); 
echo $this->Html->css('jquery.notifyBar.min');
echo $this->Html->script('jquery.notifyBar.min');
?>
<script type=text/javascript>$(document).ready(function(){$(".tab_content").hide();$("ul.tabs li:first").addClass("active").show();$(".tab_content:first").show();$("ul.tabs li").click(function(){$("ul.tabs li").removeClass("active");$(this).addClass("active");$(".tab_content").hide();var a=$(this).find("a").attr("href");$(a).fadeIn();return false})});$(function(){$("#fechahasta, #fechadesde, #fecha_recepcion, #form_reclamo_fv1,#form_reclamo_fv2,#form_reclamo_fv3,#form_reclamo_fv4").datepicker({dateFormat:"dd/mm/yy",dayNames:["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"],dayNamesMin:["Do","Lu","Ma","Mi","Ju","Vi","Sa"],firstDay:1,gotoCurrent:true,monthNames:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Deciembre"]});$(".main-menu ul.menu li a").click(function(){$(this).addClass("active")})});</script>
</head>
<body>
<section id=secondary_bar>
<div class=breadcrumbs_container>
<article class=breadcrumbs><?= $this->Html->link(__('Pedidos'), ['controller' => 'Pedidos', 'action' => 'index_admin']) ?> <div class=breadcrumb_divider></div> <?= $this->Html->link(__('Menu Completo'), ['controller' => 'Users', 'action' => 'index']) ?></article>
</div>
<div class=section_title>Control Panel DS</div>
<div class=btn_view_site> <?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'logout']) ?></div>
</section>
<section id=main class=column>
<div id=content>
<div id=mensaje style=display:none>
<?= $this->Flash->render('changepass'); ?>
</div>
<div class=row>
<?= $this->fetch('content') ?>
</div>
</div>
</section>
</body>
</html>