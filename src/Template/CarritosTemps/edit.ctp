<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $carritosTemp->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $carritosTemp->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Carritos Temps'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Combos'), ['controller' => 'Combos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Combo'), ['controller' => 'Combos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="carritosTemps form large-10 medium-9 columns">
    <?= $this->Form->create($carritosTemp) ?>
    <fieldset>
        <legend><?= __('Edit Carritos Temp') ?></legend>
        <?php
            echo $this->Form->input('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->input('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->input('descripcion');
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
            echo $this->Form->input('creado');
            echo $this->Form->input('modificado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
