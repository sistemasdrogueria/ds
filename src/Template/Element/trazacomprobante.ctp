<div class="comprobantes view large-10 medium-9 columns">
    
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Comprobantes Tipo') ?></h6>
            <p>
			
			<?= $comprobante->has('comprobantes_tipo') ? $comprobante->comprobantes_tipo->nombre : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
		<div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha') ?></h6>
            <p><?php echo date_format($comprobante['fecha'],'d-m-Y');?></p>
        </div>        
		<h6 class="subheader"><?= __('Nota', 'Nro. Pedido') ?></h6>
          

		<p><?= $this->Number->format($comprobante->nota) ?></p>
            <h6 class="subheader"><?= __('Nro Comprobante') ?></h6>
            <p>  <?php echo str_pad($comprobante->seccion, 4, "0", STR_PAD_LEFT).'-'.$comprobante->numero;?></p>
           
            <h6 class="subheader"><?= __('Importe') ?></h6>
            <p> <?php echo '$ '.number_format(round($comprobante->importe, 3),2,',','.'); ?>  </p>
        </div>

    </div>
</div>