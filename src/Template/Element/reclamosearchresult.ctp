<div class="reclamos index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id','N° Reclamo') ?></th>
            <th><?= $this->Paginator->sort('factura_numero','Número Pedido') ?></th>
            <th><?= $this->Paginator->sort('reclamos_tipo_id', 'Motivo Reclamo') ?></th>
			
			<th><?= $this->Paginator->sort('fecha_recepcion', 'Fecha Pedido') ?></th>
			<th><?= $this->Paginator->sort('estado_id','Estado') ?></th>
			<th><?= $this->Paginator->sort('creado', 'Creado') ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
	
    <?php foreach ($reclamos as $reclamo): ?>
        <tr>
            <td class="colcenter"><?= $this->Number->format($reclamo['id']) ?></td>
            <td class="colcenter"><?= $this->Number->format($reclamo['factura_numero']) ?></td>
            <td class="colcenter"><?php 
			if ($reclamostipos2 != null)
				echo $reclamostipos2[$reclamo['reclamos_tipo_id']-1]['nombre']; 
				else 
					echo $reclamo->has('reclamos_tipo') ? h($reclamo->reclamos_tipo->nombre) : '';
			?> 
			</td>
			<td class="colcenter">
			<?php 
					echo date_format($reclamo['fecha_recepcion'],'d-m-Y');
				?>	
			</td>
			<td> 
			<?= $reclamo['reclamos_estado']['nombre'] ?></td>
			<td class="colcenter">
			<?php 
					echo date_format($reclamo['creado'],'d-m-Y H:i:s');
				?>	
			</td>
            <td class="actions">
                <?= $this->Html->link(__('Ver'), ['action' => 'view', $reclamo['id']]) ?>
                
                <?php //$this->Form->postLink(__('Delete'), ['action' => 'delete', $reclamo['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamo['id'])]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
   
</div>

<script>
		$('table.tablasearch').each(function() {
			var currentPage = 0;
			var numPerPage = 8;
			var $table = $(this);
			$table.bind('repaginate', function() {
				$table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
			});
			$table.trigger('repaginate');
			var numRows = $table.find('tbody tr').length;
			var numPages = Math.ceil(numRows / numPerPage);
	        var $pager = $('<div class="page_cart"></div>');
			for (var page = 0; page < numPages; page++) {
				$('<div class="page-number"></div>').text(page + 1).bind('click', {
				  newPage: page
				}, function(event) {
				  currentPage = event.data['newPage'];
				  $table.trigger('repaginate');
				  $(this).addClass('active').siblings().removeClass('active');
				}).appendTo($pager).addClass('clickable');
			}
			$pager.insertAfter($table).find('div.page-number:first').addClass('active');
		});
</script>