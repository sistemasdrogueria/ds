<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Fragancias Presentacione'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Fragancias'), ['controller' => 'Fragancias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Fragancia'), ['controller' => 'Fragancias', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fraganciasPresentaciones index large-9 medium-8 columns content">
    <h3><?= __('Fragancias Presentaciones') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('articulo_id') ?></th>
                <th><?= $this->Paginator->sort('fragancia_id') ?></th>
                <th><?= $this->Paginator->sort('detalle') ?></th>
                <th><?= $this->Paginator->sort('creado') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fraganciasPresentaciones as $fraganciasPresentacione): ?>
            <tr>
                <td><?= $this->Number->format($fraganciasPresentacione->id) ?></td>
                <td><?= $fraganciasPresentacione->has('articulo') ? $this->Html->link($fraganciasPresentacione->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $fraganciasPresentacione->articulo->id]) : '' ?></td>
                <td><?= $fraganciasPresentacione->has('fragancia') ? $this->Html->link($fraganciasPresentacione->fragancia->id, ['controller' => 'Fragancias', 'action' => 'view', $fraganciasPresentacione->fragancia->id]) : '' ?></td>
                <td><?= h($fraganciasPresentacione->detalle) ?></td>
                <td><?= h($fraganciasPresentacione->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $fraganciasPresentacione->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $fraganciasPresentacione->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $fraganciasPresentacione->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fraganciasPresentacione->id)]) ?>
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
