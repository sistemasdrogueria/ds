<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaAccionesFar $alfabetaAccionesFar
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaAccionesFar->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaAccionesFar->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Acciones Fars'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="alfabetaAccionesFars form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaAccionesFar) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Acciones Far') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
