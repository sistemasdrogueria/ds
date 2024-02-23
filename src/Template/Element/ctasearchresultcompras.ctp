<div class="ctacteComprasSemanales index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			<th><?= $this->Paginator->sort('fecha_factura','Fecha Fact.') ?></th>
            <th><?= $this->Paginator->sort('numero','Nro Fact.') ?></th>
			<th><?= $this->Paginator->sort('numero','Nro Ped.') ?></th>
			<th><?= $this->Paginator->sort('tipo','Detalle') ?></th>
            <th><?= $this->Paginator->sort('importe') ?></th>
			<th><?= $this->Paginator->sort('fecha_vencimiento','Fecha Venc.') ?></th>
			
		</tr>
    </thead>
    <tbody>
	<div id="flotante"></div>
    <?php $indice=0;
	?>

    <?php foreach ($ctacteComprasSemanales as $ctacteComprasSemanale):	?>
        <?php $indice+=1;?>
		<tr>
			<td class="colcenter">
			<?php echo date_format($ctacteComprasSemanale->fecha_factura,'d-m-Y');	?>
			</td>
			<td class="colcenter">
				<?php echo str_pad($ctacteComprasSemanale['ce']['seccion'], 4, "0", STR_PAD_LEFT).'-'.str_pad($ctacteComprasSemanale['ce']['numero'], 8, "0", STR_PAD_LEFT); ?>
			</td>
			<td class="colcenter">
			<?php echo $ctacteComprasSemanale->numero;	?>
            </td>
			 <td class="colcenter">
			<?php 
				if ($ctacteComprasSemanale->tipo==1)
				{
					echo 'Factura Medicamentos';
				}
				if ($ctacteComprasSemanale->tipo==2)
				{
					echo 'Factura Perf y Accesorios';
				}
				if ($ctacteComprasSemanale->tipo==3)
				{
					echo 'Factura a Plazo';
				}
				if ($ctacteComprasSemanale->tipo==4)
				{
					echo 'Factura Transfer';
				}
				?>
            </td>
            
            <td class='colprecio2'> <?php 
			
				echo '$ '.number_format(round($ctacteComprasSemanale->importe, 3),2,',','.'); 
			
			?>
			</td>
			
			<td class='colprecio2'>
			<?php 
			$fechavencimiento = date_format($ctacteComprasSemanale->fecha_vencimiento,'d-m-Y');
			if ($fechavencimiento =='01-01-1970')
				echo 'Sin Cond.';
			else
				echo $fechavencimiento;
			?>
			</td>
        </tr>
    <?php endforeach; $indice+=2;?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
			<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Registros') ?> </span></div>
        </ul>
    </div>
</div>
