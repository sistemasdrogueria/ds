<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Reclamos Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reclamos'), ['controller' => 'Reclamos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamo'), ['controller' => 'Reclamos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="reclamosItems index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('reclamo_id') ?></th>
            <th><?= $this->Paginator->sort('articulo_id') ?></th>
            <th><?= $this->Paginator->sort('cantidad') ?></th>
            <th><?= $this->Paginator->sort('detalle') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($reclamosItems as $reclamosItem): ?>
        <tr>
            <td><?= $this->Number->format($reclamosItem->id) ?></td>
            <td>
                <?= $reclamosItem->has('reclamo') ? $this->Html->link($reclamosItem->reclamo->id, ['controller' => 'Reclamos', 'action' => 'view', $reclamosItem->reclamo->id]) : '' ?>
            </td>
            <td>
                <?= $reclamosItem->has('articulo') ? $this->Html->link($reclamosItem->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $reclamosItem->articulo->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($reclamosItem->cantidad) ?></td>
            <td><?= h($reclamosItem->detalle) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $reclamosItem->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reclamosItem->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reclamosItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamosItem->id)]) ?>
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
