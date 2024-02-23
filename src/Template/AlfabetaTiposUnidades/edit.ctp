<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaTiposUnidade $alfabetaTiposUnidade
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaTiposUnidade->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaTiposUnidade->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Tipos Unidades'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="alfabetaTiposUnidades form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaTiposUnidade) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Tipos Unidade') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
