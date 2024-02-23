<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sucursal->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sucursal->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Sucursals'), ['action' => 'index']) ?></li>
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
<div class="sucursals form large-10 medium-9 columns">
    <?= $this->Form->create($sucursal); ?>
    <fieldset>
        <legend><?= __('Edit Sucursal') ?></legend>
        <?php
            echo $this->Form->input('cliente_id', ['options' => $clientes]);
            echo $this->Form->input('razon_social');
            echo $this->Form->input('cuit');
            echo $this->Form->input('nombre');
            echo $this->Form->input('codigo_postal');
            echo $this->Form->input('domicilio');
            echo $this->Form->input('provincia_id', ['options' => $provincias, 'empty' => true]);
            echo $this->Form->input('localidad_id', ['options' => $localidads, 'empty' => true]);
            echo $this->Form->input('telefono');
            echo $this->Form->input('email');
            echo $this->Form->input('email_alternativo');
            echo $this->Form->input('clave_pedidos');
            echo $this->Form->input('codigo_pedidos');
            echo $this->Form->input('ofertaxmail');
            echo $this->Form->input('respuestaxmail');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
