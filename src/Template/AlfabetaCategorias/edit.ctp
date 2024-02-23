<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaCategoria $alfabetaCategoria
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaCategoria->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaCategoria->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Categorias'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaCategorias form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaCategoria) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Categoria') ?></legend>
        <?php
            echo $this->Form->control('codigo');
            echo $this->Form->control('nombre');
            echo $this->Form->control('descripcion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
