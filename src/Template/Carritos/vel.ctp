<?php foreach ($novedades as $novedade): ?>
<div class="col-md-9">
                    <div class="product-item-3">
                        <div class="product-thumb">
                         <?php echo $this->element('search'); ?>
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
    <div class="product-item-5"> 
		<div class="product-content">
			<div class="row">
			<?php //echo $this->element('cartresum'); ?>
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div>
	<div class="product-item-5">	
		<div class="product-content">
		<div class='cliente_info_class2'>Carro de Compras</div>
		<div class="row">   
			<div class="col-md-12 col-sm-12">
				<div class="button-holder4">
					<?= $this->Html->link(__('Vaciar'), ['class'=>'red-btn','controller' => 'Carritos', 'action' => 'vaciar']) ?>
				</div> <!-- /.button-holder -->
				<div class="button-holder4">
					<?= $this->Html->link(__('Enviar'), ['class'=>'red-btn','controller' => 'Carritos', 'action' => 'confirm']) ?>
				</div> <!-- /.button-holder -->
			</div> <!-- /.col-md-12 -->	
			<div class="cartresul">			
			<?php //echo $this->element('cartresult'); ?>
			</div>
		</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->