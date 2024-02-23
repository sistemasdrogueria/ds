<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
</header>
<div class="tab_container">
<div id="tab1" class="tab_content">
<table class="tablesorter" cellpadding="0" cellspacing="0">
<thead>
<tr>

<th class="header"><?= $this->Paginator->sort('id') ?></th>
<th class="header"><?= $this->Paginator->sort('transfer_files_laboratorio_id',"Proveedor") ?></th>
<th class="header"><?= $this->Paginator->sort('proveedor_id','Proveedor') ?></th>
<th class="header"><?= $this->Paginator->sort('importado') ?></th>
<th class="header"><?= $this->Paginator->sort('procesado') ?></th>
<th class="header"><?= $this->Paginator->sort('carro') ?></th>
<th class="header"><?= $this->Paginator->sort('pedido') ?></th> 
<th class="header"><?= $this->Paginator->sort('enviado') ?></th>
<th class="header"><?= $this->Paginator->sort('estado') ?></th>
<th class="header" class="actions"></th>
</tr>
</thead>
<tbody>
<?php foreach ($transfersImports as $transfersImport): ?>
<tr>

<td><?= $this->Number->format($transfersImport->id) ?></td>
<td><?php echo $transfersImport->transfers_files_laboratorio['nombre_laboratorio']; ?></td>

<td><?php echo  $transfersImport->proveedor['razon_social']; ?></td>

<td><?= h($transfersImport->importado) ?></td>
<td><?= h($transfersImport->procesado) ?></td>
<td><?= h($transfersImport->en_carro) ?></td>
<td><?= h($transfersImport->en_pedido) ?></td>
<td><?= h($transfersImport->facturado) ?></td>
<td><?= $this->Number->format($transfersImport->estado) ?></td>
<td class="actions">
<?php 
if (is_null($transfersImport->procesado))
        $imagen_control = "admin/icon_controlar.png";
        else
        $imagen_control = "admin/icon_controlar_ok.png";
    echo $this->Html->image($imagen_control,[ "alt" => "Edit",'url' =>['controller' => 'TransfersProveedors', 'action' => 'controlar_admin',  $transfersImport->id]]);
if (is_null($transfersImport->en_carro))
        $imagen_carro = "admin/icon_pasar_carrito.png";
        else
        $imagen_carro = "admin/icon_pasar_carrito_ok.png";
    echo $this->Html->image($imagen_carro,["alt" => "Edit",'url' =>['controller' => 'TransfersProveedors', 'action' => 'pasarcarrito_admin',  $transfersImport->id]]);

if (is_null($transfersImport->en_pedido))
        $imagen_pedido = "admin/icon_pasar_pedido.png";
        else
        $imagen_pedido = "admin/icon_pasar_pedido_ok.png";
    echo $this->Html->image("admin/icon_pasar_pedido.png",["alt" => "Edit",'url' =>['controller' => 'TransfersProveedors', 'action' => 'confirmcarrito_admin',  $transfersImport->id]]);
  
    echo $this->Html->image('admin/icon_import_info.png',[ "alt" => "Edit",'url' =>['controller' => 'TransfersProveedors', 'action' => 'import_result_admin',  $transfersImport->id]]);?>
<?= $this->Form->postLink($this->Html->image('admin/icon_borrar_registro.png',["alt" => __('Delete'), "title" => __('Delete')]), ['action' => 'delete_import_admin', $transfersImport->id],['escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $transfersImport->id)]);?>


</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div><!-- end of .tab_container -->
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->first('<< ' . __('first')) ?>
<?= $this->Paginator->prev('< ' . __('previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('next') . ' >') ?>
<?= $this->Paginator->last(__('last') . ' >>') ?>
</ul>
</div>
</div>
</article><!-- end of content manager article -->	
