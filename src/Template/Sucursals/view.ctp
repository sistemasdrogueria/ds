<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Sucursal'), ['action' => 'edit', $sucursal->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sucursal'), ['action' => 'delete', $sucursal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sucursal->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sucursals'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sucursal'), ['action' => 'add']) ?> </li>
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
<div class="sucursals view large-10 medium-9 columns">
    <h2><?= h($sucursal->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $sucursal->has('cliente') ? $this->Html->link($sucursal->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $sucursal->cliente->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Codigo Postal') ?></h6>
            <p><?= h($sucursal->codigo_postal) ?></p>
            <h6 class="subheader"><?= __('Provincia') ?></h6>
            <p><?= $sucursal->has('provincia') ? $this->Html->link($sucursal->provincia->id, ['controller' => 'Provincias', 'action' => 'view', $sucursal->provincia->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Localidad') ?></h6>
            <p><?= $sucursal->has('localidad') ? $this->Html->link($sucursal->localidad->id, ['controller' => 'Localidads', 'action' => 'view', $sucursal->localidad->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Telefono') ?></h6>
            <p><?= h($sucursal->telefono) ?></p>
            <h6 class="subheader"><?= __('Email') ?></h6>
            <p><?= h($sucursal->email) ?></p>
            <h6 class="subheader"><?= __('Email Alternativo') ?></h6>
            <p><?= h($sucursal->email_alternativo) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($sucursal->id) ?></p>
            <h6 class="subheader"><?= __('Clave Pedidos') ?></h6>
            <p><?= $this->Number->format($sucursal->clave_pedidos) ?></p>
            <h6 class="subheader"><?= __('Codigo Pedidos') ?></h6>
            <p><?= $this->Number->format($sucursal->codigo_pedidos) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Ofertaxmail') ?></h6>
            <p><?= $sucursal->ofertaxmail ? __('Yes') : __('No'); ?></p>
            <h6 class="subheader"><?= __('Respuestaxmail') ?></h6>
            <p><?= $sucursal->respuestaxmail ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Razon Social') ?></h6>
            <?= $this->Text->autoParagraph(h($sucursal->razon_social)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Cuit') ?></h6>
            <?= $this->Text->autoParagraph(h($sucursal->cuit)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <?= $this->Text->autoParagraph(h($sucursal->nombre)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Domicilio') ?></h6>
            <?= $this->Text->autoParagraph(h($sucursal->domicilio)); ?>

        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Pedidos') ?></h4>
    <?php if (!empty($sucursal->pedidos)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Creado') ?></th>
            <th><?= __('Cliente Id') ?></th>
            <th><?= __('Sucursal Id') ?></th>
            <th><?= __('Tipo Fact') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($sucursal->pedidos as $pedidos): ?>
        <tr>
            <td><?= h($pedidos->id) ?></td>
            <td><?= h($pedidos->creado) ?></td>
            <td><?= h($pedidos->cliente_id) ?></td>
            <td><?= h($pedidos->sucursal_id) ?></td>
            <td><?= h($pedidos->tipo_fact) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Pedidos', 'action' => 'view', $pedidos->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Pedidos', 'action' => 'edit', $pedidos->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Pedidos', 'action' => 'delete', $pedidos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pedidos->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
