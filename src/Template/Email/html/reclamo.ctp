<div class="container">
<br/>
				<?php	$texto = nl2br($content);
						$lineas = explode  ( '<br/>'  , $texto );
						foreach ($lineas as $k => $v) {
							echo $v .'<br/>';
						}  
				?>	

				

<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" >
<tr> <!-- Grande -->
    <td>
		<div style="border-width: 2px; border-style: solid; border-color: #666; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
		<table width="690" border="0" align="center" cellpadding="0" cellspacing="0" >
			  
			<tr>
				<td colspan="4">
				
				<table class="viewlabel">
					<tr>
						<td style="width:30%;"><h4 ><?= __('Nro de Reclamo') ?></h4></td>
						<td style="width:70%;>"<h4><?php echo $this->Number->format($reclamo['id']) ?></h4></td>
					</tr>
					<tr>			
						<td><h4 ><?= __('Fecha y Hora') ?></h4></td>
						<td><h4><?php echo date_format($reclamo['creado'],'d-m-Y H:i:s');?>	</h4></td>
					</tr>	
					<tr>			
						<td><h4 ><?= __('Cliente') ?></h4></td>
						<td><h4><?php echo $reclamo['cliente']['codigo'].' - '. $reclamo['cliente']['nombre']; ?></h4></td>
					</tr>
					<tr>    
						<td><h4 ><?= __('Reclamos Tipo') ?></h4></td>
						<td><h4 ><?php  echo $reclamo['reclamos_tipo']['nombre']; ?></h4></td>
					</tr>
					<tr>    
						<td><h4 ><?= __('Email') ?></h4></td>
						<td><h4 ><?php  echo $reclamo['cliente']['email']; ?></h4></td>
					</tr>
					<tr>			
						<td><h4 ><?= __('Pedido Nro') ?></h4></td>
						<td><h4><?= $this->Number->format($reclamo['factura_numero']) ?></h4></td>
					</tr>
					<tr>			
						<td><h4 ><?= __('Fecha Recepcion') ?></h4></td>
						<td><h4><?php echo date_format($reclamo['fecha_recepcion'],'d-m-Y');?></h4></td>
					</tr>	
					<tr>			
						<td><h4 ><?= __('Estado') ?></h4></td>
						<td><h4 ></h4></td>
					</tr>
					<tr>    
						<td><h4 ><?= __('Observaciones') ?></h4></td>
						<td><h4><?= h($reclamo['observaciones']) ?></h4></td>
					</tr>
				</table>
				<table class='tablesorter' cellpadding="0" cellspacing="0">
				<thead>
					<tr>	
						<th>Cant.</th>
						<th>Descripción</th>
						<th>Laboratorio</th>
						<th>Fecha Venc.</th>
						<th>Lote</th>
						<th>Serie</th>
					</tr>
				</thead>
				<?php $lab = $laboratorios; ?>
				<tbody>
					<?php foreach ($reclamositemstemps as $reclamosItemsTemp): ?>
					<tr>
						<td style="width:5%; "><?= $this->Number->format($reclamosItemsTemp['cantidad']) ?></td>
						<td style="width:40%; "><?= h($reclamosItemsTemp['detalle']) ?></td>
						<td style="width:25%; "><?php echo $lab[$reclamosItemsTemp['a']['laboratorio_id']];?></td>
						<td style="width:10%; ">	
						<?php 
							if ($reclamosItemsTemp['fecha_vencimiento']!=null)
									echo date_format($reclamosItemsTemp['fecha_vencimiento'],'d-m-Y');
						?>
						</td>
						<td style="width:10%; "><?= h($reclamosItemsTemp['lote']) ?></td>
						<td style="width:10%; "><?= h($reclamosItemsTemp['serie']) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
			
				</td>    
			</tr>
			<tr></tr>
		</table>
    </div>
    </td>
</tr> <!-- Grande -->
<tr>
		<td align="center">&nbsp;</td>
</tr>
<?php $direc='http://www.drogueriasur.com.ar/ds'; ?>
<tr>
		<td height="160" colspan="2">    
			<img src="<?php echo $direc.'/webroot/img/logo.png';?>" alt='Drogueria Sur S.A.' 
			style= "font-family: Georgia, Times New Roman, serif; font-size: 24px; color: #fff;"/>
		</td>
</tr>
</table>
<!-- end .container --></div>