<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Pedidos Items'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Pedidos'), ['controller' => 'Pedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedido'), ['controller' => 'Pedidos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combos'), ['controller' => 'Combos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo'), ['controller' => 'Combos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="pedidosItems form large-10 medium-9 columns">
    <?= $this->Form->create($pedidosItem); ?>
    <fieldset>
        <legend><?= __('Add Pedidos Item') ?></legend>
        <?php
            echo $this->Form->input('agregado', array('empty' => true, 'default' => ''));
            echo $this->Form->input('pedido_id', ['options' => $pedidos, 'empty' => true]);
            echo $this->Form->input('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->input('cantidad');
            echo $this->Form->input('precio_publico');
            echo $this->Form->input('descuento');
            echo $this->Form->input('unidad_minima');
            echo $this->Form->input('tipo_precio');
            echo $this->Form->input('plazoley_dcto');
            echo $this->Form->input('combo_id', ['options' => $combos, 'empty' => true]);
            echo $this->Form->input('tipo_oferta');
            echo $this->Form->input('tipo_oferta_elegida');
            echo $this->Form->input('tipo_fact');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
