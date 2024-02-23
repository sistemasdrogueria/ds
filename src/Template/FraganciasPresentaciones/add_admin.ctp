<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Fragancias Presentaciones'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Fragancias'), ['controller' => 'Fragancias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Fragancia'), ['controller' => 'Fragancias', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fraganciasPresentaciones form large-9 medium-8 columns content">
    <?= $this->Form->create($fraganciasPresentacione) ?>
    <fieldset>
        <legend><?= __('Add Fragancias Presentacione') ?></legend>
        <?php
            echo $this->Form->input('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->input('fragancia_id', ['options' => $fragancias, 'empty' => true]);
            echo $this->Form->input('detalle');
            echo $this->Form->input('creado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
