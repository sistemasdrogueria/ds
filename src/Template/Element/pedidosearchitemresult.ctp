<div class="articulos index large-10 medium-9 columns">
    <table class="tablasearch" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            
            <th>Troquel</th>
            <th><?= $this->Paginator->sort('articulo_id','Descripción') ?></th>
            <th><?= $this->Paginator->sort('cantidad','Cant. Pedida') ?></th>
            <th><?= $this->Paginator->sort('cantidad_facturada','Cant. Factura') ?></th>
			<th><?= $this->Paginator->sort('nro_pedido_ds','Nro. ped. DS') ?></th>
			<th><?= $this->Paginator->sort('agregado') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pedidosItems as $pedidosItem): ?>
        <tr>
            
			<td  class="colcenter"> <?= $pedidosItem->has('articulo') ? $pedidosItem->articulo->troquel : '' ?> </td>
            <td> <?= $pedidosItem->has('articulo') ? $pedidosItem->articulo->descripcion_pag : '' ?> </td>
            <td  class="colcenter"> <?= $pedidosItem->cantidad; ?> </td>
            <td  class="colcenter"> <?= $this->Number->format($pedidosItem->cantidad_facturada) ?> </td>
            <td  class="colcenter"> <?= $this->Number->format($pedidosItem->nro_pedido_ds) ?> </td>
            <td  class="colcenter"> <?= date_format($pedidosItem['agregado'],'d-m-Y H:i:s');?>	</td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
   		 

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
			<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Items') ?> </span></div>
        </ul>
    </div>
</div>
<script type="text/javascript">
	$(".tablasearch tr").not(':first').hover(
	function () {
		$(this).css("background","#8FA800");
		$(this).css("color","#000");
		$(this).css("font-weight","");
	  }, 
	function () {
		$(this).css("background","");
		$(this).css("color","");
		$(this).css("font-weight","");
	  }
	);
	
	$("tr#info").click(function() {        // function_tr
		
	});
</script>
