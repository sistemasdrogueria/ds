<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GruposTipo $gruposTipo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Grupos Tipos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="gruposTipos form large-9 medium-8 columns content">
    <?= $this->Form->create($gruposTipo) ?>
    <fieldset>
        <legend><?= __('Add Grupos Tipo') ?></legend>
        <?php
            echo $this->Form->control('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
