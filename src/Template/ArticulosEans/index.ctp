<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Articulos Ean'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="articulosEans index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('articulo_id') ?></th>
            <th><?= $this->Paginator->sort('codigo_barra') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($articulosEans as $articulosEan): ?>
        <tr>
            <td><?= $this->Number->format($articulosEan->id) ?></td>
            <td>
                <?= $articulosEan->has('articulo') ? $this->Html->link($articulosEan->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $articulosEan->articulo->id]) : '' ?>
            </td>
            <td><?= h($articulosEan->codigo_barra) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $articulosEan->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $articulosEan->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $articulosEan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articulosEan->id)]) ?>
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
