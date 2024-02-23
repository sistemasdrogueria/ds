<div class="col-md-9">
                    <div class="product-item-3">
                        <div class="product-thumb">
                         <?php echo $this->element('searchimport'); ?>
                        </div> <!-- /.product-thumb -->
                        
						<div class="product-content">
                        <?php if ($articulos!=null )
						{echo $this->element('searchresult'); }
						else
						{echo $this->element('searchsinresult'); }
						?>
                        </div> <!-- /.product-content -->
                    </div> <!-- /.product-item -->

</div> <!-- /.col-md-3 -->

<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
			<div class="row">
			<?php echo $this->element('cartresum'); ?>
			<div class="col-md-12 col-sm-12">
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
			</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->
					   
		<div class="product-content">
		<div class="row">             
			<?php echo $this->element('cartresult'); ?>
		</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->