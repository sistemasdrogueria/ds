<!DOCTYPE html>
<html>
<head>
<title>Trabaja en Drogueria Sur</title>
<meta charset=utf-8>
<?php echo $this->Html->meta('favicon.ico','/favicon.ico',['type'=>'icon']);?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
	echo $this->Html->css('job/main'); 
	echo $this->Html->css('job/mediaqueries'); 
	echo $this->Html->css('job/style');
	echo $this->Html->script('https://www.google.com/recaptcha/api.js?render=6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB');
?>	
<!--[if lt IE 9]>
<link href="job/ie/ie8.css" rel="stylesheet" type="text/css" media="all">
<script src="job/ie/css3-mediaqueries.min.js"></script>
<script src="job/ie/html5shiv.min.js"></script>
<![endif]-->
</head>
<body class="">
<div class="wrapper row2">
  <!-- ################################################################################################ -->
  <div id="intro" class="clear">
 	<div style="float: left;  z-index: 1;">
	<?php echo $this->Html->image('job/cv-portada.jpg', ['alt' => 'Drogueria Sur S.A.','url'=>['controller'=>'Jobs','action'=>'index']]);?>
	</div>
	<div style="padding:30px; float: left; margin-left: 100px; margin-top: -230px; z-index: 3; background-color:#FFFFFF;">
		<?php echo $this->Html->image('job/logo200.png', ['alt' => 'Drogueria Sur S.A.','style'=> "width: auto;max-width: 300px;",'url'=>['controller'=>'Pages','action'=>'index']]);?>
	</div>
	<div>
      <p class="nospace" style="float: right;  margin-right: 180px; margin-top: -90px; z-index: 4;">
	 <?php  echo $this->Html->link(	'Cargar CV',	['controller' => 'Curriculums', 'action' => 'index', '_full' => true],
		[ 'class'=>'button large gradient green rnd5']);?>
	  </p>
   </div>
  </div>
  <!-- ################################################################################################ -->
</div>
<!-- content -->
<div class="wrapper row3">
  <div id="container">
    <!-- ################################################################################################ -->
    <div id="homepage" class="clear">
			<div id="mensaje" style="display:none;">
				<?= $this->Flash->render('changepass'); ?>
			</div>
      <div class="two_third first">
			
		<?= $this->fetch('content'); ?>
      </div>
      <div class="one_third">
        <div class="clear">
			<h2 class="font-medium">INFORMACION DE CONTACTO</h2>
		  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3112.761952800859!2d-62.26395368498128!3d-38.72327397959792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95edbcb52a491f8f%3A0x61dadf763ddfe6d1!2sDroguer%C3%ADa+Sur!5e0!3m2!1ses-419!2sar!4v1520881701189" width="95%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
		  <div>
		  </br>
		   <h2 class="nospace font-medium">Dirección:</h2>
			Villarino 46/58 (B8000JIB) </br>
			Bahía Blanca - Buenos Aires</br>
			</br>
			<h1  class="nospace font-medium">Email: </h1>
			<a href=mailto:sursa@drogueriasur.com.ar>sursa@drogueriasur.com.ar</a> </br>
			</br>
			<h1  class="nospace font-medium">Call Center</h1>
			Línea General: (0291) 458 3077 </br>
		
			</br>
			<h1 class="nospace font-medium">Horarios:</h1>
			Lunes a Viernes de 8 a 21 hs. </br>
			</div>
          <!--div class="one_half first"><a href="#"><img src="images/demo/video.gif" alt=""></a></div -->
          <!--div class="one_half"><a href="#"><img src="images/demo/video.gif" alt=""></a></div -->
        </div>
        <div class="divider2"></div>      
      </div>
    </div>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- Footer -->

<div class="wrapper row4">
  <div id="copyright" class="clear">
    <p class="fl_left">Copyright &copy; <?php echo date("o"); ?> - All Rights Reserved - <a href="#">drogueriasur.com.ar</a></p>
    
  </div>
</div>
<!-- Scripts -->

<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<!--script>window.jQuery || document.write('<script src="job/jquery-latest.min.js"><\/script>\
<script src="job/jquery-ui.min.js"><\/script>')</script>
<script>jQuery(document).ready(function($){ $('img').removeAttr('width height'); });</script -->

<?php   echo $this->Html->css('jquery.notifyBar');
		echo $this->Html->script('jquery.notifyBar'); ?>
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
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>


</body>
</html>