<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Impresora $impresora
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Impresoras'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="impresoras form large-9 medium-8 columns content">
    <?= $this->Form->create($impresora) ?>
    <fieldset>
        <legend><?= __('Add Impresora') ?></legend>
        <?php
            echo $this->Form->control('modelo');
            echo $this->Form->control('marca');
            echo $this->Form->control('sector');
            echo $this->Form->control('ip');
            echo $this->Form->control('sistema');
            echo $this->Form->control('creado', ['empty' => true]);
            echo $this->Form->control('modificado', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
