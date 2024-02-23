<div class="articulos index large-10 medium-9 columns">

    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			
			<th><?= $this->Paginator->sort('fecha','Fecha') ?></th>
			<th><?= $this->Paginator->sort('pedido_ds','Nº Ped. DS') ?></th>
			<th><?= $this->Paginator->sort('codigo_barra','EAN') ?></th>
            <th><?= $this->Paginator->sort('descripcion') ?></th>
           
            
            <th><?= $this->Paginator->sort('cant.') ?></th>
            <th><?= $this->Paginator->sort('precio_unitario' ,'PU') ?></th>
            <th><?= $this->Paginator->sort('precio_publico','PP') ?></th>
			<th><?= $this->Paginator->sort('precio_total','P.Total') ?></th>
			
			<th></th>
        </tr>
		  
    </thead>
    <tbody>
   <?php $indice=0;?>
	 
    <?php foreach ($resultados as $facturasCuerposItem): ?>
        <?php $indice+=1;?>
		<tr>
		<td><?php echo date_format($facturasCuerposItem['facturas_cabecera']['fecha'],'d-m-Y');?></td>
		   
			 <td class="colcenter"><?= $this->Number->format($facturasCuerposItem['pedido_ds']) ?></td>
            
			<td><?= $facturasCuerposItem['codigo_barra']; ?></td>
            <td><?= $facturasCuerposItem['descripcion']; ?></td>
            <td class='colcenter'><?= $this->Number->format($facturasCuerposItem['cantidad_facturada']) ?></td>
            <td class='colprecio'><?php	echo '$ '.number_format($facturasCuerposItem['precio_unitario'],2,',','.');  ?>
			</td>
            <td class='colprecio'>
			<?php	echo '$ '.number_format($facturasCuerposItem['precio_publico'],2,',','.');  ?>
			</td>
			<td class='colprecio'>
			<?php	echo '$ '.number_format($facturasCuerposItem['precio_total'],2,',','.');  ?>
			</td>
	
            
        </tr>
	<?php endforeach; $indice+=2; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
			<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Pedidos') ?> </span></div>
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
		$(this).css("color","");
		$(this).css("font-weight","");
	  }
	);
	
	$("tr#info").click(function() {        // function_tr
		
	});
</script>