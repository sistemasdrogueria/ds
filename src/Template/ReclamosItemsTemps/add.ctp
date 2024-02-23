<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Reclamos Items Temps'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="reclamosItemsTemps form large-10 medium-9 columns">
    <?= $this->Form->create($reclamosItemsTemp) ?>
    <fieldset>
        <legend><?= __('Add Reclamos Items Temp') ?></legend>
        <?php
            echo $this->Form->input('cliente_id', ['options' => $clientes]);
            echo $this->Form->input('articulo_id', ['options' => $articulos]);
            echo $this->Form->input('cantidad');
            echo $this->Form->input('detalle');
            echo $this->Form->input('fecha_vencimiento', ['empty' => true, 'default' => '']);
            echo $this->Form->input('lote');
            echo $this->Form->input('serie');
            echo $this->Form->input('creado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
