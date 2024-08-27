<style>
.ctadescripcion{ width: 50%;}
.tablafacturacabecera{ width: 99%;}
</style>
<div class="notasCabeceras view large-10 medium-9 columns">
<table class=tablafacturacabecera cellpadding="0" cellspacing="0">
<tr> 
<td class="ctadescripcion"><?= __('Fecha') ?></td>
<td class="carrito_importe"><?php echo date_format($notasCabecera['fecha'],'d-m-Y');?></td>
</tr>	
<tr>
<td class="ctadescripcion"><?= __('Comprobante T.') ?></td>
<td class="carrito_importe"><?php echo $notasCabecera['letra'].' ';?></td>
</tr>
<tr>
<td class="ctadescripcion"><?= __('Comprobante N°.') ?></td>
<td class="carrito_importe"><?php echo str_pad($notasCabecera['comprobante']['seccion'] , 4, "0", STR_PAD_LEFT).'-'.str_pad($notasCabecera['comprobante']['numero']  	, 8, "0", STR_PAD_LEFT);?></td>
</tr>
<tr>
<td class="ctadescripcion"><?= __('N° Nota') ?></td>
<td class="carrito_importe">  <?= $this->Number->format($notasCabecera['nota']) ?></td>
</tr>
<tr class="ctadescripciontotal">
<td class="ctadescripcion"><?= __('Imp Exento') ?></td>
<td class="carrito_importe"><?php echo '$ '.number_format($notasCabecera['imp_exento'],2,',','.'); ?></td>
</tr>
<tr >	
<td class="ctadescripcion"> <?= __('Imp Gravado') ?></td>
<td class="carrito_importe"><?php echo '$ '.number_format($notasCabecera['imp_gravado'],2,',','.'); ?></td>	
</tr>
<tr>	
<td class="ctadescripcion"><?= __('Imp Iva') ?></td>
<td class="carrito_importe"><?php echo '$ '.number_format($notasCabecera['imp_iva'],2,',','.'); ?></td>	
</tr>
<tr>
<td class="ctadescripcion"><?= __('Imp Rg3337') ?></td>
<td class="carrito_importe"> <?php echo '$ '.number_format($notasCabecera['imp_rg3337'],2,',','.'); ?></td>	
</tr>
<tr>
<td class="ctadescripcion"><?= __('Imp Ingreso Bruto') ?></td>
<td class="carrito_importe"><?php 
echo '$ '.number_format($notasCabecera['imp_ingreso_bruto'],2,',','.'); 
?>
</td>
</tr>
<tr class="ctadescripciontotal">
<td class="ctadescripcion">
<?= __('TOTAL') ?>

</td>
<td class="carrito_importe">
<?php echo '$ '.number_format($notasCabecera['total'],2,',','.'); ?>
</td>
</tr>
<tr >	
<tr>	
<td class="ctadescripcion"></td>
<td class="carrito_importe">
<?php 

?>
</td>
</tr>
</table>

</div>
