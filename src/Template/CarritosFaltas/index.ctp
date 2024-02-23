<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CarritosFalta[]|\Cake\Collection\CollectionInterface $carritosFaltas
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Carritos Falta'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Combos'), ['controller' => 'Combos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Combo'), ['controller' => 'Combos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categorias'), ['controller' => 'Categorias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Categoria'), ['controller' => 'Categorias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Descuentos'), ['controller' => 'Descuentos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Descuento'), ['controller' => 'Descuentos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="carritosFaltas index large-9 medium-8 columns content">
    <h3><?= __('Carritos Faltas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cliente_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('articulo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cantidad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('precio_publico') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descuento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('unidad_minima') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_precio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('plazoley_dcto') ?></th>
                <th scope="col"><?= $this->Paginator->sort('combo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_oferta') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_oferta_elegida') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_fact') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modificado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('categoria_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('compra_min') ?></th>
                <th scope="col"><?= $this->Paginator->sort('compra_multiplo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('compra_max') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descuento_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('multiplo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('combo_tipo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cantidad_solicitada') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carritosFaltas as $carritosFalta): ?>
            <tr>
                <td><?= $this->Number->format($carritosFalta->id) ?></td>
                <td><?= $carritosFalta->has('cliente') ? $this->Html->link($carritosFalta->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $carritosFalta->cliente->id]) : '' ?></td>
                <td><?= $carritosFalta->has('articulo') ? $this->Html->link($carritosFalta->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $carritosFalta->articulo->id]) : '' ?></td>
                <td><?= h($carritosFalta->descripcion) ?></td>
                <td><?= $this->Number->format($carritosFalta->cantidad) ?></td>
                <td><?= $this->Number->format($carritosFalta->precio_publico) ?></td>
                <td><?= $this->Number->format($carritosFalta->descuento) ?></td>
                <td><?= $this->Number->format($carritosFalta->unidad_minima) ?></td>
                <td><?= h($carritosFalta->tipo_precio) ?></td>
                <td><?= h($carritosFalta->plazoley_dcto) ?></td>
                <td><?= $carritosFalta->has('combo') ? $this->Html->link($carritosFalta->combo->id, ['controller' => 'Combos', 'action' => 'view', $carritosFalta->combo->id]) : '' ?></td>
                <td><?= h($carritosFalta->tipo_oferta) ?></td>
                <td><?= h($carritosFalta->tipo_oferta_elegida) ?></td>
                <td><?= h($carritosFalta->tipo_fact) ?></td>
                <td><?= h($carritosFalta->creado) ?></td>
                <td><?= h($carritosFalta->modificado) ?></td>
                <td><?= $carritosFalta->has('categoria') ? $this->Html->link($carritosFalta->categoria->nombre, ['controller' => 'Categorias', 'action' => 'view', $carritosFalta->categoria->id]) : '' ?></td>
                <td><?= $this->Number->format($carritosFalta->compra_min) ?></td>
                <td><?= $this->Number->format($carritosFalta->compra_multiplo) ?></td>
                <td><?= $this->Number->format($carritosFalta->compra_max) ?></td>
                <td><?= $carritosFalta->has('descuento') ? $this->Html->link($carritosFalta->descuento->id, ['controller' => 'Descuentos', 'action' => 'view', $carritosFalta->descuento->id]) : '' ?></td>
                <td><?= $this->Number->format($carritosFalta->multiplo) ?></td>
                <td><?= $this->Number->format($carritosFalta->combo_tipo_id) ?></td>
                <td><?= $this->Number->format($carritosFalta->cantidad_solicitada) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $carritosFalta->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $carritosFalta->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $carritosFalta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carritosFalta->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
