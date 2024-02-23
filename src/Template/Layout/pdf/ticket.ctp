<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title>
        <?= $this->fetch('title') ?>
    </title>
	<link rel="stylesheet" type="text/css" href="http://www.drogueriasur.com.ar/ds/css/stylepdf.css">
    
</head>
<body>
<div class=cabecera>
	<div align=center>
	<?php 	if ($reclamo['tipo']==0) 
			echo 'Comprobante Obligatorio de Devolución'; 
		else echo 'Comprobante Obligatorio de Reclamo';?>
	 
	</div>
	<div class=logo>
	<img src="http://www.drogueriasur.com.ar/ds/img/logo.png"></img>
	<?php //echo $this->Html->image('logo.png', ['alt' => 'Drogueria Sur S.A.','fullBase' => true]);?>
	</div>
	<br>
	<div class=contacto>
	CUIT: 30-70952251-1 </br>
	GLN: 7798170920008 </br>
	Villarino 46/58 (B8000JIB) </br>
	Bahía Blanca - Buenos Aires</br>
	(0291) 458 3077 </br>
	<a href=mailto:sursa@drogueriasur.com.ar>sursa@drogueriasur.com.ar</a> </br>
	<a href=www.drogueriasur.com.ar>www.drogueriasur.com.ar</a>
	</br>
	</div></br>
	<div class=anexo>
	
	</div>
</div>

    <div id="container">
        <div id="content">
            <?= $this->fetch('content') ?>
        </div>
    </div>
</body>
</html>