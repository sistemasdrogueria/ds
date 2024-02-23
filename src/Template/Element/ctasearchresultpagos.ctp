<div class="ctacteEstados index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
		
                <th><?= $this->Paginator->sort('fecha_ingreso') ?></th>
                <th><?= $this->Paginator->sort('detalle') ?></th>
                
                <th><?= $this->Paginator->sort('fecha_aplicacion') ?></th>
                <th><?= $this->Paginator->sort('nota') ?></th>
				<th><?= $this->Paginator->sort('importe') ?></th>
			<th>Subtotal</th>
		</tr>
    </thead>
    <tbody>

	<div id="flotante"></div>
    <?php $indice=0;
		$total =0;
	?>
	
    <?php foreach ($ctactePagos as $ctactePago): ?>
        <?php $indice+=1;?>
		<tr>
			<td class="colcenter">
				<?php echo date_format($ctactePago['fecha_ingreso'],'d-m-Y');?>
			</td>
            <td class="colcenter">
				<?php echo $ctactePago['tp']['nombre']; ?>
            </td>
            <td  class="colcenter">
			<?php 
				echo date_format($ctactePago['fecha_aplicacion'],'d-m-Y');?>
			</td>
			<td><?php 
					if ($ctactePago['tipo_pago_id']==32 or $ctactePago['tipo_pago_id']==33 or $ctactePago['tipo_pago_id']==34)
						echo substr($ctactePago['detalle'],0,6);
					else
						echo $this->Number->format($ctactePago['nota']) ?></td>
            <td class='colprecio2'> <?php 
			if ($ctactePago['signo']==1)
				echo '$ -'.number_format(round($ctactePago['importe'], 3),2,',','.'); 
			else
				echo '$  '.number_format(round($ctactePago['importe'], 3),2,',','.'); 
			?>
			</td>
			<td class='colprecio2'> 
			
			<?php 
			
			if ($ctactePago['signo']==1)
				$total = $total - $ctactePago['importe'];
			else
				$total = $total + $ctactePago['importe'];
			
			echo '$  '.number_format(round($total, 3),2,',','.'); 
			
			?>
			</td>
        </tr>
    <?php endforeach; $indice+=2;?>
	 <?php 
		if ($opcion==0 || $opcion==7)
		foreach ($ctactePagosOS as $ctactePago): ?>
        <?php $indice+=1;?>
		<tr>
			<td class="colcenter">
				<?php echo date_format($ctactePago['fecha'],'d-m-Y');?>
			</td>
            <td class="colcenter">
				<?php echo $ctactePago['ob']['nombre']; ?>
            </td>
            <td  class="colcenter">
			<?php 
				echo date_format($ctactePago['fecha'],'d-m-Y');?>
			</td>
			<td><?php echo $this->Html->link($ctactePago['nro_nota'],['controller'=>'Comprobantes','action' => 'downloadfile', $ctactePago['nro_nota'], 3,date_format($ctactePago->fecha,'Ymd')]); ?></td>
            <td class='colprecio2'> <?php 
			if ($ctactePago['signo']==1)
				echo '$ -'.number_format(round($ctactePago['importe'], 3),2,',','.'); 
			else
				echo '$  '.number_format(round($ctactePago['importe'], 3),2,',','.'); 
			?>
			</td>
			<td class='colprecio2'> 
			<?php 
			if ($ctactePago['signo']==1)
				$total = $total - $ctactePago['importe'];
			else
				$total = $total + $ctactePago['importe'];
			
			echo '$  '.number_format(round($total, 3),2,',','.'); 
			
			?>
			</td>
        </tr>
    <?php endforeach; $indice+=1;?>
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