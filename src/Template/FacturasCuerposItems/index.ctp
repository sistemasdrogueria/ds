<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Facturas Cuerpos Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Facturas Cabeceras'), ['controller' => 'FacturasCabeceras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Facturas Cabecera'), ['controller' => 'FacturasCabeceras', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="facturasCuerposItems index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('facturas_encabezados_id') ?></th>
            <th><?= $this->Paginator->sort('pedido_ds') ?></th>
            <th><?= $this->Paginator->sort('iva') ?></th>
            <th><?= $this->Paginator->sort('cantidad_facturada') ?></th>
            <th><?= $this->Paginator->sort('precio_unitario') ?></th>
            <th><?= $this->Paginator->sort('precio_publico') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($facturasCuerposItems as $facturasCuerposItem): ?>
        <tr>
            <td><?= $this->Number->format($facturasCuerposItem->id) ?></td>
            <td>
                <?= $facturasCuerposItem->has('facturas_cabecera') ? $this->Html->link($facturasCuerposItem->facturas_cabecera->id, ['controller' => 'FacturasCabeceras', 'action' => 'view', $facturasCuerposItem->facturas_cabecera->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($facturasCuerposItem->pedido_ds) ?></td>
            <td><?= h($facturasCuerposItem->iva) ?></td>
            <td><?= $this->Number->format($facturasCuerposItem->cantidad_facturada) ?></td>
            <td><?= $this->Number->format($facturasCuerposItem->precio_unitario) ?></td>
            <td><?= $this->Number->format($facturasCuerposItem->precio_publico) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $facturasCuerposItem->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $facturasCuerposItem->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $facturasCuerposItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $facturasCuerposItem->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
