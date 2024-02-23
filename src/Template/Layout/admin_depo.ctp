<!doctype html>
<html lang=en>
<head>
<meta name=viewport content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta charset="utf-8"/>
<title>Control Panel DS3</title>
<?php 
echo $this->Html->meta('favicon.ico','/favicon.ico', ['type' => 'icon']);
echo $this->fetch('meta'); ?>
<!--[if lt IE 9]>
<?php echo $this->Html->css('adminie.min',['media'=>'screen']); ?>	
<?php echo $this->Html->script('html15.min'); ?>
<![endif]-->
<?php 
echo $this->Html->css('admin_depo');
echo $this->Html->css('jquery-ui'); 
//echo $this->Html->script('jquery-1.11.3'); 
//echo $this->Html->script('bootstrap5/bootstrap'); 
echo $this->Html->css('bootstrap.min');
echo $this->Html->script('jquery.min');
echo $this->Html->css('jquery-ui');
echo $this->Html->script('bootstrap');
echo $this->Html->script('jquery-ui');
echo $this->Html->css('normalize.min');
echo $this->Html->css('font-awesome');/*echo $this->Html->css('animate');*/
echo $this->Html->css('alertify/alertify');
echo $this->Html->script('alertify/alertify');
echo $this->Html->script('jquery-ui-1.10.4.custom.min'); 	
echo $this->Html->script('jquery.tablesorter.min',['plugin' => false]); 
echo $this->Html->script('jquery.equalHeight.min',['plugin' => false]); 
echo $this->Html->css('jquery.notifyBar.min');
echo $this->Html->script('jquery.notifyBar.min');
//echo $this->Html->css('bootstrap5/bootstrap.min'); ?>
<script type=text/javascript>$(document).ready(function(){$(".tab_content").hide(),$("ul.tabs li:first").addClass("active").show(),$(".tab_content:first").show(),$("ul.tabs li").click(function(){$("ul.tabs li").removeClass("active"),$(this).addClass("active"),$(".tab_content").hide();var e=$(this).find("a").attr("href");return $(e).fadeIn(),!1})}),$(function(){$("#creado,#fechahasta, #fechadesde, #fecha_desde,#fecha_hasta, #fecha_recepcion, #form_reclamo_fv1,#form_reclamo_fv2,#form_reclamo_fv3,#form_reclamo_fv4").datepicker({dateFormat:"dd/mm/yy",dayNames:["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"],dayNamesMin:["Do","Lu","Ma","Mi","Ju","Vi","Sa"],firstDay:1,gotoCurrent:!0,monthNames:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Deciembre"]}),$(".main-menu ul.menu li a").click(function(){$(this).addClass("active")})}),$(function(){var e=document.getElementById("flashmensajesuccess");null!=e&&""!=e.innerHTML&&$.notifyBar({cssClass:"success",html:e.innerHTML,position:"bottom"});e=document.getElementById("flashmensajeerror");null!=e&&""!=e.innerHTML&&$.notifyBar({cssClass:"error",html:e.innerHTML,close:!0,closeOnClick:!1});e=document.getElementById("flashmensajewarning");null!=e&&""!=e.innerHTML&&$.notifyBar({cssClass:"warning",html:e.innerHTML})});</script>
</head>
<body>
<section id=secondary_bar>
<div class=section_logo>
<?php echo $this->Html->image('logods.png',['alt'=>'Drogueria Sur S.A.','id'=>'logo_web','url'=>['controller'=>'Depositos','action'=>'index']]);?>
</div>    
<div class=section_title>Control Panel Deposito</div>
<div class=section_icon>
<ul class=menu>
<li style='float: right;  height:45px; margin:0 10px 0 10px;'> <?php echo $this->Html->image('deposit/icon_salir.png', ['url'=>['controller' => 'Users', 'action' => 'logout']],['alt' => 'Cerrar Sesión','class'=>'codrops-icon codrops-icon-back']);?></li>
<li style='float: right;  height:45px; margin:0 10px 0 10px;'> <?php echo $this->Html->image('deposit/icon_clima.png', ['url'=>['controller'=>'Climas','action'=>'index']],['alt' => 'Ver Evento']);?></li>
<li style="float: right;  height:45px; margin:0 10px 0 10px;"> <?php echo $this->Html->image('deposit/icon_busqueda.png', ['url'=>['controller' => 'Articulos', 'action' => 'search_articulos']], ['alt' => 'Comunidad Sur']);?></li>
</ul>
</div>
</section>

<section id=main class=column     style =" width: 99%; text-align: center;">
<div id=content>
<div id=mensaje style=display:none>
<?= $this->Flash->render('changepass'); ?>
</div>
<div class=row style="margin: 0px;"> 
<?= $this->fetch('content') ?>
</div>
</div>
</section>
</body>
</html>