<style>
.tablesorter {width: 100%;margin: -5px 0 0 0;}
.tablesorter td{padding-left: 5px; border-right: 2px solid #ccc !important;}
.header{text-align: center; }
.tdfecha {text-align: center; }
</style>
<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="tabs_bt_nuevo">
<?= $this->Html->image("admin/icon_ingreso_falta.png", ["alt" => "Nuevo",'url' => ['controller' => 'TransfersProveedors', 'action' => 'ingresos_admin']	]);?>
<?= $this->Html->image("admin/icn-nuevo.png", ["alt" => "Nuevo",'url' => ['controller' => 'TransfersProveedors', 'action' => 'import_admin']	]);?>

</div>
</header>
<div class="tab_container">
<?php echo $this->element('transfer_proveedor_search_admin'); ?>        
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
<th class="header" class="actions">Procesar</th>
<th class="header" class="actions"></th>
<th class="header" class="actions"></th>
<th class="header" class="actions"></th>
</tr>
</thead>
<tbody>
<?php foreach ($transfersImports as $transfersImport): ?>
<tr>
<td><?= $this->Number->format($transfersImport->id) ?></td>
<td><?php echo $transfersImport->transfers_files_laboratorio['nombre_laboratorio']; ?></td>
<td><?php echo  $transfersImport->proveedor['razon_social']; ?></td>
<td class=tdfecha><?= h($transfersImport->importado) ?></td>
<td class=tdfecha><?= h($transfersImport->procesado) ?></td>
<td class=tdfecha><?= h($transfersImport->en_carro) ?></td>
<td class=tdfecha><?= h($transfersImport->en_pedido) ?></td>
<td class=tdfecha><?= h($transfersImport->facturado) ?></td>
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
echo $this->Html->image($imagen_pedido,["alt" => "Edit",'url' =>['controller' => 'TransfersProveedors', 'action' => 'confirmcarrito_admin',  $transfersImport->id]]);

if (is_null($transfersImport->facturado))
        $imagen_fact= "admin/icon_pasar_a_facturar.png";
        else
        $imagen_fact = "admin/icon_pasar_a_facturar_ok.png";
echo $this->Html->image($imagen_fact,["alt" => "Edit",'url' =>['controller' => 'TransfersProveedors', 'action' => 'pasarpedido_admin',  $transfersImport->id]]);

if (is_null($transfersImport->sincronizar_estado))
        $imagen_sincr = "admin/icon_sincronizar.png";
        else
        $imagen_sincr = "admin/icon_sincronizar_ok.png";
echo $this->Html->image($imagen_sincr,["alt" => "Edit",'url' =>['controller' => 'TransfersProveedors', 'action' => 'sincronizarestado_admin',  $transfersImport->id]]);
?>
</td>
<td  class="actions">
<?php
echo $this->Html->image('admin/icon_import_info.png',[ "alt" => "import result",'url' =>['controller' => 'TransfersProveedors', 'action' => 'import_result_admin',  $transfersImport->id]]);
if (is_null($transfersImport->en_pedido) && !is_null($transfersImport->en_carro))
echo $this->Html->image('admin/icon_carrito_info.png',["alt" => "view carrito",'url' =>['controller' => 'TransfersProveedors', 'action' => 'carrito_admin',  $transfersImport->id]]);
if (!is_null($transfersImport->en_pedido))
echo $this->Html->image('admin/icon_pedido_info.png',["alt" => "view pedido",'url' =>['controller' => 'TransfersProveedors', 'action' => 'pedidos_admin',  $transfersImport->id]]);

if (!is_null($transfersImport->en_pedido))
echo $this->Html->image('admin/icon_pedido_all_info.png',["alt" => "view pedidos",'url' =>['controller' => 'TransfersProveedors', 'action' => 'pedidos_all_admin',  $transfersImport->id]]);
?>
</td>

<td>
<?php 
if ($transfersImport->estado >0 && $transfersImport->estado!=27 && $transfersImport->estado!=25)
{
        if ($transfersImport->estado==5)
        echo $this->Html->image('admin/icon_limite_ver.png',["alt" => "Faltas",'url' =>['controller' => 'TransfersProveedors', 'action' => 'faltas_admin',  $transfersImport->id]]);
        if ($transfersImport->estado==7 || $transfersImport->estado==11) 
        echo $this->Html->image('admin/icon_faltas_ver.png',["alt" => "Faltas",'url' =>['controller' => 'TransfersProveedors', 'action' => 'faltas_admin',  $transfersImport->id]]);
        if ($transfersImport->estado==57) 
        echo $this->Html->image('admin/icon_faltas_limite_ver.png',["alt" => "Faltas",'url' =>['controller' => 'TransfersProveedors', 'action' => 'faltas_admin',  $transfersImport->id]]);      
        if ($transfersImport->estado==1) 
        echo $this->Html->image('admin/icon_habilitado_ver.png',["alt" => "Faltas",'url' =>['controller' => 'TransfersProveedors', 'action' => 'faltas_admin',  $transfersImport->id]]);
        if ($transfersImport->estado==51) 
        echo $this->Html->image('admin/icon_habilitado_falta_ver.png',["alt" => "Faltas",'url' =>['controller' => 'TransfersProveedors', 'action' => 'faltas_admin',  $transfersImport->id]]);

}
else
echo $this->Html->image('admin/icon_faltas_ok.png',["alt" => "Faltas",'url' =>['controller' => 'TransfersProveedors', 'action' => 'faltas_admin',  $transfersImport->id]]);


//echo $this->Html->image('admin/icon_faltas_limite_ver.png',["alt" => "Faltas",'url' =>['controller' => 'TransfersProveedors', 'action' => 'faltas_admin',  $transfersImport->id]]);
//echo $this->Html->image('admin/icon_limite_ver.png',["alt" => "Faltas",'url' =>['controller' => 'TransfersProveedors', 'action' => 'faltas_admin',  $transfersImport->id]]);
?>
</td>
<td>
<?php
echo $this->Form->postLink($this->Html->image('admin/icon_delete_registro.png',["alt" => __('Delete'), "title" => __('Delete')]), ['action' => 'delete_import_admin', $transfersImport->id],['escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $transfersImport->id)]);?>
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
