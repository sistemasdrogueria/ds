<div class="col-md-9">
                    <div class="product-item-3">
                        <div class="product-thumb">
                         <?php echo $this->element('search'); ?>
                        </div> <!-- /.product-thumb -->
                        
						<div class="product-content">
                        <?php echo $this->element('searchresult'); ?>
                        </div> <!-- /.product-content -->
                    </div> <!-- /.product-item -->

</div> <!-- /.col-md-3 -->

<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
			<div class="row">
			
			<div class="carrito_resumen">
				<table cellpadding="0" cellspacing="0" > 
				<tr>
					<td class="carrito_descripcion">
						<div>
						SALDO  
						</div> <!-- /.col-md-6 -->
					</td>
					<td class="carrito_importe"> 
						<div >
							$ 5.000,50  
						</div> <!-- /.col-md-6 -->
					</td>
				</tr>
				<tr>
					<td class="carrito_descripcion">
						<div>
						Importe Total  
						</div> <!-- /.col-md-6 -->
					</td>
					<td class="carrito_importe">
						$ 1.000,10
					</td>
				</tr>
				<tr>
					<td class="carrito_descripcion">
						<div>
						Items/Unid Total 
						</div> <!-- /.col-md-6 -->
					</td>
					<td class="carrito_importe">
						<div>
						5/20
						</div>
					</td>
				</tr>

				</table>
			</div>
			<div class="col-md-12 col-sm-12">
				<div class="button-holder">
					<a href="#" class="red-btn"><i class="fa fa-angle-down"></i></a>
				</div> <!-- /.button-holder -->
				<div class="button-holder">
					<a href="#" class="red-btn">Enviar</a>
				</div> <!-- /.button-holder -->
			</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->
					   
		<div class="product-content">
		<div class="row">             
		<div class="carrito_items">
		<table cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th class="carrito_item_descripcion"><?= $this->Paginator->sort('articulo_id','Descripción') ?></th>
				<th class="carrito_item_cantidad"><?= $this->Paginator->sort('cantidad', 'Cant.') ?></th>
				<th class="actions"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($carritosc as $carrito): ?>
				<tr>
					<td class="carrito_item_descripcion">
						<?= $carrito->articulos->descripcion; ?>
					</td>  
					<td class="carrito_item_cantidad">
						<?= $carrito->cantidad ?>
					</td>
					<td class="actions">
						<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $carrito->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carrito->id)]) ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
		</div>
		<div class="paginator">
			<ul class="pagination">
			
			
				<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
			    
				<?= $this->Paginator->next(__('Siguiente') . ' >') ?>
			</ul>
		</div>
		</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->