<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Reclamos Tipos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Reclamos'), ['controller' => 'Reclamos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamo'), ['controller' => 'Reclamos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="reclamosTipos form large-10 medium-9 columns">
    <?= $this->Form->create($reclamosTipo); ?>
    <fieldset>
        <legend><?= __('Add Reclamos Tipo') ?></legend>
        <?php
            echo $this->Form->input('nombre', array('empty' => true, 'default' => ''));
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
