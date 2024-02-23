<?php use Cake\I18n\Time; ?>
<div class="ctacteEstados index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			<th><?= $this->Paginator->sort('fecha_vencimiento','Fecha de Venc.') ?></th>
            <th><?= $this->Paginator->sort('ctacte_tipo_registros_id','Detalle') ?></th>
			<th><?= $this->Paginator->sort('fecha_compra','Fecha de Compra') ?></th>
            <th><?= $this->Paginator->sort('importe') ?></th> 
			<th>Subtotal</th>
		</tr>
    </thead>
    <tbody>
	<div id="flotante"></div>
    <?php $indice=0;
		$total =0;
		$fech = Time::now();
	$tiporegistros = $ctactetiporegistros->toArray();?>
	

    <?php foreach ($ctacteEstados as $ctacteestado): ?>
        <?php $indice+=1;?>
		<tr>
			<td class="colcenter">
			<?php 
					if (date_format($ctacteestado->fecha_vencimiento,'d-m-Y')!="01-01-0101")
						echo date_format($ctacteestado->fecha_vencimiento,'d-m-Y');
			?>
			</td  >
            <td class="colcenter">
			<?php 
				  if ($ctacteestado['ctacte_tipo_registros_id']==1 && $ctacteestado->importe == $totaltarjetacredito)
							echo 'Tarjetas de Credito';
					  else
						    if ($ctacteestado->signo==0 && $ctacteestado->ctacte_tipo_registros_id==4)
									echo 'Nota de Debito';
								else
									if ($ctacteestado->ctacte_tipo_registros_id==1 && $ctacteestado->signo==0)
									echo 'SALDO';
									else
									echo $tiporegistros[$ctacteestado['ctacte_tipo_registros_id']]; 
				
			?>
            </td>
            <td  class="colcenter">
			<?php 
			if (date_format($ctacteestado->fecha_compra,'d-m-Y')!="01-01-0101")
			{
				if (date_format($ctacteestado->fecha_compra,'d-m-Y')!="01-01-1970")
					echo date_format($ctacteestado->fecha_compra,'d-m-Y');
			}
			?>
			</td>
            <td class='colprecio2'> <?php 
			if ($ctacteestado->signo==1)
				echo '$ -'.number_format(round($ctacteestado['importe'], 2),2,',','.'); 
			else
				echo '$  '.number_format(round($ctacteestado['importe'], 2),2,',','.'); 
			?>
			</td>
		
			<?php 
			if ($ctacteestado->signo==1)
				$total = $total - $ctacteestado['importe'];
			else
				$total = $total + $ctacteestado['importe'];
			//echo $fech;
			if ($ctacteestado->fecha_vencimiento > $fech || $total<0)
			echo '<td class=colprecio3>$  '.number_format($total,2,',','.').'</td>'; 
			else
			echo '<td class=colprecio3 style="color:red">$  '.number_format($total,2,',','.').'</td>'; 
			?>
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