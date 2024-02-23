<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clima $clima
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clima->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clima->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Climas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Transportes'), ['controller' => 'Transportes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Transporte'), ['controller' => 'Transportes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Localidads'), ['controller' => 'Localidads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Localidad'), ['controller' => 'Localidads', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="climas form large-9 medium-8 columns content">
    <?= $this->Form->create($clima) ?>
    <fieldset>
        <legend><?= __('Edit Clima') ?></legend>
        <?php
            echo $this->Form->control('nombre');
            echo $this->Form->control('transporte_id', ['options' => $transportes, 'empty' => true]);
            echo $this->Form->control('localidad_id', ['options' => $localidads, 'empty' => true]);
            echo $this->Form->control('url');
            echo $this->Form->control('creado', ['empty' => true]);
            echo $this->Form->control('orden');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
