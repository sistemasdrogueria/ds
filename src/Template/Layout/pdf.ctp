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
<hr></hr>
<div class=logo>
<img src="https://www.drogueriasur.com.ar/ds/img/logo.png"></img>
<?php //echo $this->Html->image('logo.png', ['alt' => 'Drogueria Sur S.A.','fullBase' => true]);?>
</div>
<br>
<div class=remito>
<div class=remito_letra> R </div>
<div class=remito_codigo> Código: 91 </div>
</div>
<div class=remito_numero_fecha>
<div class=remito_palabra>REMITO</div>
<div class=remito_numero ><div id=remito_numero_n>N° :</div><div id=remito_numero></div></div>
<div class=remito_fecha > <div id=remito_fecha_f>FECHA:</div><div id=remito_fecha></div></div>
</div>
<div class=datos_empresa>
Villarino 46/58 (B8000JIB) </br>
Bahía Blanca - Buenos Aires</br>
(0291) 458 3077 </br>
<a href=mailto:sursa@drogueriasur.com.ar>sursa@drogueriasur.com.ar</a> </br>
<a href=www.drogueriasur.com.ar>www.drogueriasur.com.ar</a>
</br>
</div>
<div class=datos_impositivo>
C.U.I.T. 30-70952251-1</br>
Ing.Brutos Conv.Mult. 902-493689-8  </br>
GLN: 7798170920008 </br>
Inicio de Actividades 01/09/06</br>
</div>
</div>
<div id="container">
<div id="content">
<?= $this->fetch('content') ?>
</div>
</div>
</body>
</html>


