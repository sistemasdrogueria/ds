<hr></hr>
<div class="comprobantes_datos">
<h1 class="subheader"><?= __('Datos del Cliente') ?></h1>

<div class=datos_left>
<div class=linea><div class="labeldatos"><?= __('Razón Social:') ?></div>	<div class="resuldatos2"><?php echo $comprobante['cliente']['razon_social'];?></div></div>
<div class=linea><div class="labeldatos"><?= __('CUIT:') ?></div>			<div class="resuldatos"><?php echo $comprobante['cliente']['cuit'];?></div></div>
<div class=linea><div class="labeldatos"><?= __('Dirección:') ?></div>		<div class="resuldatos2"><?php echo $comprobante['cliente']['domicilio'];?></div></div>
<div class=linea><div class="labeldatos"><?= __('Localidad:') ?></div>		<div class="resuldatos"><?php echo $comprobante['cliente']['localidad']['nombre'];?></div></div>
<div class=linea><div class="labeldatos"><?= __('Email:') ?></div>			<div class="resuldatos2"><?php echo $comprobante['cliente']['email'].' , '. $comprobante['cliente']['email_alternativo'];?></div></div>
</div>
<div class=datos_right>
<div class=linea><div class="labeldatos"><?= __('Código:') ?></div>	<div class="resuldatos2"><?php echo $comprobante['cliente']['codigo'];?></div></div>
<div class=linea><div class="labeldatos"><?= __('GLN:') ?></div>		<div class="resuldatos"><?php echo $comprobante['cliente']['gln'];?></div></div>
<div class=linea><div class="labeldatos"><?= __(' ') ?></div>		<div class="resuldatos2"><?= __(' ') ?></div></div>
<div class=linea><div class="labeldatos"><?= __('Provincia:') ?></div><div class="resuldatos"><?php echo $comprobante['cliente']['provincia']['nombre'];?></div></div>
<div class=linea><div class="labeldatos"><?= __('') ?></div><div class="resuldatos2"></div></div>
</div>
</div>
<hr></hr>
<div class="comprobantes_datos">
<h1 class="subheader"><?= __('Datos de la Factura') ?></h1>    
<div class=datos_left>
<div class="labeldatos"><?= __('Fecha') ?></div><div class="resuldatos"><?php echo date_format($comprobante['fecha'],'d-m-Y');?></div>
</div>
<div class=datos_right >
<div class="labeldatos"><?= __('Número') ?></div><div class="resuldatos"><?php echo str_pad($comprobante->seccion, 4, "0", STR_PAD_LEFT).'-'.str_pad($comprobante->numero, 8, "0", STR_PAD_LEFT);?></div>
</div>
</div>
<script type="text/javascript">
document.getElementById("remito_numero").textContent +="<?php echo str_pad($facturascabeceras->remito_seccion, 4, "0", STR_PAD_LEFT).' - '.str_pad($facturascabeceras->remito_numero, 8, "0", STR_PAD_LEFT);?>";
document.getElementById("remito_fecha").textContent +="<?php echo date_format($facturascabeceras['fecha'],'d / m / Y');?>";
</script>