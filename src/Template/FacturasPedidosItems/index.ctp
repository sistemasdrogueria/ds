<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Facturas Pedidos Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Facturas Pedidos'), ['controller' => 'FacturasPedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facturas Pedido'), ['controller' => 'FacturasPedidos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="facturasPedidosItems index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('facturas_pedido_id') ?></th>
            <th><?= $this->Paginator->sort('nro_envio') ?></th>
            <th><?= $this->Paginator->sort('cantidad_pedida') ?></th>
            <th><?= $this->Paginator->sort('cantidad_facturada') ?></th>
            <th><?= $this->Paginator->sort('precio_facturado') ?></th>
            <th><?= $this->Paginator->sort('desc_aplicado') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($facturasPedidosItems as $facturasPedidosItem): ?>
        <tr>
            <td><?= $this->Number->format($facturasPedidosItem->id) ?></td>
            <td>
                <?= $facturasPedidosItem->has('facturas_pedido') ? $this->Html->link($facturasPedidosItem->facturas_pedido->id, ['controller' => 'FacturasPedidos', 'action' => 'view', $facturasPedidosItem->facturas_pedido->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($facturasPedidosItem->nro_envio) ?></td>
            <td><?= $this->Number->format($facturasPedidosItem->cantidad_pedida) ?></td>
            <td><?= $this->Number->format($facturasPedidosItem->cantidad_facturada) ?></td>
            <td><?= $this->Number->format($facturasPedidosItem->precio_facturado) ?></td>
            <td><?= $this->Number->format($facturasPedidosItem->desc_aplicado) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $facturasPedidosItem->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $facturasPedidosItem->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $facturasPedidosItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $facturasPedidosItem->id)]) ?>
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
