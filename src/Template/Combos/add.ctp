<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Combos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Carritos Items'), ['controller' => 'CarritosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carritos Item'), ['controller' => 'CarritosItems', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos Items'), ['controller' => 'PedidosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedidos Item'), ['controller' => 'PedidosItems', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="combos form large-10 medium-9 columns">
    <?= $this->Form->create($combo); ?>
    <fieldset>
        <legend><?= __('Add Combo') ?></legend>
        <?php
            echo $this->Form->input('nombre');
            echo $this->Form->input('desde', array('empty' => true, 'default' => ''));
            echo $this->Form->input('hasta', array('empty' => true, 'default' => ''));
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
