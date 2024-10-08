<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Reclamos Tipo'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reclamos'), ['controller' => 'Reclamos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamo'), ['controller' => 'Reclamos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="reclamosTipos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($reclamosTipos as $reclamosTipo): ?>
        <tr>
            <td><?= $this->Number->format($reclamosTipo->id) ?></td>
            <td><?= h($reclamosTipo->nombre) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $reclamosTipo->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reclamosTipo->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reclamosTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamosTipo->id)]) ?>
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
