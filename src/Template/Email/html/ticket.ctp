<div class="container">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td>&nbsp;</td>
      <td height="80" colspan="2" style="margin-left: 20px">
    
	<img src= 'http://www.drogueriasur.com.ar/ds/webroot/img/logo.png' alt='Drogueria Sur S.A.' 
	style= "font-family: Georgia, Times New Roman, serif; font-size: 14px; color: #fff;"/>
     
    </td>
	  <td>&nbsp;</td>
  </tr>
      
	  	
	  <tr>
         <td>&nbsp;</td>  
          <td style="margin-left: 20px">  <?php	$texto = nl2br($content);
						$lineas = explode  ( '<br/>'  , $texto );
						foreach ($lineas as $k => $v) {
							echo $v .'<br/>';
						}  
				?>	 
            
          </td>
		 <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
		   
              <td colspan="2"  align="center" height="50" valign="middle">
				<span style="font-size: 22px; color: #005ca4; font-weight: bold">Ticket</span>
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
              <td colspan="3" class="tituloresumen" align="left" height="20" valign="middle"><strong >Detalle:</strong></td>
            </tr>
			 <tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle"> Numero de Transacción: 
              <strong class="transaccion"><?php echo $reclamo['id'] ?></strong></td>
            </tr>
            <tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle"> Generado el: 
              <strong align="center" class="transaccion"><?php echo date_format($reclamo['creado'],'d-m-Y H:i:s');?></strong></td>
            </tr>
			<tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle"> Razón Social: 
              <span class="comprador"><span class="compradordatos"><?php echo $reclamo['cliente']['nombre']; ?></span>(<?php echo $reclamo['cliente']['codigo']; ?>)</span></td>
            </tr>
			<tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle"> Motivo: 
              <strong align="center" class="transaccion"><?php  echo $reclamo['reclamos_tipo']['nombre']; ?></strong></td>
            </tr>			
			<tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle"> Email: 
              <strong align="center" class="transaccion"><?php echo $reclamo['cliente']['email']; ?></strong></td>
            </tr>		
			<tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle"> Factura Nro: 
              <strong align="center" class="transaccion"><?php echo str_pad($reclamo['factura_seccion'], 4, '0', STR_PAD_LEFT).'-'.str_pad($reclamo['factura_numero'], 8, '0', STR_PAD_LEFT);?></strong></td>
            </tr>
			<tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle"> Pedido Nro: 
              <strong align="center" class="transaccion"><?php echo $reclamo['pedido_numero'] ?></strong></td>
            </tr>				
			<tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle"> Factura Fecha: 
              <strong align="center" class="transaccion"><?php echo date_format($reclamo['fecha_recepcion'],'d-m-Y');?></strong></td>
            </tr>	
			<tr>
              <td colspan="3" class="fila" align="left" height="20" valign="middle">Observaciones: 
              <strong class="comprador"><?= h($reclamo['observaciones']) ?></strong></td>
            </tr>
	 
		 
            <tr>
              <td colspan="3" class="fila" align="left" valign="middle"> <span style="font-weight: bold; color:#8ea800">Producto/s</span>
                <table style="margin:10px 0px 0px 0px" border="0" cellpadding="0" cellspacing="0" width="758">
                  <tbody>
                    <tr style="background-color:#edeef0">
                      <td class="linea" height="25" width="60">Cant..</td>
					  <td class="linea" height="25" width="80">EAN.</td>
                     
                      <td class="linea" height="25" width="300">Producto</td>
					 <td class="linea" height="25" width="60">F. Venc</td>
					 <td class="linea" height="25" width="60">Lote</td>
					 <td class="linea" height="25" width="60">Serie</td>
                    </tr>
                   
					<?php foreach ($reclamositemstemps as $reclamosItemsTemp): ?>
					<tr>
						<td style="width:5%;  "><?php echo $reclamosItemsTemp['cantidad'] ?></td>
						<td style="width:40%; "><?php echo $reclamosItemsTemp['detalle'] ?></td>
						<td style="width:25%; "><?php echo $reclamosItemsTemp['a']['codigo_barras'];?></td>
						<td style="width:10%; ">	
						<?php 	if ($reclamosItemsTemp['fecha_vencimiento']!=null)
									echo date_format($reclamosItemsTemp['fecha_vencimiento'],'d-m-Y');	?>
						</td>
						<td style="width:10%; "><?php echo $reclamosItemsTemp['lote']  ?></td>
						<td style="width:10%; "><?php echo $reclamosItemsTemp['serie'] ?></td>
					</tr>
					<?php endforeach; ?>
				
					         
                  </tbody>
                </table></td>
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
		
       Ante cualquier duda acerca sobre este correo, contactase con nuestro Centro de Atención al Cliente (0291) 458-3077 o vía e-mail a: contacto@drogueriasur.com.ar

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