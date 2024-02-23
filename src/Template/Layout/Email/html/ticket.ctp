<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $this->fetch('title') ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Correo</title>
<style type="text/css">
 .linea { border:solid 1px #d8d8d8;font-family:Arial,Helvetica,sans-serif;font-size:12px;padding-left:5px;padding-right:5px }
 .fila {padding:2px 0px 2px 20px;}
 .tabla1 {font-family:Arial,Helvetica,sans-serif;border-top:2px solid #000000;border-bottom:2px solid #000000;}
 .cliente {font-family:Arial,Helvetica,sans-serif; font-size:16px; font-weight:bold;}
 .clientedatos{font-weight: bold; font-size: 14px;}
 .transaccion {font-size: 16px; padding: 0px 30px 0px 30px; font-weight: bold; background-color: #edeef0; font-family: Arial,Helvetica,sans-serif; margin-left: 10px}
 .tituloresumen {font-size:14px;padding:30px 20px 0px 20px; color: #005ca4; }
 .infocontacto{font-size:12px;}
</style>
</head>
<body>
    <?= $this->fetch('content') ?>
</body>
</html>
