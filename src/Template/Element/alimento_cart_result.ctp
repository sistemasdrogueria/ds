<div class="carrito_items">
	<table cellpadding="0" cellspacing="0" class="carritos_items_tabla">
		<thead>
			<tr>
				<th class="carrito_item_descripcion_th">Descripción</th>
				<th class="carrito_item_cantidad_th">Cant.</th>
				<th class="actions"></th>
			</tr>
		</thead>
		<tbody>
			<?php $indice=13; ?>
			<?php foreach ($carritos as $carrito): ?>
				<?php
				if ($carrito['descuento']!=null)
					{
						if ($carrito['cantidad']<$carrito['unidad_minima'])
							{ echo '<tr class="carrito_item_sinoferta" title=" Dto: '.$carrito['descuento'].'% Uni. Min: '.$carrito['unidad_minima'].' T. Of.: '.$carrito['tipo_oferta'].'">';}
						else
							{ echo '<tr>'; }
					}
				else { echo '<tr>';	}
				?>
					<td class="carrito_item_descripcion" >
						<?= $carrito['descripcion']?>
					</td>  
						<?= $this->Form->create('carritos',['url'=>['controller'=>'Carritos','action'=>'edit']]); ?>
					<td class="carrito_item_cantidad">
						<?php
							$indice+=1;
							echo $this->Form->input('cantidad',['tabindex'=>$indice,'class'=>'formcarritocant','value'=>$carrito['cantidad']]);
							echo $this->Form->input('id',['type'=>'hidden','value'=>$carrito['id']]);
						?>
					</td>
						<?= $this->Form->end() ?>
					<td class="actions">
						<?=
							$this->Form->postLink(
								$this->Html->image('delete_ico.png'),
								array(
									'controller'=>'Carritos',
									'action' => 'delete',
									$carrito['id']
								),
								array('escape' => false),
								__('Esta seguro de quitar de carro # {0}?', $carrito['id'])
							);
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<script>
		$('table.carritos_items_tabla').each(function() {
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