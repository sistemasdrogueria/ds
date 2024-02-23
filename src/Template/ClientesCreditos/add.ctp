<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Clientes Creditos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="clientesCreditos form large-10 medium-9 columns">
    <?= $this->Form->create($clientesCredito) ?>
    <fieldset>
        <legend><?= __('Add Clientes Credito') ?></legend>
        <?php
            echo $this->Form->input('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->input('credito_maximo');
            echo $this->Form->input('credito_consumo');
            echo $this->Form->input('credito_tipo');
            echo $this->Form->input('fecha');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
