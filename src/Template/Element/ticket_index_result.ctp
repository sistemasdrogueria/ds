<div class="reclamos index large-10 medium-9 columns">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>
<th><?= $this->Paginator->sort('id','N°') ?></th>
<th><?= $this->Paginator->sort('factura_numero','Número Factura') ?></th>
<th><?= $this->Paginator->sort('fecha_recepcion', 'Fecha Factura') ?></th>
<th><?= $this->Paginator->sort('reclamos_tipo_id', 'Motivo') ?></th>
<th><?= $this->Paginator->sort('estado_id','Estado') ?></th>
<th><?= $this->Paginator->sort('creado', 'Creado') ?></th>
<th></th>
</tr>
</thead>
<tbody>
<?php foreach ($reclamos as $reclamo): ?>
<tr>
<td class="colcenter"><?= $this->Number->format($reclamo['id']) ?></td>
<td class="colcenter"><?php echo str_pad($reclamo['factura_seccion'], 4, '0', STR_PAD_LEFT).'-'.str_pad($reclamo['factura_numero'], 8, '0', STR_PAD_LEFT);?></td>
<td class="colcenter"> <?php echo date_format($reclamo['fecha_recepcion'],'d-m-Y'); ?>	</td>
<td class="colcenter"><?php echo $reclamo['reclamos_tipo']['nombre']; ?> </td>
<td> 
<?= $reclamo['reclamos_estado']['nombre'] ?></td>
<td class="colcenter">
<?php 
echo date_format($reclamo['creado'],'d-m-Y H:i:s');
?>	
</td>
<td class="actions">
<?php 
echo $this->Html->image("admin/icn_view.png", [
    "alt" => "view",
    'url' => ['controller' => 'Tickets', 'action' => 'view',  $reclamo['id']]
]);
//$this->Html->link($this->Html->image('admin/icn_view.png', ['alt' => 'view']), ['action' => 'view', $reclamo['id']]) 

echo $this->Html->image("pdf.png", [
    "alt" => "pdf",
    'url' => ['controller' => 'Tickets', 'action' => 'ticketpdf',  $reclamo['id'],'_ext' => 'pdf','_full'=>true]
]);
//$this->Html->link($this->Html->image('pdf.png', ['alt' => 'pdf']), ['action' => 'reclamopdf', $reclamo['id'],'_ext' => 'pdf','_full'=>true]) 
?>


<?php //$this->Form->postLink(__('Delete'), ['action' => 'delete', $reclamo['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamo['id'])]) ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<script>
$('table.tablasearch').each(function() {
var currentPage = 0;
var numPerPage = 8;
var $table = $(this);
$table.bind('repaginate', function() {
$table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
});
$table.trigger('repaginate');
var numRows = $table.find('tbody tr').length;
var numPages = Math.ceil(numRows / numPerPage);
var $pager = $('<div class="page_cart"></div>');
for (var page = 0; page < numPages; page++) {
$('<div class="page-number"></div>').text(page + 1).bind('click', {
newPage: page
}, function(event) {
currentPage = event.data['newPage'];
$table.trigger('repaginate');
$(this).addClass('active').siblings().removeClass('active');
}).appendTo($pager).addClass('clickable');
}
$pager.insertAfter($table).find('div.page-number:first').addClass('active');
});
</script>