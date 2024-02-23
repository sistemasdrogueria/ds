<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
			
			<span class='cliente_info_span'>Buscar Producto Facturado</span>
			</br>
			<div class="row">
			<?php echo $this->element('searchpedidoproduct'); ?>
			
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-9">
    <div class="product-item-3">
		<div class="product-content">
		
		<span class='cliente_info_span'>Items Facturados</span>
		</br>
			<?php
				echo $this->element('searchresultproductpedido'); 
			?> 
		</div> <!-- /.product-content -->
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->

<?php

//"510033-1";"MAXIOSTENIL JGA.PRELL.X 2 ML  ";"1";" ";"7795371458712";"TRB-PHARMA S.A.     ";0;0;803.76;"S";803.76;8877;f;f;f;3993;f;f;"S"?>