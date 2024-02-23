<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Proveedor'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Provincias'), ['controller' => 'Provincias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Provincia'), ['controller' => 'Provincias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Localidads'), ['controller' => 'Localidads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Localidad'), ['controller' => 'Localidads', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ofertas'), ['controller' => 'Ofertas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Oferta'), ['controller' => 'Ofertas', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="proveedors index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('codigo') ?></th>
            <th><?= $this->Paginator->sort('provincia_id') ?></th>
            <th><?= $this->Paginator->sort('localidad_id') ?></th>
            <th><?= $this->Paginator->sort('separa_transfer') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($proveedors as $proveedor): ?>
        <tr>
            <td><?= $this->Number->format($proveedor->id) ?></td>
            <td><?= $this->Number->format($proveedor->codigo) ?></td>
            <td>
                <?= $proveedor->has('provincia') ? $this->Html->link($proveedor->provincia->id, ['controller' => 'Provincias', 'action' => 'view', $proveedor->provincia->id]) : '' ?>
            </td>
            <td>
                <?= $proveedor->has('localidad') ? $this->Html->link($proveedor->localidad->id, ['controller' => 'Localidads', 'action' => 'view', $proveedor->localidad->id]) : '' ?>
            </td>
            <td><?= h($proveedor->separa_transfer) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $proveedor->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $proveedor->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $proveedor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $proveedor->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
