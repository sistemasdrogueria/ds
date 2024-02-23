<!doctype html>
<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?php //echo $this->Html->charset() ?>
   	<meta charset="utf-8"/>
	<title>Admin Drogueria Sur</title>
	<?php echo $this->Html->meta('icon'); ?>
    <?php echo $this->fetch('meta') ?>
	
	<?php echo $this->Html->meta('favicon.ico','/favicon.ico',['type'=>'icon']);?>
	<!--[if lt IE 9]>
	<?php echo $this->Html->css('adminie',['media'=>'screen']); ?>	
	<?php echo $this->Html->script('html15'); ?>
	<![endif]-->
	<?php 
			echo $this->Html->css('jquery-ui'); 
			echo $this->Html->script('jquery-1.11.3'); 
			echo $this->Html->script('bootstrap'); 
			echo $this->Html->script('jquery-ui-1.10.4.custom.min'); 	
			echo $this->Html->script('jquery.tablesorter.min',['plugin' => false]); 
			echo $this->Html->script('jquery.equalHeight',['plugin' => false]); 
			echo $this->Html->css('jquery.notifyBar');
			echo $this->Html->script('jquery.notifyBar');
			echo $this->Html->css('bootstrap.min');
			echo $this->Html->css('admin'); 	
	?>
	
	<script type="text/javascript">
	/*$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);*/
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
	});

				 $(function() {
					$("#creado,#fechahasta, #fechadesde, #fecha_desde,#fecha_hasta, #fecha_recepcion, #form_reclamo_fv1,#form_reclamo_fv2,#form_reclamo_fv3,#form_reclamo_fv4").datepicker(
						{
							dateFormat: "dd/mm/yy",
							dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
							dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
							firstDay: 1,
							gotoCurrent: true,
							monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre" ]
						}
					);
					$('.main-menu ul.menu li a').click(function() {
						
						$(this).addClass('active');
					});
				});
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

</head>

<body>

	
<section id="secondary_bar">
			
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><?= $this->Html->link(__('Pedidos'), ['controller' => 'Pedidos', 'action' => 'index_admin']) ?>  <div class="breadcrumb_divider"></div> <?= $this->Html->link(__('Ver Panel completo'), ['controller' => 'Users', 'action' => 'index']) ?></article>
		</div>
		<div class="section_title">
		Tablero de Control RRHH
		</div>
		<div class="btn_view_site">	<?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'logout']) ?></div>

	</section><!-- end of secondary bar -->
	
	<aside id="sidebar" class="column">
		<!--form class="quick_search">
			<input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
		</form >
		<hr/--> 
		<h3><?= $this->Html->link(__('RRHH'), ['controller' => 'jobs', 'action' => 'index_admin']) ?></h3>
		<ul class="toggle">
			<li class="icn_new"><?= $this->Html->link(__('Listado CV'), ['controller' => 'curriculums', 'action' => 'index_admin']) ?></li>
			<li class="icn_new"><?= $this->Html->link(__('Listado Vacante'), ['controller' => 'jobs', 'action' => 'index_admin']) ?></li>
			<li class="icn_new"><?= $this->Html->link(__('Nuevo Vacante'), ['controller' => 'jobs', 'action' => 'add_admin']) ?></li>
		</ul>
		
		<h3>Admin</h3>
		<ul class="toggle">
			<li class="icn_settings"><a href="#">Opciones</a><li>
			<li class="icn_jump_back">
			<?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'logout']); ?>
			</li>
			
		</ul>
		
		<footer>
			<hr />
			<p>Copyright © <?php echo date("o"); ?> Droguería Sur.</p>
		</footer>
	</aside><!-- end of sidebar -->
	
	<section id="main" class="column">
		<div id="content">
            <!--h4><?php // $this->Flash->render() ?></h4-->
			<div id="mensaje" style="display:none;">
				<?= $this->Flash->render('changepass'); ?>
				
			
			</div>
            <div class="row">
                <?= $this->fetch('content'); ?>
            </div>
        </div>

	</section>


</body>

</html>