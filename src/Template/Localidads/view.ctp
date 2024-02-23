<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Localidad'), ['action' => 'edit', $localidad->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Localidad'), ['action' => 'delete', $localidad->id], ['confirm' => __('Are you sure you want to delete # {0}?', $localidad->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Localidads'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Localidad'), ['action' => 'add']) ?> </li>
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
<div class="localidads view large-10 medium-9 columns">
    <h2><?= h($localidad->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($localidad->nombre) ?></p>
            <h6 class="subheader"><?= __('Codigo') ?></h6>
            <p><?= h($localidad->codigo) ?></p>
            <h6 class="subheader"><?= __('Provincia') ?></h6>
            <p><?= $localidad->has('provincia') ? $this->Html->link($localidad->provincia->id, ['controller' => 'Provincias', 'action' => 'view', $localidad->provincia->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($localidad->id) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Clientes') ?></h4>
    <?php if (!empty($localidad->clientes)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Codigo') ?></th>
            <th><?= __('Razon Social') ?></th>
            <th><?= __('Cuit') ?></th>
            <th><?= __('Nombre') ?></th>
            <th><?= __('Codigo Postal') ?></th>
            <th><?= __('Domicilio') ?></th>
            <th><?= __('Provincia Id') ?></th>
            <th><?= __('Localidad Id') ?></th>
            <th><?= __('Telefono') ?></th>
            <th><?= __('Tienesucursal') ?></th>
            <th><?= __('Representante Id') ?></th>
            <th><?= __('Email') ?></th>
            <th><?= __('Email Alternativo') ?></th>
            <th><?= __('Clave Pedidos') ?></th>
            <th><?= __('Codigo Pedidos') ?></th>
            <th><?= __('Ofertaxmail') ?></th>
            <th><?= __('Respuestaxmail') ?></th>
            <th><?= __('Clacli') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($localidad->clientes as $clientes): ?>
        <tr>
            <td><?= h($clientes->id) ?></td>
            <td><?= h($clientes->codigo) ?></td>
            <td><?= h($clientes->razon_social) ?></td>
            <td><?= h($clientes->cuit) ?></td>
            <td><?= h($clientes->nombre) ?></td>
            <td><?= h($clientes->codigo_postal) ?></td>
            <td><?= h($clientes->domicilio) ?></td>
            <td><?= h($clientes->provincia_id) ?></td>
            <td><?= h($clientes->localidad_id) ?></td>
            <td><?= h($clientes->telefono) ?></td>
            <td><?= h($clientes->tienesucursal) ?></td>
            <td><?= h($clientes->representante_id) ?></td>
            <td><?= h($clientes->email) ?></td>
            <td><?= h($clientes->email_alternativo) ?></td>
            <td><?= h($clientes->clave_pedidos) ?></td>
            <td><?= h($clientes->codigo_pedidos) ?></td>
            <td><?= h($clientes->ofertaxmail) ?></td>
            <td><?= h($clientes->respuestaxmail) ?></td>
            <td><?= h($clientes->clacli) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Clientes', 'action' => 'view', $clientes->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Clientes', 'action' => 'edit', $clientes->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Clientes', 'action' => 'delete', $clientes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientes->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Proveedors') ?></h4>
    <?php if (!empty($localidad->proveedors)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Codigo') ?></th>
            <th><?= __('Razon Social') ?></th>
            <th><?= __('Domicilio') ?></th>
            <th><?= __('Codigo Postal') ?></th>
            <th><?= __('Provincia Id') ?></th>
            <th><?= __('Localidad Id') ?></th>
            <th><?= __('Cuit') ?></th>
            <th><?= __('Categoria') ?></th>
            <th><?= __('Separa Transfer') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($localidad->proveedors as $proveedors): ?>
        <tr>
            <td><?= h($proveedors->id) ?></td>
            <td><?= h($proveedors->codigo) ?></td>
            <td><?= h($proveedors->razon_social) ?></td>
            <td><?= h($proveedors->domicilio) ?></td>
            <td><?= h($proveedors->codigo_postal) ?></td>
            <td><?= h($proveedors->provincia_id) ?></td>
            <td><?= h($proveedors->localidad_id) ?></td>
            <td><?= h($proveedors->cuit) ?></td>
            <td><?= h($proveedors->categoria) ?></td>
            <td><?= h($proveedors->separa_transfer) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Proveedors', 'action' => 'view', $proveedors->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Proveedors', 'action' => 'edit', $proveedors->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Proveedors', 'action' => 'delete', $proveedors->id], ['confirm' => __('Are you sure you want to delete # {0}?', $proveedors->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Sucursals') ?></h4>
    <?php if (!empty($localidad->sucursals)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Cliente Id') ?></th>
            <th><?= __('Razon Social') ?></th>
            <th><?= __('Cuit') ?></th>
            <th><?= __('Nombre') ?></th>
            <th><?= __('Codigo Postal') ?></th>
            <th><?= __('Domicilio') ?></th>
            <th><?= __('Provincia Id') ?></th>
            <th><?= __('Localidad Id') ?></th>
            <th><?= __('Telefono') ?></th>
            <th><?= __('Email') ?></th>
            <th><?= __('Email Alternativo') ?></th>
            <th><?= __('Clave Pedidos') ?></th>
            <th><?= __('Codigo Pedidos') ?></th>
            <th><?= __('Ofertaxmail') ?></th>
            <th><?= __('Respuestaxmail') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($localidad->sucursals as $sucursals): ?>
        <tr>
            <td><?= h($sucursals->id) ?></td>
            <td><?= h($sucursals->cliente_id) ?></td>
            <td><?= h($sucursals->razon_social) ?></td>
            <td><?= h($sucursals->cuit) ?></td>
            <td><?= h($sucursals->nombre) ?></td>
            <td><?= h($sucursals->codigo_postal) ?></td>
            <td><?= h($sucursals->domicilio) ?></td>
            <td><?= h($sucursals->provincia_id) ?></td>
            <td><?= h($sucursals->localidad_id) ?></td>
            <td><?= h($sucursals->telefono) ?></td>
            <td><?= h($sucursals->email) ?></td>
            <td><?= h($sucursals->email_alternativo) ?></td>
            <td><?= h($sucursals->clave_pedidos) ?></td>
            <td><?= h($sucursals->codigo_pedidos) ?></td>
            <td><?= h($sucursals->ofertaxmail) ?></td>
            <td><?= h($sucursals->respuestaxmail) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Sucursals', 'action' => 'view', $sucursals->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Sucursals', 'action' => 'edit', $sucursals->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Sucursals', 'action' => 'delete', $sucursals->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sucursals->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
