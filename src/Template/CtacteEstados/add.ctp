<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Ctacte Estados'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Registros'), ['controller' => 'CtacteTipoRegistros', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ctacte Tipo Registro'), ['controller' => 'CtacteTipoRegistros', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="ctacteEstados form large-10 medium-9 columns">
    <?= $this->Form->create($ctacteEstado) ?>
    <fieldset>
        <legend><?= __('Add Ctacte Estado') ?></legend>
        <?php
            echo $this->Form->input('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->input('fecha_compra', ['empty' => true, 'default' => '']);
            echo $this->Form->input('fecha_vencimiento', ['empty' => true, 'default' => '']);
            echo $this->Form->input('importe');
            echo $this->Form->input('ctacte_tipo_registros_id', ['options' => $ctacteTipoRegistros, 'empty' => true]);
            echo $this->Form->input('signo');
            echo $this->Form->input('transfer');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
