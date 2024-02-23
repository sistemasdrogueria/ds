<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Pedidos Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pedidos'), ['controller' => 'Pedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedido'), ['controller' => 'Pedidos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combos'), ['controller' => 'Combos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo'), ['controller' => 'Combos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="pedidosItems index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('agregado') ?></th>
            <th><?= $this->Paginator->sort('pedido_id') ?></th>
            <th><?= $this->Paginator->sort('articulo_id') ?></th>
            <th><?= $this->Paginator->sort('cantidad') ?></th>
            <th><?= $this->Paginator->sort('precio_publico') ?></th>
            <th><?= $this->Paginator->sort('descuento') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pedidosItems as $pedidosItem): ?>
        <tr>
            <td><?= $this->Number->format($pedidosItem->id) ?></td>
            <td><?= h($pedidosItem->agregado) ?></td>
            <td>
                <?= $pedidosItem->has('pedido') ? $this->Html->link($pedidosItem->pedido->id, ['controller' => 'Pedidos', 'action' => 'view', $pedidosItem->pedido->id]) : '' ?>
            </td>
            <td>
                <?= $pedidosItem->has('articulo') ? $this->Html->link($pedidosItem->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $pedidosItem->articulo->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($pedidosItem->cantidad) ?></td>
            <td><?= $this->Number->format($pedidosItem->precio_publico) ?></td>
            <td><?= $this->Number->format($pedidosItem->descuento) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $pedidosItem->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pedidosItem->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pedidosItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pedidosItem->id)]) ?>
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
