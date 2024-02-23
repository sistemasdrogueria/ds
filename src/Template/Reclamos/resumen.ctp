<div class="col-md-4">
    <div class="product-item-3"> 
		<div class="product-content">
		<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="cliente_info">
			<span class='cliente_info_span'>Vista del Reclamo</span>
			</br>
				<table cellpadding="0" cellspacing="0">
				<tr> 
					<td><?= __('Reclamo Número') ?></td>
					<td><?= $this->Number->format($reclamo->id) ?></td>
				</tr>	
				<tr>
					<td><?= __('Pedido Número') ?></td>
					<td><?= $this->Number->format($reclamo->factura_numero) ?></td>
				</tr>
				<tr>
					<td><?= __('Pedido Fecha') ?></td>
					<td><?php echo date_format($reclamo['fecha_recepcion'],'d-m-Y'); ?></td>
				</tr>
				<tr>
					<td><?= __('Motivo Reclamo') ?></td>
					<td><?= $reclamo->has('reclamos_tipo') ? h($reclamo->reclamos_tipo->nombre) : '' ?></td>
				</tr>
				<tr>	
					<td><?= __('Estado') ?></td>
					<td><?= $reclamo->has('estado') ? $this->Html->link($reclamo->estado->id, ['controller' => 'Estados', 'action' => 'view', $reclamo->estado->id]) : '' ?></td>
				</tr>
				<tr>
					<td><?= __('Observaciones') ?></td>
					<td><?= h($reclamo->observaciones) ?></td>
				</tr>
				</table>   
			</br>				
		</div>
		</div>
		</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-8">
    <div class="product-item-3">                    
		<div class="product-content">
		<span class='cliente_info_span'>Productos del reclamo</span>		
		</br>		
            <?php 
				if ($reclamositemstemps!=null )
					echo $this->element('reclamosearchitemtempresult');
			?>
		</br>
        </div> <!-- /.product-content -->
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->