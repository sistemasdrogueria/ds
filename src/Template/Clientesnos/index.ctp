<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Clientesno'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="clientesnos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('codigo') ?></th>
            <th><?= $this->Paginator->sort('provincia') ?></th>
            <th><?= $this->Paginator->sort('representante') ?></th>
            <th><?= $this->Paginator->sort('cambio_clave') ?></th>
            <th><?= $this->Paginator->sort('email') ?></th>
            <th><?= $this->Paginator->sort('clave_pedidos') ?></th>
            <th><?= $this->Paginator->sort('codigo_pedidos') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($clientesnos as $clientesno): ?>
        <tr>
            <td><?= $this->Number->format($clientesno->codigo) ?></td>
            <td><?= $this->Number->format($clientesno->provincia) ?></td>
            <td><?= h($clientesno->representante) ?></td>
            <td><?= h($clientesno->cambio_clave) ?></td>
            <td><?= h($clientesno->email) ?></td>
            <td><?= $this->Number->format($clientesno->clave_pedidos) ?></td>
            <td><?= $this->Number->format($clientesno->codigo_pedidos) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $clientesno->codigo]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientesno->codigo]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientesno->codigo], ['confirm' => __('Are you sure you want to delete # {0}?', $clientesno->codigo)]) ?>
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
