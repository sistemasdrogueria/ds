<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Permiso'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Perfiles'), ['controller' => 'Perfiles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Perfile'), ['controller' => 'Perfiles', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="permisos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('clase') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($permisos as $permiso): ?>
        <tr>
            <td><?= $this->Number->format($permiso->id) ?></td>
            <td><?= h($permiso->clase) ?></td>
            <td><?= h($permiso->nombre) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $permiso->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $permiso->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $permiso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permiso->id)]) ?>
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
