<div class="curriculums index large-10 medium-9 columns">
<table class='tablesorter' cellpadding="0" cellspacing="0">
<thead>
<tr>
<th><?= $this->Paginator->sort('id','N°') ?></th>
<th><?= $this->Paginator->sort('nombres','Nombre') ?></th>
<th><?= $this->Paginator->sort('apellidos', 'Apellido') ?></th>
<th><?= $this->Paginator->sort('documento', 'DNI') ?></th>
<th><?= $this->Paginator->sort('fecha_nacimiento', 'EDAD') ?></th>
<th><?= $this->Paginator->sort('ciudad_residencia', 'Residencia') ?></th>
<th><?= $this->Paginator->sort('ciudad_residencia_cp', 'CP') ?></th>

<th><?= $this->Paginator->sort('telefono_cod', 'Cod.Area') ?></th>
<th><?= $this->Paginator->sort('telefono', 'Telefono') ?></th>
<th><?= $this->Paginator->sort('sector_id', 'Area') ?></th>
<th><?= $this->Paginator->sort('creado', 'Enviado') ?></th>
<th>CV</th>
<th></th>
</tr>
</thead>
<tbody>
<?php function CalculaEdad( $fecha ) {
list($Y,$m,$d) = explode("-",date_format($fecha,'Y-m-d')); //echo $fecha.'/'.date("md").'/'.$m.$d;
return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}
?>	
<?php foreach ($curriculums as $curriculum): ?>
<tr>
<td class="colcenter"><?= $this->Number->format($curriculum['id']) ?></td>
<td class="colcenter"><?= h($curriculum['nombres']) ?></td>
<td class="colcenter"><?= h($curriculum['apellidos']) ?></td>
<td class="colcenter"><?= h($curriculum['documento']) ?></td>
<td class="colcenter"><?php echo CalculaEdad($curriculum['fecha_nacimiento']);?></td>
<td class="colcenter"><?= h($curriculum['ciudad_residencia']) ?></td>
<td class="colcenter"><?= h($curriculum['ciudad_residencia_cp']) ?></td>
<td class="colcenter"><?= h($curriculum['telefono_cod']) ?></td>
<td class="colcenter"><?= h($curriculum['telefono']) ?></td>		
<td class="colcenter"><?php echo $curriculum->has('sector') ? h($curriculum->sector->nombre) : '';	?> 	</td>
<td class="colcenter"><?php echo date_format($curriculum['creado'],'d-m-Y H:i:s');  ?>	</td>
<td>
<?php 
		echo $this->Html->link($this->Html->image('admin/icn_download.png',['title' => 'Descargar']),['controller' => 'Curriculums', 'action' => 'downloadfile',  $curriculum->archivo_cv,$curriculum->id],['escape' => false]);
		 ?>    
</td>
<td class="actions">
<?php
if ($curriculum['leido']==0)
						echo $this->Html->image("admin/noleido.png",["alt" => "No leido"]);
					else
						echo $this->Html->image("admin/leido.png",["alt" => "Leido"]);

 //$this->Html->image("admin/icn_edit.png", ["alt" => "Edit", 'url' => ['controller' => 'curriculums', 'action' => 'edit_admin',  $curriculum->id]]);
?>
<?=
$this->Html->image("admin/icn_view.png", ["alt" => "Ver",'url' => ['controller' => 'curriculums', 'action' => 'view_admin',  $curriculum->id] ]);?>
<?php 
echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
["alt" => __('Delete'), "title" => __('Delete')]), 
['action' => 'delete_admin', $curriculum->id], 
['escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $curriculum->id)]
);
?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>  
 <div class="pagination">
        <ul>
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
<script>
$('table.tablesorter2').each(function() {
var currentPage = 0;
var numPerPage = 30;
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