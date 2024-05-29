<!--DOCTYPE html -->

<?php 


echo $this->Html->docType('html5');
?>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class=no-js> <!--<![endif]-->
<html lang="es">

<head>
<meta name="viewport" content="width=device-width, maximum-scale=1">

<meta property="og:title" content="TE INVITAMOS A COMPARTIR UNA NOCHE DISTINTA">
<meta property="og:url" content="https://www.drogueriasur.com.ar/ds/enlaces/index">
<meta property="og:image" content="https://www.drogueriasur.com.ar/ds/img/whatsapp/invitaciones/invitaciones.jpg">

<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:domain" content="drogueriasur.com.ar">
<meta property="twitter:url" content="https://www.drogueriasur.com.ar/ds/enlaces/index">
<meta name="twitter:title" content="TE INVITAMOS A COMPARTIR UNA NOCHE DISTINTA">

<meta name="twitter:image" content="https://www.drogueriasur.com.ar/ds/img/whatsapp/invitaciones/invitaciones.jpg">
<meta charset="utf-8"> 
  <title>DROGUERIA SUR</title>
  <?php
  echo $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']);
  
  echo $this->fetch('meta');
  ?>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!--[if lt IE 9]>

<![endif]-->

</head>
<body style="background-color: rgb(130 180 247);">
<?=$this->fetch('content')?>
</body>

</html>