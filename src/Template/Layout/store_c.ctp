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
	
			echo $this->Html->meta('favicon.ico','/favicon.ico', ['type' => 'icon']);
			echo $this->Html->css('jquery-ui'); 
			echo $this->Html->script('jquery-1.11.3'); 
			echo $this->Html->script('jquery-ui-1.10.4.custom.min'); 
			echo $this->Html->css('bootstrap'); 
			echo $this->Html->css('normalize.min'); 
			echo $this->Html->css('font-awesome.min'); 
			echo $this->Html->css('animate');
			echo $this->Html->css('templatemo-misc');
			echo $this->Html->css('templatemo-style'); 
			echo $this->Html->css('stylebar'); 
			echo $this->Html->script('modernizr-2.6.2.min');	
			echo $this->Html->script('jquery.quick.pagination.min');
	?>
	<script> 
    $(function() {
        $("#fechahasta, #fechadesde, #fecha_recepcion").datepicker(
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
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet">
</head>
<body>
    <!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
    <header class="site-header">
        <div class="main-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 col-xs-3">
                        <div class="logo">
                           <?php echo $this->Html->image('logo.png', ['alt' => 'Drogueria Sur S.A.','url'=>['controller'=>'Carritos','action'=>'index']]);?>
                        </div> <!-- /.logo -->
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-8 col-sm-9 col-xs-9">
                        <div class="main-menu">
                            <!-- a href="#" class="toggle-menu">
                                <i class="fa fa-bars"></i>
                            </a -->
                            <ul class="menu">
							    <li><div class='clientname'><?php echo $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');?></div></li>
                                <li><?= $this->Html->link(__('Inicio'), ['controller' => 'Carritos', 'action' => 'index']) ?></li>
                                <li><?= $this->Html->link(__('Mi Cuenta'), ['controller' => 'Clientes', 'action' => 'view']) ?></li>			
                                <!--li class='menu_ayuda'><?php // $this->Html->link(__('Ayuda'), ['controller' => 'Helps', 'action' => 'index']) ?></li -->
								<li><?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'logout']) ?></li>
                            </ul>
                        </div> <!-- /.main-menu -->
                    </div> <!-- /.col-md-8 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div> <!-- /.main-header -->
        <div class="main-nav">
			<div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="list-menu">			
						<div id='cssmenu'>
						<ul>
						   <li class='active has-sub'>
						   <?= $this->Html->link(__('Compras'), ['controller' => 'Carritos', 'action' => 'index']) ?>
							  <ul>
								<li><?= $this->Html->link(__('Importar Archivos'), ['controller' => 'Carritos', 'action' => 'import']) ?></li>
								<!--li><?= $this->Html->link(__('Realizar Pedidos'), ['controller' => 'Carritos', 'action' => 'index']) ?></li -->
								<li><?= $this->Html->link(__('Realizados'), ['controller' => 'Pedidos', 'action' => 'index']) ?></li>
								<li><?= $this->Html->link(__('Historico'), ['controller' => 'Pedidos', 'action' => 'searchproduct']) ?></li>
							    <li><?= $this->Html->link(__('Faltas de la Semana'), ['controller' => 'Pedidos', 'action' => 'faltas']) ?></li>
								<li><?= $this->Html->link(__('Productos Nuevos'), ['controller' => 'Articulos', 'action' => 'nuevos']) ?></li>
							  </ul>
						   </li>
						   <li class='active has-sub'>
						   <?= $this->Html->link(__('Cta. Cte'), ['controller' => 'CtacteEstados', 'action' => 'index']) ?>
							  <ul>
								<li><?= $this->Html->link(__('Estado Actual'), ['controller' => 'CtacteEstados', 'action' => 'index']) ?></li>
								<li><?= $this->Html->link(__('Compras Semanal'), ['controller' => 'CtacteComprasSemanales', 'action' => 'index']) ?></li>
								<li><?= $this->Html->link(__('Resumen Semanal'), ['controller' => 'CtacteResumenSemanales', 'action' => 'index']) ?></li>
								<li><?= $this->Html->link(__('Detalle de Factura'), ['controller' => 'Facturas', 'action' => 'index']) ?></li>
								<li><?= $this->Html->link(__('Pagos'), ['controller' => 'CtactePagos', 'action' => 'index']) ?></li>
							  </ul>
						   </li>
						   <li>
						   <?= $this->Html->link(__('Comprobantes'), ['controller' => 'Comprobantes', 'action' => 'index']) ?>
						   </li>
						   <!--li><?= $this->Html->link(__('Ofertas Perfumeria'), ['controller' => 'Ofertas', 'action' => 'perfumeria']) ?></li -->
						   
						   
						    <li class='active has-sub'>
							 <?= $this->Html->link(__('Perfumeria'), ['controller' => 'Carritos', 'action' => 'fraganciaselectiva']) ?>
							  <ul>
								<li><?= $this->Html->link(__('Sur Sale'), ['controller' => 'Carritos', 'action' => 'sale']) ?></li>
								<li><?= $this->Html->link(__('Incorporaciones'), ['controller' => 'Novedades', 'action' => 'perfumeria']) ?></li>
								<li><?= $this->Html->link(__('Frag. Selectivas'), ['controller' => 'Carritos', 'action' => 'fraganciaselectiva']) ?></li>
							  <li><?= $this->Html->link(__('Día del Padre'), ['controller' => 'Novedades', 'action' => 'promoespecial']) ?></li >
							  <!--i><?= $this->Html->link(__('Catálogo Solares'), ['controller' => 'Novedades', 'action' => 'promoespecial2']) ?></li-->
							 
							  </ul>
						   </li>
							<?php /*if (!empty($sursale))
						   echo '<li>'.$this->Html->link(__('Sur Sale'), ['controller' => 'Carritos', 'action' => 'sale']) .'</li>';*/?>						   
						  	<?php if (!empty($sursale2))
						   echo '<li>'.$this->Html->link(__('Hot Sale'), ['controller' => 'Carritos', 'action' => 'sale']) .'</li>';?>						   
						 
						   
						   <li class='active has-sub' id='novedades'>
						   <?= $this->Html->link(__('Novedades'), ['controller' => 'Novedades', 'action' => 'comunicado']) ?>
						   <?php if ($this->request->session()->read('notificacion')>0)
						   {
						   echo "<div id='novedades_ico'><div>";
						   echo "<div id='novedades_text'>".$this->request->session()->read('notificacion')."</div>";
						   }
						   ?>
						  
							  <ul>
								<!--li><?= $this->Html->link(__('Día de la Madre'), ['controller' => 'Novedades', 'action' => 'promoespecial']) ?></li--> 
								<li><?= $this->Html->link(__('Patagonia Med'), ['controller' => 'Novedades', 'action' => 'patagoniamed']) ?></li>
							    <li><?= $this->Html->link(__('Descargas'), ['controller' => 'Descargas', 'action' => 'archivo']) ?></li>
							    <li><?= $this->Html->link(__('Noticias'), ['controller' => 'Novedades', 'action' => 'comunicado']) ?></li>
								
								<li><?= $this->Html->link(__('Revista'), ['controller' => 'Descargas', 'action' => 'revista']) ?></li>
							  </ul>
						   </li>
						   <!-- li class='active has-sub'>
						   <?= $this->Html->link(__('Descargas'), ['controller' => 'Descargas', 'action' => 'archivo']) ?>
							  <ul>
							    <li><?= $this->Html->link(__('Archivos'), ['controller' => 'Descargas', 'action' => 'archivo']) ?></li>
								
								<li><?= $this->Html->link(__('Catalogos'), ['controller' => 'Descargas', 'action' => 'catalogo']) ?></li>
							  </ul>
						   </li -->
						   <li><?= $this->Html->link(__('Revista'), ['controller' => 'Descargas', 'action' => 'revista']) ?></li>
						  
						 <li class='active has-sub'>
						   <?= $this->Html->link(__('Devol/Reclamos'), ['controller' => 'Reclamos', 'action' => 'index']) ?>
							  <ul>
								<li><?= $this->Html->link(__('Cargar'), ['controller' => 'Reclamos', 'action' => 'add']) ?></li>
								<li><?= $this->Html->link(__('Realizados'), ['controller' => 'Reclamos', 'action' => 'index']) ?></li>
							  </ul>
						   </li>
							<!--li><?= $this->Html->link(__('Catálogo Solares'), ['controller' => 'Novedades', 'action' => 'promoespecial2']) ?></li -->						   
						   <li><?= $this->Html->link(__('Día del Padre'), ['controller' => 'Novedades', 'action' => 'promoespecial']) ?></li >
						   <!-- li class='promoespecial'> <?php //echo $this->Html->image('promoespecial.png', ['alt' => 'Día del Niño!!','url'=>['controller' => 'Novedades', 'action' => 'promoespecial']]);?></li -->
						</ul>
						</div>
                        </div> <!-- /.list-menu -->
                    </div> <!-- /.col-md-6 -->
                   
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div> <!-- /.main-nav -->
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
    <div class="content-section">
        <div class="container">
            <!-- div class="col-md-9">
                <div class="product-item-3">
                    <div class="product-thumb">
			
			<div class="row" -->
			<?php if ($this->request->session()->read('ofertaspatagonias')!= null) 
			{
				echo $this->element('ofertapatagonia'); 
			}	
			?></div <!-- /.row -->
					<!--/div>
				</div>
			</div--> 
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
	<div id="dialog-message">		
			<?php if (!is_null($sursale))
				echo $this->Html->image('sursale/'.$sursale['imagen'], ['url'=>['controller'=>'Carritos','action'=>'sale'],'alt' => 'Drogueria Sur S.A.','width'=>'90%']);?>	
	</div>
	<!-- div id="dialog-message2" >
		<?php /*if (!is_null($sursale2))
				echo $this->Html->image('sursale/'.$sursale2['imagen'], ['url'=>['controller'=>'Carritos','action'=>'sale'],'alt' => 'Drogueria Sur S.A.','width'=>'90%']);*/?>	

	</div -->
	<div id="dialog-message2" >
			<?php if (!is_null($noticiaimportante)) {?>
			<div>
			<?php foreach ($novedades as $novedade): ?>
					<div class="member wow bounceInUp animated">
								<div class="member-container" data-wow-delay=".1s">
									<div class="inner-container">

										<div class="member-details">
											<div class="member-top">	
												<h6>Bahia Blanca 
												<?php 
													echo ', '.date_format($novedade['fecha'],'d-m-Y');
												?></h6>									
												<h4 class="name" style=" color: #C00; ">
													<?= h($novedade->titulo) ?>
												</h4>
												<span class="designation">
													<?= h($novedade->tipo) ?>
												</span>
											</div><!-- /.member-top -->

											<p class="texto">
												<?= $this->Text->autoParagraph(h($novedade->descripcion)); ?>
												
											</p>
											<p class="texto">
												<?= $this->Text->autoParagraph(h($novedade->descripcion_completa)); ?>
												
											</p>
											
										</div><!-- /.member-details -->
									</div><!-- /.inner-container -->
								</div><!-- /.member-container -->
					</div><!-- /.member -->
			<?php endforeach; ?>

			</div>
			<?php }?>
		
	</div>
	
	
	<?php
	//<script> window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')</script>
		echo $this->Html->script('jquery.easing.1.3');
		echo $this->Html->script('jquery-scrolltofixed');
		echo $this->Html->css('jquery.notifyBar');
		echo $this->Html->script('jquery.notifyBar');
		echo $this->Html->script('bootstrap');
		echo $this->Html->script('plugins');
		echo $this->Html->script('main'); 
		echo $this->Html->script('scriptbar');
	?>
	<script> 
		$(document).ready(main);
		var contador = 0;
		function main(){
			$('.menu_bar').click(function(){
				if(contador == 0){
					$('nav').animate({ left: '-110%' });
					contador = 1;
				} else {
					contador = 0;
					$('nav').animate({	left: '0'});
				}
			});
		};
		$(document).ready(function() {
				//attach keypress to input
				$('.formcartcant, .formcartcantof').keydown(function(event) {
					// Allow special chars + arrows 
					if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
						|| event.keyCode == 27 || event.keyCode == 13 
						|| (event.keyCode == 65 && event.ctrlKey === true) 
						|| (event.keyCode >= 35 && event.keyCode <= 39)){
							if (event.keyCode == 9 )
							{
								//document.confirmInput.submit();
								//document.getElementById("formaddcart").submit();
								//myFunction();
								//document.getElementById("formaddcart").submit();
							}
							return;
					}else {
						// If it's not a number stop the keypress
						if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
							event.preventDefault(); 
						}   
					}
				});
				$('.formcarritocant, .formcartcantof').keydown(function(event) {
					// Allow special chars + arrows 
					if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
						|| event.keyCode == 27 || event.keyCode == 13 
						|| (event.keyCode == 65 && event.ctrlKey === true) 
						|| (event.keyCode >= 35 && event.keyCode <= 39)){
							if (event.keyCode == 9 )
							{
								    //document.confirmInput.submit();
									//myFunction();
									
									//document.getElementById("formaddcart").submit();
							}
							return;
					}else {
						// If it's not a number stop the keypress
						if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
							event.preventDefault(); 
						}   
					}
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
    
	  var $ingreso=0;
	  var $ingreso2=0; 
	  var $ingreso = <?php 
							if (!empty($sursale))
							{
								if (empty ($this->request->session()->read('ingreso')))
								{
								echo '0';
								}
								else
								echo '1';
							}
							else
								echo '1';
							?>;
	   var $ingreso2=0; 
	   var $ingreso2 = <?php 
							if (!empty($noticiaimportante))
							{
								if (empty ($this->request->session()->read('ingreso2')))
								{
								echo '0';
								}
								else
								echo '1';
							}
							else
								echo '1';
							?>;  
	  
	 /* var $ingreso2 = */<?php 
							/*if (!empty($sursale2))
							{
								if (empty ($this->request->session()->read('ingreso2')))
								{
								echo '0';
								}
								else
								echo '1';
							}
							else
								echo '1';*/
							?>/*;						*/
							
	if ($ingreso > 0) {
		 
			document.getElementById('dialog-message').style.display = 'none';
			<?php echo $this->request->session()->write('ingreso',1)?>;
			  window.scrollTo(0,0);
		//$("#dialog-message").hide();
		
	}
	if ($ingreso2 > 0) {
		 
			document.getElementById('dialog-message2').style.display = 'none';
			<?php echo $this->request->session()->write('ingreso2',1)?>;
			  window.scrollTo(0,0);
		//$("#dialog-message").hide();
		
	}	

	 $(document).ready(function(){
	 
		if ($ingreso <1) {
		$( "#dialog-message" ).dialog({
		   
		  open: function(event, ui) { $(".ui-dialog-titlebar", ui.dialog).hide(); } ,
		  height:$(window).height()*.99,
		  width: $(window).width()*.70,
		  closeOnEscape: false ,
		  position: { my: "center top", at: "center top", of: window , collision: "none"},
		  modal: true,
		  buttons: {
			
			"Continuar": function() {
			 
			  $( this ).dialog( "close" );
			}
		  }
		});
		<?php echo $this->request->session()->write('ingreso',1);?>;
	  window.scrollTo(0,0);
	  }
	  
	  if ($ingreso2 <1) {
		$( "#dialog-message2" ).dialog({
		   
		  open: function(event, ui) { $(".ui-dialog-titlebar", ui.dialog).hide(); } ,
		  height:$(window).height()*.99,
		  width: $(window).width()*.70,
		  closeOnEscape: false ,
		  position: { my: "center top", at: "center top", of: window , collision: "none"},
		  modal: true,
		  buttons: {
			
			"Continuar": function() {
			 
			  $( this ).dialog( "close" );
			}
		  }
		});
		<?php echo $this->request->session()->write('ingreso2',1);?>;
	  window.scrollTo(0,0);
	  }
	  } );
	

	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-54312928-1', 'auto');
	  ga('send', 'pageview');	
    </script>
</body>
</html>