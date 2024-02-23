<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Comprobantes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="comprobantes form large-10 medium-9 columns">
    <?= $this->Form->create($comprobante) ?>
    <fieldset>
        <legend><?= __('Add Comprobante') ?></legend>
        <?php
            echo $this->Form->input('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->input('fecha', ['empty' => true, 'default' => '']);
            echo $this->Form->input('nota');
            echo $this->Form->input('seccion');
            echo $this->Form->input('numero');
            echo $this->Form->input('importe');
            echo $this->Form->input('comprobante_tipo_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
