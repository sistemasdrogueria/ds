<style>
.grupo_img{
    width: 150px;
  height: 75px;
  object-fit: contain;
}
</style>

<div>	
<div id="tab1" class="tab_content">
<table class="tablesorter"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('id','Imagen') ?></th>
<th><?= $this->Paginator->sort('id','Nro') ?></th>
<th><?= $this->Paginator->sort('nombre','Nombre') ?></th>
<th><?= $this->Paginator->sort('grupos_tipos_id','Tipo') ?></th>
<th><?= $this->Paginator->sort('orden','Orden') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>
<?php $indice=0; foreach ($grupos as $grupo): ?>
<tr>
<td>
<?php 
  if ($grupo['grupos_tipos_id']!=11 && $grupo['grupos_tipos_id']!=12)
  $uploadPath = 'grupos/';
else
  $uploadPath = 'logos/';

$filename = WWW_ROOT . 'img' . DS .$uploadPath.$grupo['imagen'] ;						
if (file_exists($filename))
echo $this->Html->image($uploadPath.$grupo['imagen'], ['alt' => str_replace('"', '','NO TIENE'),'class' => 'grupo_img']); ?> 
</td>
<td><?= $this->Number->format($grupo->id) ?></td>
<td><?= $grupo->nombre ?></td>
<td>
<?php echo $grupostipos[$grupo->grupos_tipos_id];?>
</td>
<td>
<?php echo $grupo->orden?>
</td>
<td class="actions">
<?=	$this->Html->image("admin/icn_edit.png", array( "alt" => "Edit",'url' => array('controller' => 'grupos', 'action' => 'edit_admin',  $grupo->id))); ?>
<?php 
echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
array("alt" => __('Delete'), "title" => __('Delete'))), 
array('action' => 'delete_admin', $grupo->id), 
array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $grupo->id))
);
?>
</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>


</div><!-- end of .tab_container -->
<div class="pagination">
<ul>
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));

?>
</ul>

<div class="total">
<?php echo $this->Paginator->counter('{{count}} Total'); ?>
</div>
</div>
</div>		