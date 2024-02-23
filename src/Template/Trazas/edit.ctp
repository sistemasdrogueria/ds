<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $traza->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $traza->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Trazas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="trazas form large-10 medium-9 columns">
    <?= $this->Form->create($traza) ?>
    <fieldset>
        <legend><?= __('Edit Traza') ?></legend>
        <?php
            echo $this->Form->input('nota');
            echo $this->Form->input('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->input('serie');
            echo $this->Form->input('lote');
            echo $this->Form->input('vencimiento', ['empty' => true, 'default' => '']);
            echo $this->Form->input('cod_transaccion');
            echo $this->Form->input('fecha', ['empty' => true, 'default' => '']);
            echo $this->Form->input('cliente_id', ['options' => $clientes, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
