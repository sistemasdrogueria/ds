<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Clientes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Provincias'), ['controller' => 'Provincias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Provincia'), ['controller' => 'Provincias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Localidads'), ['controller' => 'Localidads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Localidad'), ['controller' => 'Localidads', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Representantes'), ['controller' => 'Representantes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Representante'), ['controller' => 'Representantes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carritos'), ['controller' => 'Carritos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carrito'), ['controller' => 'Carritos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Facturas Pedidos'), ['controller' => 'FacturasPedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facturas Pedido'), ['controller' => 'FacturasPedidos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Logs Accesos'), ['controller' => 'LogsAccesos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Logs Acceso'), ['controller' => 'LogsAccesos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos'), ['controller' => 'Pedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedido'), ['controller' => 'Pedidos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reclamos'), ['controller' => 'Reclamos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamo'), ['controller' => 'Reclamos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sucursals'), ['controller' => 'Sucursals', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sucursal'), ['controller' => 'Sucursals', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Usuarios'), ['controller' => 'Usuarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Usuario'), ['controller' => 'Usuarios', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="clientes form large-10 medium-9 columns">
    <?= $this->Form->create($cliente); ?>
    <fieldset>
        <legend><?= __('Add Cliente') ?></legend>
        <?php
            echo $this->Form->input('codigo');
            echo $this->Form->input('razon_social');
            echo $this->Form->input('cuit');
            echo $this->Form->input('nombre');
            echo $this->Form->input('codigo_postal');
            echo $this->Form->input('domicilio');
            echo $this->Form->input('provincia_id', ['options' => $provincias, 'empty' => true]);
            echo $this->Form->input('localidad_id', ['options' => $localidads, 'empty' => true]);
            echo $this->Form->input('telefono');
            echo $this->Form->input('tienesucursal');
            echo $this->Form->input('representante_id', ['options' => $representantes, 'empty' => true]);
            echo $this->Form->input('email');
            echo $this->Form->input('email_alternativo');
            echo $this->Form->input('clave_pedidos');
            echo $this->Form->input('codigo_pedidos');
            echo $this->Form->input('ofertaxmail');
            echo $this->Form->input('respuestaxmail');
            echo $this->Form->input('clacli');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
