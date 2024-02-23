<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Ctacte Pagos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ctactePagos form large-9 medium-8 columns content">
    <?= $this->Form->create($ctactePago) ?>
    <fieldset>
        <legend><?= __('Add Ctacte Pago') ?></legend>
        <?php
            echo $this->Form->input('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->input('detalle');
            echo $this->Form->input('fecha_ingreso', ['empty' => true]);
            echo $this->Form->input('fecha_aplicacion', ['empty' => true]);
            echo $this->Form->input('nota');
            echo $this->Form->input('signo');
            echo $this->Form->input('importe');
            echo $this->Form->input('chequeo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
