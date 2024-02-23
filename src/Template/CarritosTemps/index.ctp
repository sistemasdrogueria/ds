<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Carritos Temp'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Combos'), ['controller' => 'Combos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Combo'), ['controller' => 'Combos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="carritosTemps index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('cliente_id') ?></th>
            <th><?= $this->Paginator->sort('articulo_id') ?></th>
            <th><?= $this->Paginator->sort('descripcion') ?></th>
            <th><?= $this->Paginator->sort('cantidad') ?></th>
            <th><?= $this->Paginator->sort('precio_publico') ?></th>
            <th><?= $this->Paginator->sort('descuento') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($carritosTemps as $carritosTemp): ?>
        <tr>
            <td><?= $this->Number->format($carritosTemp->id) ?></td>
            <td>
                <?= $carritosTemp->has('cliente') ? $this->Html->link($carritosTemp->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $carritosTemp->cliente->id]) : '' ?>
            </td>
            <td>
                <?= $carritosTemp->has('articulo') ? $this->Html->link($carritosTemp->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $carritosTemp->articulo->id]) : '' ?>
            </td>
            <td><?= h($carritosTemp->descripcion) ?></td>
            <td><?= $this->Number->format($carritosTemp->cantidad) ?></td>
            <td><?= $this->Number->format($carritosTemp->precio_publico) ?></td>
            <td><?= $this->Number->format($carritosTemp->descuento) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $carritosTemp->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $carritosTemp->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $carritosTemp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carritosTemp->id)]) ?>
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
