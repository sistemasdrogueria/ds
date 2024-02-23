<hr></hr>
<div class="comprobantes_datos">
	<h1 class="subheader"><?= __('Datos del Cliente') ?></h1>
		
		<div class=datos_left>
		<div class=linea><div class="labeldatos"><?= __('Razón Social:') ?></div>	<div class="resuldatos"><?php echo $reclamo['cliente']['razon_social'];?></div></div>
		<div class=linea><div class="labeldatos"><?= __('CUIT:') ?></div>			<div class="resuldatos"><?php echo $reclamo['cliente']['cuit'];?></div></div>
		<div class=linea><div class="labeldatos"><?= __('Dirección:') ?></div>		<div class="resuldatos"><?php echo $reclamo['cliente']['domicilio'];?></div></div>
		<div class=linea><div class="labeldatos"><?= __('Localidad:') ?></div>		<div class="resuldatos"><?php echo $reclamo['cliente']['localidad']['nombre'];?></div></div>
		<div class=linea><div class="labeldatos"><?= __('Email:') ?></div>			<div class="resuldatos"><?php if ($reclamo['cliente']['email']!=null) echo $reclamo['cliente']['email']; else echo $reclamo['cliente']['email_alternativo'];?></div></div>
		</div>
		<div class=datos_right>
		<div class=linea><div class="labeldatos"><?= __('Código:') ?></div>	<div class="resuldatos2"><?php echo $reclamo['cliente']['codigo'];?></div></div>
        <div class=linea><div class="labeldatos"><?= __('GLN:') ?></div>		<div class="resuldatos"><?php echo $reclamo['cliente']['gln'];?></div></div>
		<div class=linea><div class="labeldatos"><?= __(' ') ?></div>		<div class="resuldatos2"><?= __(' ') ?></div></div>
		<div class=linea><div class="labeldatos"><?= __('Provincia:') ?></div><div class="resuldatos"><?php echo $reclamo['cliente']['provincia']['nombre'];?></div></div>
		<div class=linea><div class="labeldatos"><?= __('') ?></div><div class="resuldatos2"><?= __(' ') ?></div></div>
        </div>
</div>
<hr></hr>
<div class="comprobantes_datos">
	<h1 class="subheader">
	
	<?php if ($reclamo['tipo']==0) 
			echo 'Datos de la devolución'; 
		else echo 'Datos del reclamo'; ?>
	
	</h1>    
		<div class=datos_left >
            <div class=linea><div class="labeldatos"><?= __('Número') ?></div><div class="resuldatos"><?php echo $reclamo['id'];?></div></div>
			<div class=linea><div class="labeldatos"><?= __('Fecha') ?></div><div class="resuldatos"><?php echo date_format($reclamo['creado'],'d-m-Y');?></div></div>
        </div>
		<div class=datos_right>
            <div class=linea><div class="labeldatos"><?= __('Motivo') ?></div><div class="resuldatos"><?php echo $reclamo['reclamos_tipo']['nombre'];?></div></div>
			<div class=linea><div class="labeldatos"><?= __('Obs.') ?></div>		<div class="resuldatos"><?php  echo $reclamo['observaciones']?></div></div>
		
		</div>
</div>		
<hr></hr>
<div class="comprobantes_datos">
	<h1 class="subheader"><?= __('Datos de la Factura') ?></h1>    	
		<div class=datos_left>
			<div class="labeldatos"><?= __('Fecha') ?></div><div class="resuldatos"><?php echo date_format($reclamo['fecha_recepcion'],'d-m-Y');?></div>
		</div>
		<div class=datos_right >
            <div class="labeldatos"><?= __('Número') ?></div><div class="resuldatos"><?php echo str_pad($reclamo['factura_seccion'], 4, "0", STR_PAD_LEFT).'-'.str_pad($reclamo['factura_numero'], 8, "0", STR_PAD_LEFT);?></div>
        </div>
</div>