<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Logs Acceso'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="logsAccesos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('fecha') ?></th>
            <th><?= $this->Paginator->sort('cliente_id') ?></th>
            <th><?= $this->Paginator->sort('usuario_id') ?></th>
            <th><?= $this->Paginator->sort('ip') ?></th>
            <th><?= $this->Paginator->sort('super') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($logsAccesos as $logsAcceso): ?>
        <tr>
            <td><?= $this->Number->format($logsAcceso->id) ?></td>
            <td><?= h($logsAcceso->fecha) ?></td>
            <td>
                <?= $logsAcceso->has('cliente') ? $this->Html->link($logsAcceso->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $logsAcceso->cliente->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($logsAcceso->usuario_id) ?></td>
            <td><?= h($logsAcceso->ip) ?></td>
            <td><?= h($logsAcceso->super) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $logsAcceso->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $logsAcceso->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $logsAcceso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $logsAcceso->id)]) ?>
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
