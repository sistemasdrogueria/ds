<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FacturasCuerposItemsLotesVcto $facturasCuerposItemsLotesVcto
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $facturasCuerposItemsLotesVcto->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $facturasCuerposItemsLotesVcto->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Facturas Cuerpos Items Lotes Vctos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="facturasCuerposItemsLotesVctos form large-9 medium-8 columns content">
    <?= $this->Form->create($facturasCuerposItemsLotesVcto) ?>
    <fieldset>
        <legend><?= __('Edit Facturas Cuerpos Items Lotes Vcto') ?></legend>
        <?php
            echo $this->Form->control('nota');
            echo $this->Form->control('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->control('serie');
            echo $this->Form->control('lote');
            echo $this->Form->control('vencimiento', ['empty' => true]);
            echo $this->Form->control('cantidad');
            echo $this->Form->control('fecha', ['empty' => true]);
            echo $this->Form->control('cliente_id', ['options' => $clientes, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
