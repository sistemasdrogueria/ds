<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Reclamos Items Temp'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="reclamosItemsTemps index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('cliente_id') ?></th>
            <th><?= $this->Paginator->sort('articulo_id') ?></th>
            <th><?= $this->Paginator->sort('cantidad') ?></th>
            <th><?= $this->Paginator->sort('detalle') ?></th>
            <th><?= $this->Paginator->sort('fecha_vencimiento') ?></th>
            <th><?= $this->Paginator->sort('lote') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($reclamosItemsTemps as $reclamosItemsTemp): ?>
        <tr>
            <td><?= $this->Number->format($reclamosItemsTemp->id) ?></td>
            <td>
                <?= $reclamosItemsTemp->has('cliente') ? $this->Html->link($reclamosItemsTemp->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $reclamosItemsTemp->cliente->id]) : '' ?>
            </td>
            <td>
                <?= $reclamosItemsTemp->has('articulo') ? $this->Html->link($reclamosItemsTemp->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $reclamosItemsTemp->articulo->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($reclamosItemsTemp->cantidad) ?></td>
            <td><?= h($reclamosItemsTemp->detalle) ?></td>
            <td><?= h($reclamosItemsTemp->fecha_vencimiento) ?></td>
            <td><?= h($reclamosItemsTemp->lote) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $reclamosItemsTemp->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reclamosItemsTemp->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reclamosItemsTemp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamosItemsTemp->id)]) ?>
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
