<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $proveedor->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $proveedor->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Proveedors'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Provincias'), ['controller' => 'Provincias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Provincia'), ['controller' => 'Provincias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Localidads'), ['controller' => 'Localidads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Localidad'), ['controller' => 'Localidads', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ofertas'), ['controller' => 'Ofertas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Oferta'), ['controller' => 'Ofertas', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="proveedors form large-10 medium-9 columns">
    <?= $this->Form->create($proveedor); ?>
    <fieldset>
        <legend><?= __('Edit Proveedor') ?></legend>
        <?php
            echo $this->Form->input('codigo');
            echo $this->Form->input('razon_social');
            echo $this->Form->input('domicilio');
            echo $this->Form->input('codigo_postal');
            echo $this->Form->input('provincia_id', ['options' => $provincias, 'empty' => true]);
            echo $this->Form->input('localidad_id', ['options' => $localidads, 'empty' => true]);
            echo $this->Form->input('cuit');
            echo $this->Form->input('categoria');
            echo $this->Form->input('separa_transfer');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
