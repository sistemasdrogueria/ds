<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
			<h5>Ingrese Reclamo</h5>
			</br>
			<div class="row">
				<?php echo $this->element('reclamoheader'); ?>
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
				<h5>Resultado de la Busqueda</h5>
                <?php if ($articulos!=null )
						{
							echo $this->element('reclamosearchitemresult'); 
						}
						else
						{
							echo $this->element('reclamosearchitemnoresult'); 
						}	
				?>
            </div> 
			<div class="product-content2">
				<h5>Productos Agregados al reclamo</h5>
                <?php //if ($articulos!=null )
						//{echo $this->element('searchresult'); }
						//else
						//{
					echo $this->element('reclamosearchitemtempresult'); //}
				?>
            </div> 
			
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->