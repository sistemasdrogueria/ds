<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Laboratorio'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="laboratorios index large-10 medium-9 columns">
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
    <?php foreach ($laboratorios as $laboratorio): ?>
        <tr>
            <td><?= $this->Number->format($laboratorio->id) ?></td>
            <td><?= h($laboratorio->codigo) ?></td>
            <td><?= h($laboratorio->nombre) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $laboratorio->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $laboratorio->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $laboratorio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $laboratorio->id)]) ?>
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
