<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Facturas Pedido'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos'), ['controller' => 'Pedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedido'), ['controller' => 'Pedidos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="facturasPedidos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('cliente_id') ?></th>
            <th><?= $this->Paginator->sort('pedido_id') ?></th>
            <th><?= $this->Paginator->sort('pedido_fecha') ?></th>
            <th><?= $this->Paginator->sort('pedido_ds_numero') ?></th>
            <th><?= $this->Paginator->sort('envio_numero') ?></th>
            <th><?= $this->Paginator->sort('envio_fecha') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($facturasPedidos as $facturasPedido): ?>
        <tr>
            <td><?= $this->Number->format($facturasPedido->id) ?></td>
            <td>
                <?= $facturasPedido->has('cliente') ? $this->Html->link($facturasPedido->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $facturasPedido->cliente->id]) : '' ?>
            </td>
            <td>
                <?= $facturasPedido->has('pedido') ? $this->Html->link($facturasPedido->pedido->id, ['controller' => 'Pedidos', 'action' => 'view', $facturasPedido->pedido->id]) : '' ?>
            </td>
            <td><?= h($facturasPedido->pedido_fecha) ?></td>
            <td><?= $this->Number->format($facturasPedido->pedido_ds_numero) ?></td>
            <td><?= $this->Number->format($facturasPedido->envio_numero) ?></td>
            <td><?= h($facturasPedido->envio_fecha) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $facturasPedido->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $facturasPedido->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $facturasPedido->id], ['confirm' => __('Are you sure you want to delete # {0}?', $facturasPedido->id)]) ?>
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
