<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
			
			<span class='cliente_info_span'>Buscar Pedido</span>
			</br>
			<div class="row">
			<?php echo $this->element('searchpedido'); ?>
			
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->
					   
		<div class="product-content">
		<div class="row">             
			<div class="col-md-12 col-sm-12">
				
				<span class='cliente_info_span'>Carro de Compras</span>
				</br> 
				<?php echo $this->element('cartresum'); ?>	

				<div class="button-holder6">
				<?=	$this->Html->link('Vaciar',['controller' => 'Carritos', 'action' => 'vaciar'],['confirm' => 'Esta seguro de vaciar el carrito'])?>
			
				</div> <!-- /.button-holder -->
				<div class="button-holder3">
					<?= $this->Html->link(__('Enviar'), ['class'=>'red-btn','controller' => 'Carritos', 'action' => 'confirm']) ?>
				</div> <!-- /.button-holder -->
			</div> <!-- /.col-md-12 -->
		</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-9">
    <div class="product-item-3">
		<div class="product-content">
		
		<span class='cliente_info_span'>Pedidos Realizados</span>
		</br>
			<?php
				echo $this->element('searchresultpedido'); 
			?> 
		</div> <!-- /.product-content -->
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->

<?php

//"510033-1";"MAXIOSTENIL JGA.PRELL.X 2 ML  ";"1";" ";"7795371458712";"TRB-PHARMA S.A.     ";0;0;803.76;"S";803.76;8877;f;f;f;3993;f;f;"S"?>