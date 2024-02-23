<div class="ctacteEstados index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			<th><?= $this->Paginator->sort('fecha_acreditacion','Fecha Acreditación.') ?></th>
            <th><?= $this->Paginator->sort('detalle','Detalle') ?></th>
			<th><?= $this->Paginator->sort('nro_liquidacion') ?></th>
			<th><?= $this->Paginator->sort('fecha_ingreso','Fecha de ingreso') ?></th>
			
            <th><?= $this->Paginator->sort('importe') ?></th>
			
		</tr>
    </thead>
    <tbody>
	<div id="flotante"></div>
    <?php $indice=0;
	$tiporegistros = $ctactetiporegistros->toArray();?>
	
    <?php foreach ($ctacteCreditos as $ctacteestado): ?>
        <?php $indice+=1;?>
		<tr>
			<td class="colcenter">
			<?php echo date_format($ctacteestado->fecha_acreditacion,'d-m-Y');?>
			</td>
            <td class="colcenter">
			<?php echo $ctacteestado->detalle; 
			?>
            </td>
			<td class="colcenter">
			<?php echo $ctacteestado['nro_liquidacion']; 
			?>
            </td>
            <td class="colcenter">
			<?php 
				echo date_format($ctacteestado->fecha_ingreso,'d-m-Y');?>
			</td>
            <td class='colprecio2'> <?php 
			if ($ctacteestado->signo==1)
				echo '$ '.number_format(round($ctacteestado->importe, 3),2,',','.'); 
			else
				echo '$  '.number_format(round($ctacteestado->importe, 3),2,',','.'); 
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