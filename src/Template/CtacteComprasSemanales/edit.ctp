<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ctacteComprasSemanale->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteComprasSemanale->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ctacte Compras Semanales'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="ctacteComprasSemanales form large-10 medium-9 columns">
    <?= $this->Form->create($ctacteComprasSemanale) ?>
    <fieldset>
        <legend><?= __('Edit Ctacte Compras Semanale') ?></legend>
        <?php
            echo $this->Form->input('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->input('numero');
            echo $this->Form->input('fecha_factura', ['empty' => true, 'default' => '']);
            echo $this->Form->input('importe');
            echo $this->Form->input('tipo');
            echo $this->Form->input('fecha_vencimiento', ['empty' => true, 'default' => '']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
