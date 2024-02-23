<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Reclamos Items'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Reclamos'), ['controller' => 'Reclamos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamo'), ['controller' => 'Reclamos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="reclamosItems form large-10 medium-9 columns">
    <?= $this->Form->create($reclamosItem); ?>
    <fieldset>
        <legend><?= __('Add Reclamos Item') ?></legend>
        <?php
            echo $this->Form->input('reclamo_id', ['options' => $reclamos]);
            echo $this->Form->input('articulo_id', ['options' => $articulos]);
            echo $this->Form->input('cantidad');
            echo $this->Form->input('detalle');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
