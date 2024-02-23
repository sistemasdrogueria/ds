<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaTamano $alfabetaTamano
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaTamano->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaTamano->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Tamanos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Extras'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Extra'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaTamanos form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaTamano) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Tamano') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
