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
		$contadordeudor=0;
	$tiporegistros = $ctactetiporegistros->toArray();?>
	

    <?php foreach ($ctacteEstados as $ctacteestado): ?>
        <?php $indice+=1;
				$fecha_actual = strtotime(date("d-m-Y",time()));
				if ($ctacteestado->signo==1)
						$total = $total - $ctacteestado['importe'];
		
					else
						$total = $total + $ctacteestado['importe'];
		?>
		<tr>
			<td class="colcenter">
			<?php 
					if (date_format($ctacteestado->fecha_vencimiento,'d-m-Y')!="01-01-0101")
						echo date_format($ctacteestado->fecha_vencimiento,'d-m-Y');
						if($ctacteestado->fecha_vencimiento < $fech){
									$estadofecha = 1;
							}else{
									$estadofecha = 0;

							}
			?>
			</td  >
            <td class="colcenter">
			<?php 
				  if ($ctacteestado['ctacte_tipo_registros_id']==1 && $ctacteestado->importe == $totaltarjetacredito)
							echo 'Tarjetas de Crédito';
					  else
						    if ($ctacteestado->signo==0 && $ctacteestado->ctacte_tipo_registros_id==4)
							{ if ($ctacteestado['detalle_nc_nd']==null)
								echo 'Nota de Débito';
								else
								echo 'ND - '.ucfirst(strtolower($ctacteestado['detalle_nc_nd']));
							}	
							else
									if ($ctacteestado->ctacte_tipo_registros_id==1 && $ctacteestado->signo==0)
									echo 'SALDO';
									else
									echo $tiporegistros[$ctacteestado['ctacte_tipo_registros_id']]; 
									if($tiporegistros[$ctacteestado['ctacte_tipo_registros_id']] =="Medicamentos" && $total > 0  &&  $estadofecha > 0 ){
										$contadordeudor++;
									  }
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

			if ($ctacteestado->fecha_vencimiento > $fech || $total<0)
			echo '<td class=colprecio3>$  '.number_format($total,2,',','.').'</td>'; 
			else
			echo '<td class=colprecio3 style="color:red">$  '.number_format($total,2,',','.').'</td>'; 
			?>
        </tr>
    <?php endforeach; $indice+=2;?>
	
	<?php /*
		if($contadordeudor >= 2 ){
			echo"<script>alert('¡Hola!\\nEn 24hs actualizaremos el saldo deudor de tu cuenta. Cualquier inquietud, podés comunicarte con tu ejecutivo. \\n\\nGracias por tu atención. ');</script>";
		}*/
 ?>
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