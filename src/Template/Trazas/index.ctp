<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Traza'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="trazas index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('nota') ?></th>
            <th><?= $this->Paginator->sort('articulo_id') ?></th>
            <th><?= $this->Paginator->sort('serie') ?></th>
            <th><?= $this->Paginator->sort('lote') ?></th>
            <th><?= $this->Paginator->sort('vencimiento') ?></th>
            <th><?= $this->Paginator->sort('cod_transaccion') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($trazas as $traza): ?>
        <tr>
            <td><?= $this->Number->format($traza->id) ?></td>
            <td><?= $this->Number->format($traza->nota) ?></td>
            <td>
                <?= $traza->has('articulo') ? $this->Html->link($traza->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $traza->articulo->id]) : '' ?>
            </td>
            <td><?= h($traza->serie) ?></td>
            <td><?= h($traza->lote) ?></td>
            <td><?= h($traza->vencimiento) ?></td>
            <td><?= h($traza->cod_transaccion) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $traza->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $traza->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $traza->id], ['confirm' => __('Are you sure you want to delete # {0}?', $traza->id)]) ?>
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
