<?php if (!empty($users)): ?>
<span class='cliente_info_span'>Listado Usuarios</span>
<table class='tablasearch' cellpadding="0" cellspacing="0">
<tr>
<th><?= __('Nombre Usuario') ?></th>
<th><?= __('Role') ?></th>     
<th><?= __('Creado') ?></th>
<th><?= __('Modificado') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
<?php $perfiles = $perfiles->toArray(); ?>
<?php foreach ($users as $user): ?>
<tr>	
<td class=user_list_col_name><?= h($user->username) ?></td>
<td class=user_list_col_date><?= h($perfiles[$user->perfile_id]);?>
</td>
<td class=user_list_col_date><?php 
if (!is_null($user->created)) echo date_format($user->created,'d-m-Y H:i:s'); ?></td>
<td class=user_list_col_date><?php 
if (!is_null($user->modified)) echo date_format($user->modified,'d-m-Y H:i:s'); ?></td>
<td class="actions">
<!--?=
$this->Html->image("admin/icn_edit.png", array(
"alt" => "Editar",
'url' => array('controller' => 'Users', 'action' => 'edit',  $user->id)
));
? -->
<?php 
echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
array("alt" => __('Eliminar'), "title" => __('Eliminar'))), 
array('controller'=>'Users','action' => 'delete', $user->id), 
array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $user->id))
);
?>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>