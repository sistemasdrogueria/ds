<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaUnidadesPotencia $alfabetaUnidadesPotencia
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaUnidadesPotencia->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaUnidadesPotencia->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Unidades Potencias'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="alfabetaUnidadesPotencias form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaUnidadesPotencia) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Unidades Potencia') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
