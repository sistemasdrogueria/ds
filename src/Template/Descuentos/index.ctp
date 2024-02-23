<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Descuento'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="descuentos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('articulo_id') ?></th>
            <th><?= $this->Paginator->sort('fecha_desde') ?></th>
            <th><?= $this->Paginator->sort('fecha_hasta') ?></th>
            <th><?= $this->Paginator->sort('precio_costo') ?></th>
            <th><?= $this->Paginator->sort('dto_patagonia') ?></th>
            <th><?= $this->Paginator->sort('dto_drogueria') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($descuentos as $descuento): ?>
        <tr>
            <td><?= $this->Number->format($descuento->id) ?></td>
            <td>
                <?= $descuento->has('articulo') ? $this->Html->link($descuento->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $descuento->articulo->id]) : '' ?>
            </td>
            <td><?= h($descuento->fecha_desde) ?></td>
            <td><?= h($descuento->fecha_hasta) ?></td>
            <td><?= $this->Number->format($descuento->precio_costo) ?></td>
            <td><?= $this->Number->format($descuento->dto_patagonia) ?></td>
            <td><?= $this->Number->format($descuento->dto_drogueria) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $descuento->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $descuento->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $descuento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $descuento->id)]) ?>
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
