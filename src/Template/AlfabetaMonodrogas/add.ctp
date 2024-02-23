<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaMonodroga $alfabetaMonodroga
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Monodrogas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Extras'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Extra'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaMonodrogas form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaMonodroga) ?>
    <fieldset>
        <legend><?= __('Add Alfabeta Monodroga') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
