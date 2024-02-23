<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LogsEstadistica $logsEstadistica
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $logsEstadistica->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $logsEstadistica->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Logs Estadisticas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Permisos'), ['controller' => 'Permisos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Permiso'), ['controller' => 'Permisos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="logsEstadisticas form large-9 medium-8 columns content">
    <?= $this->Form->create($logsEstadistica) ?>
    <fieldset>
        <legend><?= __('Edit Logs Estadistica') ?></legend>
        <?php
            echo $this->Form->control('fecha', ['empty' => true]);
            echo $this->Form->control('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('ip');
            echo $this->Form->control('super');
            echo $this->Form->control('seccion');
            echo $this->Form->control('permiso_id', ['options' => $permisos, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
