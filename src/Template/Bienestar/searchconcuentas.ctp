<?php echo $this->element('metodos_de_pago'); ?>
<div class="col-md-9">
                    <div class="product-item-3">
                        <div class="product-thumb">
                         <?php echo $this->element('nutricion_search');?>
                        </div> <!-- /.product-thumb -->
                        
						<div class="product-content">
                        <?php if (!is_null($articulos) )
							
						{
							
							
							echo $this->element('carrito_search_result',['articulos'=>$articulos,'laboratorios'=>$laboratorios,'categorias'=>$categorias]); 
						}
						else
						{echo $this->element('carrito_search_sinresult'); }
						?>
                        </div> <!-- /.product-content -->
						<div class="product-content">
                        <?php echo $this->element('referencia'); ?>
						
                        </div> <!-- /.product-content -->
                    </div> <!-- /.product-item -->

</div> <!-- /.col-md-3 -->


<div class="col-md-3">

<?php echo $this->element('carro'); ?>
</div> <!-- /.row -->
