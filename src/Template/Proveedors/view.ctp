<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Proveedor'), ['action' => 'edit', $proveedor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Proveedor'), ['action' => 'delete', $proveedor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $proveedor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Proveedors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Proveedor'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Provincias'), ['controller' => 'Provincias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Provincia'), ['controller' => 'Provincias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Localidads'), ['controller' => 'Localidads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Localidad'), ['controller' => 'Localidads', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ofertas'), ['controller' => 'Ofertas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Oferta'), ['controller' => 'Ofertas', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="proveedors view large-10 medium-9 columns">
    <h2><?= h($proveedor->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Provincia') ?></h6>
            <p><?= $proveedor->has('provincia') ? $this->Html->link($proveedor->provincia->id, ['controller' => 'Provincias', 'action' => 'view', $proveedor->provincia->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Localidad') ?></h6>
            <p><?= $proveedor->has('localidad') ? $this->Html->link($proveedor->localidad->id, ['controller' => 'Localidads', 'action' => 'view', $proveedor->localidad->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($proveedor->id) ?></p>
            <h6 class="subheader"><?= __('Codigo') ?></h6>
            <p><?= $this->Number->format($proveedor->codigo) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Separa Transfer') ?></h6>
            <p><?= $proveedor->separa_transfer ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Razon Social') ?></h6>
            <?= $this->Text->autoParagraph(h($proveedor->razon_social)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Domicilio') ?></h6>
            <?= $this->Text->autoParagraph(h($proveedor->domicilio)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Codigo Postal') ?></h6>
            <?= $this->Text->autoParagraph(h($proveedor->codigo_postal)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Cuit') ?></h6>
            <?= $this->Text->autoParagraph(h($proveedor->cuit)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Categoria') ?></h6>
            <?= $this->Text->autoParagraph(h($proveedor->categoria)); ?>

        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Ofertas') ?></h4>
    <?php if (!empty($proveedor->ofertas)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Proveedor Id') ?></th>
            <th><?= __('Articulo Id') ?></th>
            <th><?= __('Descripcion') ?></th>
            <th><?= __('Descuento Producto') ?></th>
            <th><?= __('Unidades Minimas') ?></th>
            <th><?= __('Fecha Desde') ?></th>
            <th><?= __('Fecha Hasta') ?></th>
            <th><?= __('Plazos') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($proveedor->ofertas as $ofertas): ?>
        <tr>
            <td><?= h($ofertas->id) ?></td>
            <td><?= h($ofertas->proveedor_id) ?></td>
            <td><?= h($ofertas->articulo_id) ?></td>
            <td><?= h($ofertas->descripcion) ?></td>
            <td><?= h($ofertas->descuento_producto) ?></td>
            <td><?= h($ofertas->unidades_minimas) ?></td>
            <td><?= h($ofertas->fecha_desde) ?></td>
            <td><?= h($ofertas->fecha_hasta) ?></td>
            <td><?= h($ofertas->plazos) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Ofertas', 'action' => 'view', $ofertas->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Ofertas', 'action' => 'edit', $ofertas->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ofertas', 'action' => 'delete', $ofertas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ofertas->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
