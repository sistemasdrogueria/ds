<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
			<div class="row">
			<h5>Buscar Pedido</h5>
			</br>
				<?php echo $this->element('searchpedido'); ?>
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->
					   
		<div class="product-content">
		<div class="row">
			<h5>Carro de Compras</h5>
			</br> 
			<?php echo $this->element('cartresum'); ?>			
			
				<div class="button-holder">
				<?=
				$this->Html->link(
				'Vaciar',
				['controller' => 'Carritos', 'action' => 'vaciar'],
				['confirm' => 'Esta seguro de vaciar el carrito']
				)
				?>
					
				</div> <!-- /.button-holder -->
				<div class="button-holder">
					<?= $this->Html->link(__('Enviar'), ['class'=>'red-btn','controller' => 'Carritos', 'action' => 'confirm']) ?>
				</div> <!-- /.button-holder -->
			
		</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->

<div class="col-md-9">
	<div class="product-item-3">
			
	<div class="product-content">
        <h5>Pedidos Realizados</h5>
        </br>                
		<?php
			echo $this->element('searchresultpedido'); 
		?> 
    </div> <!-- /.product-content -->
    </div> <!-- /.product-item -->

</div> <!-- /.col-md-3 -->