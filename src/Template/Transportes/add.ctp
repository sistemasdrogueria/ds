<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transporte $transporte
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Transportes'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="transportes form large-9 medium-8 columns content">
    <?= $this->Form->create($transporte) ?>
    <fieldset>
        <legend><?= __('Add Transporte') ?></legend>
        <?php
            echo $this->Form->control('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
