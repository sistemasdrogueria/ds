<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaVia $alfabetaVia
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaVia->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaVia->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Vias'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="alfabetaVias form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaVia) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Via') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
