<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Clientes Credito'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="clientesCreditos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('cliente_id') ?></th>
            <th><?= $this->Paginator->sort('credito_maximo') ?></th>
            <th><?= $this->Paginator->sort('credito_consumo') ?></th>
            <th><?= $this->Paginator->sort('credito_tipo') ?></th>
            <th><?= $this->Paginator->sort('fecha') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($clientesCreditos as $clientesCredito): ?>
        <tr>
            <td><?= $this->Number->format($clientesCredito->id) ?></td>
            <td>
                <?= $clientesCredito->has('cliente') ? $this->Html->link($clientesCredito->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $clientesCredito->cliente->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($clientesCredito->credito_maximo) ?></td>
            <td><?= $this->Number->format($clientesCredito->credito_consumo) ?></td>
            <td><?= h($clientesCredito->credito_tipo) ?></td>
            <td><?= h($clientesCredito->fecha) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $clientesCredito->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientesCredito->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientesCredito->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientesCredito->id)]) ?>
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
