<div class="articulos index large-10 medium-9 columns">
<table class='tablacompsearch' cellpadding="0" cellspacing="0">
<thead>
<tr>	
<th><?= $this->Paginator->sort('FECHA') ?></th>            
<th><?= $this->Paginator->sort('N° INTERNO') ?></th>          
<th><?= $this->Paginator->sort('comprobante_id','N° FACTURA') ?></th>
<th><?= $this->Paginator->sort('imp_exento','N. EXENTO') ?></th>
<th><?= $this->Paginator->sort('imp_gravado','N. GRABADO') ?></th>
<th><?= $this->Paginator->sort('imp_iva','I.V.A.') ?></th>
<th><?= $this->Paginator->sort('imp_ingreso_bruto','PERCEP.I.B.') ?></th>
<th><?= $this->Paginator->sort('TOTAL') ?></th>
<th>PDF</th>
<th class="actions"></th>
</tr>
</thead>
<tbody>
<?php $indice=0;?>
<?php foreach ($facturasCabeceras as $facturasCabecera): ?>
<tr>
<?php $indice+=1;?>
<td class="colcenter"><?php echo date_format($facturasCabecera['fecha'],'d-m-Y'); ?></td>
<td class="colcenter"><?= $this->Number->format($facturasCabecera['pedido_ds']) ?></td>
<td class="colcenter"><?php 
echo $facturasCabecera['letra'].' '.				
str_pad($facturasCabecera['comprobante']['seccion'] , 4, "0", STR_PAD_LEFT).'-'.
str_pad($facturasCabecera['comprobante']['numero']  	, 8, "0", STR_PAD_LEFT);
?>
</td>
<td class='colprecio'><?php echo '$ '.number_format($facturasCabecera['imp_exento'],2,',','.'); ?>	</td>
<td class='colprecio'><?php echo '$ '.number_format($facturasCabecera['imp_gravado'],2,',','.');?>	</td>
<td class='colprecio'><?php echo '$ '.number_format($facturasCabecera['imp_iva'],2,',','.'); 	?>	</td>
<td class='colprecio'><?php echo '$ '.number_format($facturasCabecera['imp_ingreso_bruto'],2,',','.'); ?> </td>
<td class='colprecio'><?php echo '$ '.number_format($facturasCabecera['total'],2,',','.'); ?>		</td>
<td class="colcenter">
<?php echo $this->Html->image('icon_down_pdf2.png',['title' => 'Descargar PDF','url'=>['controller'=>'Comprobantes','action' => 'downloadfile', $facturasCabecera['pedido_ds'], 1,date_format($facturasCabecera['fecha'],'Ymd')]]); ?>    
</td>
<td class="actions">
<?php 
if ($facturasCabecera['comprobante']['anulado']==1)  echo 'Anulada';
else
echo $this->Html->image("admin/icn_view.png", ["alt" => "Ver",'url' => ['controller' => 'facturas', 'action' => 'view',  $facturasCabecera['id']]]);


?>
<!-- ?=
$this->Html->image("admin/icn_view.png", array(
"alt" => "Ver",
'url' => array('controller' => 'facturas', 'action' => 'view',  $facturasCabecera['id'])
));? -->
</td>
</tr>
<?php endforeach; $indice+=1; ?>
</tbody>
</table>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>
</div>
</div>
<script type="text/javascript">
$("tr").not(':first').hover(
function () {
$(this).css("background","#8FA800");
$(this).css("color","#000");
$(this).css("font-weight","");
}, 
function () {
$(this).css("background","");
$(this).css("color","#464646");
$(this).css("font-weight","");
}
);
</script>