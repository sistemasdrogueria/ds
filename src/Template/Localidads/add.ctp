<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Localidads'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Provincias'), ['controller' => 'Provincias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Provincia'), ['controller' => 'Provincias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Proveedors'), ['controller' => 'Proveedors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Proveedor'), ['controller' => 'Proveedors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sucursals'), ['controller' => 'Sucursals', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sucursal'), ['controller' => 'Sucursals', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="localidads form large-10 medium-9 columns">
    <?= $this->Form->create($localidad); ?>
    <fieldset>
        <legend><?= __('Add Localidad') ?></legend>
        <?php
            echo $this->Form->input('nombre');
            echo $this->Form->input('codigo');
            echo $this->Form->input('provincia_id', ['options' => $provincias]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
