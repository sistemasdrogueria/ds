<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaArticulosEan $alfabetaArticulosEan
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaArticulosEan->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulosEan->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Eans'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaArticulosEans form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaArticulosEan) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Articulos Ean') ?></legend>
        <?php
            echo $this->Form->control('alfabeta_articulo_id', ['options' => $alfabetaArticulos, 'empty' => true]);
            echo $this->Form->control('codigo_barra');
            echo $this->Form->control('creado', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
