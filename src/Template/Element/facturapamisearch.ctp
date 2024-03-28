<div class="articulos index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			<th><?= $this->Paginator->sort('fecha') ?></th>            
            <th><?= $this->Paginator->sort('pedido_ds') ?></th>          
            <th><?= $this->Paginator->sort('comprobante_id','F. Número') ?></th>
			<!-- th><?php //$this->Paginator->sort('imp_exento','N. Exento') ?></th-->
			<th>Detalle</th>
			<th>Cant Fact.</th>
			<th><?= $this->Paginator->sort('imp_gravado','N. Gravado') ?></th>
            <th><?= $this->Paginator->sort('imp_iva','I.V.A.') ?></th>
			<th><?= $this->Paginator->sort('imp_ingreso_bruto','Percp. I.B.') ?></th>
			<th><?= $this->Paginator->sort('total') ?></th>
            <th></th>
        </tr>
		   
    </thead>
    <tbody>

    <?php $indice=0;?>
	<?php foreach ($facturasCabeceras as $facturasCabecera): ?>
	 <?php foreach ($facturasCabecera['facturas_cuerpos_items'] as $items): ?>
        <tr>
		<?php $indice+=1;?>
			 <td class="colcenter"><?php 
				echo date_format($facturasCabecera['fecha'],'d-m-Y');
			 ?></td>
            <td class="colcenter"><?= $this->Number->format($facturasCabecera['pedido_ds']) ?></td>
            <td class="colcenter">
			   <?php 
			   
			    echo
					$facturasCabecera['letra'].' '.				
					str_pad($facturasCabecera['comprobante']['seccion'] , 4, "0", STR_PAD_LEFT).'-'.
			        str_pad($facturasCabecera['comprobante']['numero']  	, 8, "0", STR_PAD_LEFT);
                ?>
            </td>
			<td class="actions">
                <?php // $this->Html->link(__('View'), ['action' => 'view', $facturasCabecera['id']]) ?>
               <?php if ($items!=null)
					echo $items['descripcion'];
			 ?>
			</td>
			<td>
	 <?php if ($items!=null)
					echo $items['cantidad_facturada'];
			 ?>
			</td>
            <td class='colprecio'>
			<?php 
					echo '$ '.number_format($facturasCabecera['imp_gravado'],2,',','.'); 
				?>
			</td>
			<td class='colprecio'>
				<?php 
					echo '$ '.number_format($facturasCabecera['imp_iva'],2,',','.'); 
				?>
			</td>
			<td class='colprecio'>
			<?php 
					echo '$ '.number_format($facturasCabecera['imp_ingreso_bruto'],2,',','.'); 
			?>
			</td>
			<td class='colprecio'>
				<?php echo '$ '.number_format($facturasCabecera['total'],2,',','.'); ?>
			</td>
		
			<td>
			<?php echo $this->Html->image('pdf.png',['title' => 'Descargar PDF','url'=>['controller'=>'Comprobantes','action' => 'downloadfile', $facturasCabecera['comprobante']['nota'], $facturasCabecera['comprobante']['comprobante_tipo_id'],date_format($facturasCabecera['comprobante']['fecha'],'Ymd')]]); ?>    
					
			</td>
			
        </tr>
        <?php endforeach; ?>
    <?php endforeach; $indice+=2; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
			<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} items') ?> </span></div>
        </ul>
    </div>
</div>

  <script type="text/javascript">
	$("tr").not(':first').hover(
	function () {
		$(this).css("background","#8FA800");
		$(this).css("color","#000");
		$(this).css("font-weight","");
		}, 
	function () {
		$(this).css("background","");
		$(this).css("color","#464646");
		$(this).css("font-weight","");
		}
	);
</script>
            