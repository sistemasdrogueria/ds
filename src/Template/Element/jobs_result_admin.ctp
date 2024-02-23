<div class="jobs index large-10 medium-9 columns">
<table class='tablesorter' cellpadding="0" cellspacing="0">
<thead>
<tr>
<th><?= $this->Paginator->sort('id','N° Solicitud') ?></th>
<th><?= $this->Paginator->sort('titulo','Titulo') ?></th>
<th><?= $this->Paginator->sort('horario', 'horario') ?></th>
<th><?= $this->Paginator->sort('sector_id','Area') ?></th>
<th><?= $this->Paginator->sort('puesto_id','Puesto') ?></th>
<th><?= $this->Paginator->sort('cantidad_vacante','Cantidad') ?></th>
<th><?= $this->Paginator->sort('fecha', 'fecha') ?></th>
<th><?= $this->Paginator->sort('activo', 'activo') ?></th>
<th></th>
</tr>
</thead>
<tbody>
<?php foreach ($jobs as $job): ?>
<tr>
<td class="colcenter"><?= $this->Number->format($job['id']) ?></td>
<td class="colcenter"><?= h($job['titulo']) ?></td>
<td class="colcenter"><?= h($job['horario']) ?></td>
<td class="colcenter"><?php echo $job->has('sector') ? h($job->sector->nombre) : '';?> </td>
<td class="colcenter"><?php echo $job->has('puesto') ? h($job->puesto->nombre) : '';?> </td>
<td class="colcenter"><?= h($job['cantidad_vacante']) ?></td>
<td class="colcenter"><?php echo date_format($job['fecha'],'d-m-Y');?>	</td>
<td class="colcenter"><?= h($job['activo']) ?></td>
<td class="actions">
<?=
$this->Html->image("admin/icn_edit.png", array(
"alt" => "Edit",
'url' => array('controller' => 'jobs', 'action' => 'edit_admin',  $job->id)
));
?>
<?=
$this->Html->image("admin/icn_view.png", array(
"alt" => "Ver",
'url' => array('controller' => 'jobs', 'action' => 'view_admin',  $job->id)
));?>
<?php /*
echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
array("alt" => __('Delete'), "title" => __('Delete'))), 
array('action' => 'delete_admin', $job->id), 
array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $job->id))
) ;*/
?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>



</div>
<script>
$('table.tablesorter').each(function() {
var currentPage = 0;
var numPerPage = 50;
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