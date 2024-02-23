<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CarritosFalta $carritosFalta
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $carritosFalta->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $carritosFalta->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Carritos Faltas'), ['action' => 'index']) ?></li>
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
<div class="carritosFaltas form large-9 medium-8 columns content">
    <?= $this->Form->create($carritosFalta) ?>
    <fieldset>
        <legend><?= __('Edit Carritos Falta') ?></legend>
        <?php
            echo $this->Form->control('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->control('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->control('descripcion');
            echo $this->Form->control('cantidad');
            echo $this->Form->control('precio_publico');
            echo $this->Form->control('descuento');
            echo $this->Form->control('unidad_minima');
            echo $this->Form->control('tipo_precio');
            echo $this->Form->control('plazoley_dcto');
            echo $this->Form->control('combo_id', ['options' => $combos, 'empty' => true]);
            echo $this->Form->control('tipo_oferta');
            echo $this->Form->control('tipo_oferta_elegida');
            echo $this->Form->control('tipo_fact');
            echo $this->Form->control('creado', ['empty' => true]);
            echo $this->Form->control('modificado', ['empty' => true]);
            echo $this->Form->control('categoria_id', ['options' => $categorias, 'empty' => true]);
            echo $this->Form->control('compra_min');
            echo $this->Form->control('compra_multiplo');
            echo $this->Form->control('compra_max');
            echo $this->Form->control('descuento_id', ['options' => $descuentos, 'empty' => true]);
            echo $this->Form->control('multiplo');
            echo $this->Form->control('combo_tipo_id');
            echo $this->Form->control('cantidad_solicitada');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
