<!doctype html>
<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?php //echo $this->Html->charset() ?>
   	<meta charset="utf-8"/>
	<title>Admin Drogueria Sur</title>
	<?php echo $this->Html->meta('icon'); ?>
    <?php echo $this->fetch('meta') ?>
    <link rel="icon" href="favicon.ico" type="image/png">
	<!--[if lt IE 9]>
	<?php echo $this->Html->css('adminie',['media'=>'screen']); ?>	
	<?php echo $this->Html->script('html15'); ?>
	<![endif]-->
			<?php echo $this->Html->css('admin'); 	
			//echo $this->Html->script('hideshow',['plugin' => false]); 	
			echo $this->Html->css('jquery-ui'); 
			echo $this->Html->script('jquery-1.11.3'); 
			echo $this->Html->script('jquery-ui-1.10.4.custom.min'); 	
			echo $this->Html->script('jquery.tablesorter.min',['plugin' => false]); 
			echo $this->Html->script('jquery.equalHeight',['plugin' => false]); ?>
	
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
					$("#fechahasta, #fechadesde, #fecha_recepcion, #form_reclamo_fv1,#form_reclamo_fv2,#form_reclamo_fv3,#form_reclamo_fv4").datepicker(
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
			
  </script>

</head>

<body>
<!-- 
	<header id="header">
		<hgroup>
		<div class="logo">
			<?php //echo $this->Html->image('logo_admin.png',['alt' => 'Website Administrador','id'=>'logo']); ?>
			</div>
			<h2 class="section_title">Tablero de Control DS</h2>
			<div class="btn_view_site">	<?php // $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'logout']) ?></div>
		</hgroup>
	</header> end of header bar -->
	
<section id="secondary_bar">
			
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><?= $this->Html->link(__('Pedidos'), ['controller' => 'Pedidos', 'action' => 'index_admin']) ?>  <div class="breadcrumb_divider"></div> <?= $this->Html->link(__('Ver Panel completo'), ['controller' => 'Users', 'action' => 'index']) ?></article>
		</div>
		<div class="section_title">
		Tablero de Control DS
		</div>
		<div class="btn_view_site">	<?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'logout']) ?></div>

		
	</section><!-- end of secondary bar -->
	

	
	<section id="main" class="column">
		<div id="content">
            <!--h4><?php // $this->Flash->render() ?></h4-->

            <div class="row">
                <?= $this->fetch('content') ?>
            </div>
        </div>

	</section>


</body>

</html>