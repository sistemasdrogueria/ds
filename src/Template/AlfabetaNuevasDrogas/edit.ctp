<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaNuevasDroga $alfabetaNuevasDroga
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaNuevasDroga->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaNuevasDroga->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Nuevas Drogas'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="alfabetaNuevasDrogas form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaNuevasDroga) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Nuevas Droga') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
