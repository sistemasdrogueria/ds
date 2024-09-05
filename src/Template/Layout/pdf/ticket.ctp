<!DOCTYPE html>
<html>
<head>
<?= $this->Html->charset() ?>
<title>
<?= $this->fetch('title') ?>
</title>
<link rel="stylesheet" type="text/css" href="https://www.drogueriasur.com.ar/ds/css/stylepdf.css">
</head>
<body>
<div class=cabecera>
<div class=logoytitulo>
<div class=logo>
<img src="https://www.drogueriasur.com.ar/ds/img/logo.png"></img>
</div>
<div class=titulo>
<?php 	if ($reclamo['tipo']==0) 
echo 'Comprobante Obligatorio de Devolución'; 
else echo 'Comprobante Obligatorio de Reclamo';?>
</div>
</div>
<div class=contacto>
<div class=contactodireccion>
Villarino 46/58 (B8000JIB) </br>
Bahía Blanca - Buenos Aires</br>
(0291) 458 3077 </br>
<a href=mailto:contacto@drogueriasur.com.ar>contacto@drogueriasur.com.ar</a> </br><a href=www.drogueriasur.com.ar>www.drogueriasur.com.ar</a>
</div>	
<div class=contactootros>	
CUIT: 30-70952251-1 </br>
GLN: 7798170920008 </br>
</div>	
<div class=contactourl>
</div>
<!-- div class=anexo>
</div-->
</div>
</div>
<div id="container">
<div id="content">
<?= $this->fetch('content') ?>
</div>
</div>
</body>
</html>