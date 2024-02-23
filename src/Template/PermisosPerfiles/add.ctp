<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Permisos Perfiles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Perfiles'), ['controller' => 'Perfiles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Perfile'), ['controller' => 'Perfiles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Permisos'), ['controller' => 'Permisos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Permiso'), ['controller' => 'Permisos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="permisosPerfiles form large-10 medium-9 columns">
    <?= $this->Form->create($permisosPerfile) ?>
    <fieldset>
        <legend><?= __('Add Permisos Perfile') ?></legend>
        <?php
            echo $this->Form->input('perfiles_id', ['options' => $perfiles]);
            echo $this->Form->input('permisos_id', ['options' => $permisos]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
