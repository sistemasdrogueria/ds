<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Genero'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Fragancias'), ['controller' => 'Fragancias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Fragancia'), ['controller' => 'Fragancias', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="generos index large-9 medium-8 columns content">
    <h3><?= __('Generos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('nombre') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($generos as $genero): ?>
            <tr>
                <td><?= $this->Number->format($genero->id) ?></td>
                <td><?= h($genero->nombre) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $genero->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $genero->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $genero->id], ['confirm' => __('Are you sure you want to delete # {0}?', $genero->id)]) ?>
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
