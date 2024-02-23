<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Sucursal'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Provincias'), ['controller' => 'Provincias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Provincia'), ['controller' => 'Provincias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Localidads'), ['controller' => 'Localidads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Localidad'), ['controller' => 'Localidads', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos'), ['controller' => 'Pedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedido'), ['controller' => 'Pedidos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="sucursals index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('cliente_id') ?></th>
            <th><?= $this->Paginator->sort('codigo_postal') ?></th>
            <th><?= $this->Paginator->sort('provincia_id') ?></th>
            <th><?= $this->Paginator->sort('localidad_id') ?></th>
            <th><?= $this->Paginator->sort('telefono') ?></th>
            <th><?= $this->Paginator->sort('email') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($sucursals as $sucursal): ?>
        <tr>
            <td><?= $this->Number->format($sucursal->id) ?></td>
            <td>
                <?= $sucursal->has('cliente') ? $this->Html->link($sucursal->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $sucursal->cliente->id]) : '' ?>
            </td>
            <td><?= h($sucursal->codigo_postal) ?></td>
            <td>
                <?= $sucursal->has('provincia') ? $this->Html->link($sucursal->provincia->id, ['controller' => 'Provincias', 'action' => 'view', $sucursal->provincia->id]) : '' ?>
            </td>
            <td>
                <?= $sucursal->has('localidad') ? $this->Html->link($sucursal->localidad->id, ['controller' => 'Localidads', 'action' => 'view', $sucursal->localidad->id]) : '' ?>
            </td>
            <td><?= h($sucursal->telefono) ?></td>
            <td><?= h($sucursal->email) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $sucursal->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sucursal->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sucursal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sucursal->id)]) ?>
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
