<div class="container">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" >
<tr>
<td>&nbsp;</td>
<td height="80" colspan="2" style="margin-left: 20px">
<img src= 'http://www.drogueriasur.com.ar/ds/webroot/img/logo.png' alt='Drogueria Sur S.A.' style= "font-family: Georgia, Times New Roman, serif; font-size: 14px; color: #fff;"/>
</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2"  align="center" height="50" valign="middle">
<span style="font-size: 22px; color: #005ca4; font-weight: bold">
<?php  echo 'SOLICITUD DE APERTURA DE CUENTA:';?> 
</span>
<br><br>
</td><td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2">
<table class="tabla1" border="0" cellpadding="0" width="760">
<tbody>
<tr>
<td colspan="3" class="tituloresumen" align="left" height="20" valign="middle"><strong >Solicitante:</strong></td>
</tr>
<tr>
<td colspan="3" class="fila" align="left" height="20" valign="middle"> Fecha: 
<strong align="center" class="transaccion"><?php echo date('d-m-Y H:i:s');?></strong></td>
</tr>
<tr>
<td colspan="3" class="fila" align="left" height="20" valign="middle"> Razón Social: 
<span class="comprador"><span class="compradordatos"><strong><?php echo $clientealta['razon_social']; ?></strong></span></td>
</tr>
<tr>
<td colspan="3" class="fila" align="left" height="20" valign="middle"> Nombre de Fantasía: 
<span class="comprador"><span class="compradordatos"><strong><?php echo $clientealta['nombre_fantasia']; ?></strong></span></td>
</tr>
<tr>
<td colspan="3" class="fila" align="left" height="20" valign="middle"> Dirección: 
<span class="comprador"><span class="compradordatos"><strong><?php echo $clientealta['domicilio']; ?></strong></span></td>
</tr>
<tr>
<td colspan="3" class="fila" align="left" height="20" valign="middle"> Provincia: 
<span class="comprador"><span class="compradordatos"><strong><?php echo $provincias[$clientealta['provincia']]; ?></strong></span></td>
</tr>
<tr>
<td colspan="3" class="fila" align="left" height="20" valign="middle"> Localidad: 
<span class="comprador"><span class="compradordatos"><strong><?php echo $clientealta['localidad']; ?></span><?php echo ' ('. $clientealta['codigo_postal'].') '; ?></strong></td>
</tr>
<tr>
<td colspan="3" class="fila" align="left" height="20" valign="middle"> Email: 
<strong align="center" class="transaccion"><?php echo $clientealta['email']; ?></strong></td>
</tr>
<tr>
<td colspan="3" class="fila" align="left" height="20" valign="middle"> Teléfono: 
<strong align="center" class="transaccion"><?php echo $clientealta['telefono'].' - '. $clientealta['celular']; ?></strong></td>
</tr>
<tr>
<td colspan="3" class="fila" align="left" height="20" valign="middle"> CUIT: 
<span class="comprador"><span class="compradordatos"><?php echo $clientealta['cuit']; ?></span></td>
</tr>



<tr>
<td colspan="3" class="fila" align="left" height="20" valign="middle"> 
<?php echo 'Comentario:';?> 
<strong align="center" class="transaccion">  <?php  echo $clientealta['comentario']; ?></strong></td>
</tr>	
</tbody>
</table>
</td>
<td>&nbsp;</td>
</tr>
<tr>
<td width="20">&nbsp;</td>
<td colspan="2" align="right">
<br>
<!--span>Importe total:</span> <span style="font-weight: bold;">$ </span> <br -->
<br>
</td>
<td width="20">&nbsp;</td>
</tr>
<tr>
<td width="20">&nbsp;</td>
<td colspan="2" align="center" class="infocontacto">
<br>
</td> 
<td width="20">&nbsp;</td>
</tr>
</td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td colspan="2" align="left">
</td>
</tr>
<tr>
<td colspan="2" align="center"></td>
</tr>
</table>
</div>