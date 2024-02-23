<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $facturasCabecera->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $facturasCabecera->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Facturas Cabeceras'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comprobantes'), ['controller' => 'Comprobantes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comprobante'), ['controller' => 'Comprobantes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="facturasCabeceras form large-10 medium-9 columns">
    <?= $this->Form->create($facturasCabecera) ?>
    <fieldset>
        <legend><?= __('Edit Facturas Cabecera') ?></legend>
        <?php
            echo $this->Form->input('fecha', ['empty' => true, 'default' => '']);
            echo $this->Form->input('cliente_id', ['options' => $clientes]);
            echo $this->Form->input('pedido_ds');
            echo $this->Form->input('letra');
            echo $this->Form->input('comprobante_id', ['options' => $comprobantes]);
            echo $this->Form->input('pedido_tipo');
            echo $this->Form->input('imp_exento');
            echo $this->Form->input('imp_gravado');
            echo $this->Form->input('imp_iva');
            echo $this->Form->input('imp_rg3337');
            echo $this->Form->input('imp_ingreso_bruto');
            echo $this->Form->input('total');
            echo $this->Form->input('total_items');
            echo $this->Form->input('total_unidades');
            echo $this->Form->input('estado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
