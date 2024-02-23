<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ctacteObrasSocialesHistorico->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteObrasSocialesHistorico->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ctacte Obras Sociales Historicos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ctacteObrasSocialesHistoricos form large-9 medium-8 columns content">
    <?= $this->Form->create($ctacteObrasSocialesHistorico) ?>
    <fieldset>
        <legend><?= __('Edit Ctacte Obras Sociales Historico') ?></legend>
        <?php
            echo $this->Form->control('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->control('fecha', ['empty' => true]);
            echo $this->Form->control('importe');
            echo $this->Form->control('obra_social_id');
            echo $this->Form->control('nro_nota');
            echo $this->Form->control('tipo_nota');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
