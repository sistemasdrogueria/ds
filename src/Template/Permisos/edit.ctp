<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $permiso->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $permiso->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Permisos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Perfiles'), ['controller' => 'Perfiles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Perfile'), ['controller' => 'Perfiles', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="permisos form large-10 medium-9 columns">
    <?= $this->Form->create($permiso) ?>
    <fieldset>
        <legend><?= __('Edit Permiso') ?></legend>
        <?php
            echo $this->Form->input('clase');
            echo $this->Form->input('nombre');
            echo $this->Form->input('perfiles._ids', ['options' => $perfiles]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
