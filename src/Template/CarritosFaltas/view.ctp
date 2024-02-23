<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CarritosFalta $carritosFalta
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Carritos Falta'), ['action' => 'edit', $carritosFalta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Carritos Falta'), ['action' => 'delete', $carritosFalta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carritosFalta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Carritos Faltas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carritos Falta'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combos'), ['controller' => 'Combos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo'), ['controller' => 'Combos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categorias'), ['controller' => 'Categorias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Categoria'), ['controller' => 'Categorias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Descuentos'), ['controller' => 'Descuentos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Descuento'), ['controller' => 'Descuentos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="carritosFaltas view large-9 medium-8 columns content">
    <h3><?= h($carritosFalta->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cliente') ?></th>
            <td><?= $carritosFalta->has('cliente') ? $this->Html->link($carritosFalta->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $carritosFalta->cliente->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Articulo') ?></th>
            <td><?= $carritosFalta->has('articulo') ? $this->Html->link($carritosFalta->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $carritosFalta->articulo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($carritosFalta->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Precio') ?></th>
            <td><?= h($carritosFalta->tipo_precio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Plazoley Dcto') ?></th>
            <td><?= h($carritosFalta->plazoley_dcto) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Combo') ?></th>
            <td><?= $carritosFalta->has('combo') ? $this->Html->link($carritosFalta->combo->id, ['controller' => 'Combos', 'action' => 'view', $carritosFalta->combo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Oferta') ?></th>
            <td><?= h($carritosFalta->tipo_oferta) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Oferta Elegida') ?></th>
            <td><?= h($carritosFalta->tipo_oferta_elegida) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Fact') ?></th>
            <td><?= h($carritosFalta->tipo_fact) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Categoria') ?></th>
            <td><?= $carritosFalta->has('categoria') ? $this->Html->link($carritosFalta->categoria->nombre, ['controller' => 'Categorias', 'action' => 'view', $carritosFalta->categoria->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descuento') ?></th>
            <td><?= $carritosFalta->has('descuento') ? $this->Html->link($carritosFalta->descuento->id, ['controller' => 'Descuentos', 'action' => 'view', $carritosFalta->descuento->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($carritosFalta->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cantidad') ?></th>
            <td><?= $this->Number->format($carritosFalta->cantidad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Precio Publico') ?></th>
            <td><?= $this->Number->format($carritosFalta->precio_publico) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descuento') ?></th>
            <td><?= $this->Number->format($carritosFalta->descuento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unidad Minima') ?></th>
            <td><?= $this->Number->format($carritosFalta->unidad_minima) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Compra Min') ?></th>
            <td><?= $this->Number->format($carritosFalta->compra_min) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Compra Multiplo') ?></th>
            <td><?= $this->Number->format($carritosFalta->compra_multiplo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Compra Max') ?></th>
            <td><?= $this->Number->format($carritosFalta->compra_max) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Multiplo') ?></th>
            <td><?= $this->Number->format($carritosFalta->multiplo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Combo Tipo Id') ?></th>
            <td><?= $this->Number->format($carritosFalta->combo_tipo_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cantidad Solicitada') ?></th>
            <td><?= $this->Number->format($carritosFalta->cantidad_solicitada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($carritosFalta->creado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modificado') ?></th>
            <td><?= h($carritosFalta->modificado) ?></td>
        </tr>
    </table>
</div>
