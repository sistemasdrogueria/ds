<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
		<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="cliente_info">
			<span class='cliente_info_span'>Vista del pedido</span>
			</br>
		<table cellpadding="0" cellspacing="0">
		<tr> 
			<td > <?= __('N° Cliente') ?> </td>
			<td class="pedidotd">
				<?= $pedido->has('cliente') ? '('.$pedido->cliente->codigo.')' : '' ?>
			</td>
		</tr>
		<tr> 
			<td > <?= __('Cliente') ?> </td>
			<td class="pedidotd">
				<?= $pedido->has('cliente') ? $pedido->cliente->razon_social : '' ?>
			</td>
		</tr>
		<tr>
			<td> <?= __('Enviado') ?> </td>
			<td class="pedidotd">
				<?php 	echo date_format($pedido['creado'],'d-m-Y H:i:s');	?>
			</td>
		</tr>
		<tr>	
			<td> <?= __('N° de Pedido') ?></td>
			<td class="pedidotd">
				<?= $this->Number->format($pedido->id) ?>
			</td>
		</tr>
		<tr> 
			<td> <?= __('Tipo Factura') ?></td>
			<td class="pedidotd">
				<?= h($pedido->tipo_fact) ?>
			</td>
		</tr> 
		</table>
			</br>				
		</div>
		
		<div class="button-holder">
				<a href="<?= $previous ?>">Volver atrás</a>
					
				</div> <!-- /.button-holder -->
		</div>
			
		</div> <!-- /.row -->
		
		
		
		
		
				
				
		
		
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-9">
    <div class="product-item-3">
                     
		<div class="product-content">

		<span class='cliente_info_span'>Productos del pedido</span>		
		</br>		
            <?php 
				if ($pedidosItems!=null )
					{
						echo $this->element('pedidosearchitemresult');
					}		
			?>
			</br>
        </div> <!-- /.product-content -->
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->