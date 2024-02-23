<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Logs Accesos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="logsAccesos form large-10 medium-9 columns">
    <?= $this->Form->create($logsAcceso); ?>
    <fieldset>
        <legend><?= __('Add Logs Acceso') ?></legend>
        <?php
            echo $this->Form->input('fecha', array('empty' => true, 'default' => ''));
            echo $this->Form->input('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->input('usuario_id');
            echo $this->Form->input('ip');
            echo $this->Form->input('super');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
