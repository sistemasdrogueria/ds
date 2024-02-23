<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Usuarios Tipo'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="usuariosTipos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($usuariosTipos as $usuariosTipo): ?>
        <tr>
            <td><?= $this->Number->format($usuariosTipo->id) ?></td>
            <td><?= h($usuariosTipo->nombre) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $usuariosTipo->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $usuariosTipo->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $usuariosTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usuariosTipo->id)]) ?>
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
