<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaTiposVenta $alfabetaTiposVenta
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaTiposVenta->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaTiposVenta->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Tipos Ventas'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="alfabetaTiposVentas form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaTiposVenta) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Tipos Venta') ?></legend>
        <?php
            echo $this->Form->control('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
