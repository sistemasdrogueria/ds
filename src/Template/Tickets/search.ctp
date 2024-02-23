<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
		<span class='cliente_info_span'>Buscar Reclamo</span>
			</br>
			<div class="row">
				<?php 
					echo $this->element('reclamosearch'); 
				?>
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-9">
    <div class="product-item-3">
                        
		<div class="product-content">
		<span class='cliente_info_span'>Reclamos Realizados - Resultado de la busqueda</span>
			
			</br>
            <?php 
				echo $this->element('reclamosearchresult'); 
			?>
        </div> <!-- /.product-content -->
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->