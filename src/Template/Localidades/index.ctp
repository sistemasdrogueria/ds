<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Localidade'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="localidades index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('codigo') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($localidades as $localidade): ?>
        <tr>
            <td><?= $this->Number->format($localidade->id) ?></td>
            <td><?= h($localidade->codigo) ?></td>
            <td><?= h($localidade->nombre) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $localidade->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $localidade->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $localidade->id], ['confirm' => __('Are you sure you want to delete # {0}?', $localidade->id)]) ?>
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
