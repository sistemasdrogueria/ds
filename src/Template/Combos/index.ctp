<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Combo'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Carritos Items'), ['controller' => 'CarritosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carritos Item'), ['controller' => 'CarritosItems', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos Items'), ['controller' => 'PedidosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedidos Item'), ['controller' => 'PedidosItems', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="combos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th><?= $this->Paginator->sort('desde') ?></th>
            <th><?= $this->Paginator->sort('hasta') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($combos as $combo): ?>
        <tr>
            <td><?= $this->Number->format($combo->id) ?></td>
            <td><?= h($combo->nombre) ?></td>
            <td><?= h($combo->desde) ?></td>
            <td><?= h($combo->hasta) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $combo->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $combo->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $combo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $combo->id)]) ?>
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
