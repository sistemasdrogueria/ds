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
        <?php if ($opcion<4) echo 'SOLICITUD DE TARJETA:';
              else 
                  echo 'SOLICITUD DE TALONARIO'; 
              ?> 
       </span>
				<br>
      </td>
      <td>&nbsp;</td>
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
              <span class="comprador"><span class="compradordatos"><?php echo $cliente['nombre']; ?></span>(<?php echo $cliente['codigo']; ?>)</span></td>
            </tr>
	
			<tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle"> Email: 
              <strong align="center" class="transaccion"><?php echo $cliente['email']; ?></strong></td>
            </tr>		
            <tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle"> 
              <?php if ($opcion<4) echo 'TARJETA:'; else echo 'TALONARIO';?> 
              
              <strong align="center" class="transaccion">
                <?php if ($opcion==1) echo 'Banco Credicoop'; 
                      if ($opcion ==2) echo 'Banco Nación'; 
                      if ($opcion ==3) echo 'Banco Patagonia Distribution'; 
                      if ($opcion ==5) echo 'Cobinpro'; 
                      if ($opcion ==4) echo 'Banco Provincia Pactar'
                      ?>
                
              </strong></td>
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

<!-- end .container --></div>