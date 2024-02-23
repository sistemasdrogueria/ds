<div class="col-md-12">
                    <div class="product-item-3">
                       
						<div class="product-content">
						<div class='cliente_info_class2'>Productos Nuevos</div>
						</br>
                        <?php if ($articulos!=null )
						{echo $this->element('carrito_search_result'); }
						else
						{echo $this->element('searchsinresult'); }
						?>
                        </div> <!-- /.product-content -->
						<div class="product-content">
                        <?php 
							echo $this->element('referencia'); 
						?>
						
                        </div> <!-- /.product-content -->
                    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->


	
</div> <!-- /.col-md-4 -->

<?php 
	echo $this->Html->script('paginacion');
	?>
    <script>

window.onload= paginacionNuevos();


	</script>