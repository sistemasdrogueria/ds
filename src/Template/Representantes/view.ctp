<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Representante'), ['action' => 'edit', $representante->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Representante'), ['action' => 'delete', $representante->id], ['confirm' => __('Are you sure you want to delete # {0}?', $representante->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Representantes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Representante'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="representantes view large-10 medium-9 columns">
    <h2><?= h($representante->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Codigo') ?></h6>
            <p><?= h($representante->codigo) ?></p>
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($representante->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($representante->id) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Clientes') ?></h4>
    <?php if (!empty($representante->clientes)): ?>
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
        <?php foreach ($representante->clientes as $clientes): ?>
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
