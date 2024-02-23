<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Carritos Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Carritos'), ['controller' => 'Carritos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carrito'), ['controller' => 'Carritos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combos'), ['controller' => 'Combos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo'), ['controller' => 'Combos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="carritos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('agregado') ?></th>
            <th><?= $this->Paginator->sort('carrito_id') ?></th>
            <th><?= $this->Paginator->sort('articulo_id') ?></th>
            <th><?= $this->Paginator->sort('cantidad') ?></th>
            <th><?= $this->Paginator->sort('precio_publico') ?></th>
            <th><?= $this->Paginator->sort('descuento') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($carritos as $carrito): ?>
        <tr>
            <td><?= $this->Number->format($carrito->id) ?></td>
            <td><?= h($carrito->agregado) ?></td>
            <td>
                <?= $carrito->has('carrito') ? $this->Html->link($carrito->carrito->id, ['controller' => 'Carritos', 'action' => 'view', $carrito->carrito->id]) : '' ?>
            </td>
            <td>
                <?= $carrito->has('articulo') ? $this->Html->link($carrito->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $carrito->articulo->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($carrito->cantidad) ?></td>
            <td><?= $this->Number->format($carrito->precio_publico) ?></td>
            <td><?= $this->Number->format($carrito->descuento) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $carrito->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $carrito->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $carrito->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carrito->id)]) ?>
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
