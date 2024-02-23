<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
			<span class='cliente_info_span'>Ingrese Reclamo</span>
			</br>
			<div class="row">
				<?php echo $this->element('reclamoheader2'); ?>
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-9">
    <div class="product-item-3">
            <div class="product-thumb">
                <?php echo $this->element('reclamosearchitem'); ?>
            </div> <!-- /.product-thumb -->
			<div class="product-content2">
				<span class='cliente_info_span'>Resultado de la Busqueda</span>
                <?php 
					if ($articulos!=null ) 
						{
							echo $this->element('reclamosearchitemresult'); } 
						else 
						{
							echo $this->element('reclamosearchitemnoresult'); 	}
				?>
            </div> 
			<div class="product-content2">
			<span class='cliente_info_span'>Productos Agregados al reclamo</span>
                <?php  
					if ($reclamositemstemps!=null )
						{
						echo $this->element('reclamosearchitemtempresult');
						}					
				?>
            </div> 
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->