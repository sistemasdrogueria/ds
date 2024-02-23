<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $laboratorio->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $laboratorio->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Laboratorios'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="laboratorios form large-10 medium-9 columns">
    <?= $this->Form->create($laboratorio); ?>
    <fieldset>
        <legend><?= __('Edit Laboratorio') ?></legend>
        <?php
            echo $this->Form->input('codigo');
            echo $this->Form->input('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
