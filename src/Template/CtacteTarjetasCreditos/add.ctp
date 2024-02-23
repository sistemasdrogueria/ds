<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Ctacte Tarjetas Creditos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="ctacteTarjetasCreditos form large-10 medium-9 columns">
    <?= $this->Form->create($ctacteTarjetasCredito) ?>
    <fieldset>
        <legend><?= __('Add Ctacte Tarjetas Credito') ?></legend>
        <?php
            echo $this->Form->input('fecha_acreditacion', ['empty' => true, 'default' => '']);
            echo $this->Form->input('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->input('nro_liquidacion');
            echo $this->Form->input('fecha_ingreso', ['empty' => true, 'default' => '']);
            echo $this->Form->input('importe');
            echo $this->Form->input('detalle');
            echo $this->Form->input('nro_nota_credito');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
