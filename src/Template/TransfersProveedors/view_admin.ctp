<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_4_quarter">

		<header><h3 class="tabs_involved" id="titulobarra"><?= $titulo ?></h3>
		<div style="float: right; padding-top:2px"><?php echo $this->Html->image('admin/icon_transfer_proveedor.png',["alt" => "Transfer",'url' =>['controller' => 'TransfersProveedors', 'action' => 'index_admin']]);    ?></div>
<div class="volveratras"><a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a></div>
		
		
		</header>
		<div id="buttonprint">
			<a class="print-preview">Imprimir</a>
		</div>
	
	<div class="tab_container">
		<div id="tab1" class="tab_content">

<div class="pedidos view large-10 medium-9 columns">
    <div class="row">
        <div class="large-5 columns strings">
		<table>
		<tr> 
			<td > <?= __('Cliente') ?> </td>
			<td class="pedidotd" cols="5">
				<?= $pedido->has('cliente') ? '('.$pedido->cliente->codigo.')'.$pedido->cliente->razon_social : '' ?>
			</td>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> </td>
			
		</tr>
		<tr>
			<td> <?= __('Enviado') ?> </td>
			<td class="pedidotd">
				<?php 	echo date_format($pedido['creado'],'d-m-Y H:i:s');	?>
			</td>
			<td> <?= __('N° de Pedido') ?></td>
			<td class="pedidotd">
				<?= $this->Number->format($pedido->id) ?>
			</td>
			<td> <?= __('Tipo Factura') ?></td>
			<td class="pedidotd">
				<?= h($pedido->tipo_fact) ?>
			</td>
			<td> <?= __('Transfer') ?></td>
			<td class="pedidotd">
				<?= h($pedido->transfer) ?>
			</td>
			<td> <?= __('Comentario') ?></td>
			<td class="pedidotd">
				<?= h($pedido->comentario) ?>
			</td>
			
		</tr> 
		</table>
        </div>
    </div>
</div>
</br>
 
<div class="pedidosItems index large-10 medium-9 columns">
    <table class="tablesorter" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('agregado') ?></th>
            <th>Troquel</th>
            <th><?= $this->Paginator->sort('articulo_id','Descripción') ?></th>
			<?php if ($pedido->tipo_fact!="N")
			{
			echo '<th class="columna_descuento">Dtos</th>
				<th class="columna_descuento">U.Min.</th>
				<th class="columna_descuento">Plazo</th>';
				}
			?>

            
			<th class="columna_descuento"><?= $this->Paginator->sort('cantidad','Cant. Pedida') ?></th>
			
            <th class="columna_descuento"><?= $this->Paginator->sort('cantidad_facturada','Cant. Factura') ?></th>
			<th class="columna_descuento"><?= $this->Paginator->sort('nro_pedido_ds','Nro.pedido DS') ?></th>
			<th class="columna_descuento"><?= $this->Paginator->sort('pedidos_items_status_id','Detalle') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pedidosItems as $pedidosItem): ?>
        <tr>
            <td> <?= date_format($pedidosItem['agregado'],'d-m-Y');?>	</td>
			<td> <?= $pedidosItem->has('articulo') ? $pedidosItem->articulo->troquel : '' ?> </td>
            <td> <?= $pedidosItem->has('articulo') ? $pedidosItem->articulo->descripcion_pag : '' ?> </td>
			<?php if ($pedido->tipo_fact!="N")
			{
			echo '<td class="columna_descuento">'.$pedidosItem['descuento'].' %'.'</td>'.
				'<td class="columna_descuento">'.$pedidosItem['unidad_minima'].'</td>'.
				'<td class="columna_descuento">'.$pedidosItem['plazoley_dcto'].'</td>';
				
				}
			?>
			
			
            <td class="columna_descuento"> <?= $pedidosItem->cantidad; ?> </td>
            <td class="columna_descuento"> <?= $this->Number->format($pedidosItem->cantidad_facturada) ?> </td>
            <td  class="columna_descuento"> <?= $this->Number->format($pedidosItem->nro_pedido_ds) ?> </td>
            <td  class="columna_descuento"> <?php 
			 if (!is_null($pedidosItem->pedidos_items_status_id))
			 if ($pedidosItem->pedidos_items_status_id<15)
			 echo $itemstatus[$pedidosItem->pedidos_items_status_id]; 
			 else
			 echo $pedidosItem->pedidos_items_status_id; 
			 ?> </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
   		 <div class="pagination">
        <ul >
            <?php
						echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
						echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
						echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
					?>
        </ul>
		
        <div class="total">
		<?php
			echo $this->Paginator->counter('{{count}} Total');
		?>
		</div>
		</div>
</div>
		</div>
		</div>
		 
		</article><!-- end of content manager article -->
	<?php echo $this->Html->css('print',['media' => 'print']); ?>
    <script type="text/javascript">

  $(document).ready(function() {
	
	$('a.print-preview').click(function() {
	 
	 var strC = "Cliente N "; 
	 var strR = " - Pedido N ";
	 var strCN= <?= $pedido->has('cliente') ? '('.$pedido->cliente->codigo.')': ''?>;
	 var strCR= <?= $pedido->pedido_id ?>;
	   document.title  = strC.concat(strCN,strR,strCR); 
	   
	   document.getElementById("titulobarra").innerHTML = strC.concat(strCN,strR,strCR);
	 window.print();
	 return false;
	});
  /*
	$('a.print-preview').click(function() {
		
		
		$.ajax({
                type:"GET",
                url:"<?php echo $this->Url->build(['controller'=>'TransfersProveedors','action'=>'impreso', $pedido->id ]);?>",
                dataType: 'text',
                async:false,
                success: function(tab){

					  return true;
					
					
                },
                error: function (tab) {
                    alert('error');
                }
            });


	 
 
 
}); */

	$('a.print-marcar').click(function() {
		
		
		$.ajax({
                type:"GET",
                url:"<?php echo $this->Url->build(['controller'=>'TransfersProveedors','action'=>'impreso', $pedido->id ]);?>",
                dataType: 'text',
                async:false,
                success: function(tab){
					  return true;

                },
                error: function (tab) {
                    alert('error');
                }
            });
	 
 
 
}); 



  });

    </script>		
