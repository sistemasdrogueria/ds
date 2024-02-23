<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $facturasPedido->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $facturasPedido->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Facturas Pedidos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos'), ['controller' => 'Pedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedido'), ['controller' => 'Pedidos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="facturasPedidos form large-10 medium-9 columns">
    <?= $this->Form->create($facturasPedido); ?>
    <fieldset>
        <legend><?= __('Edit Facturas Pedido') ?></legend>
        <?php
            echo $this->Form->input('cliente_id', ['options' => $clientes]);
            echo $this->Form->input('pedido_id', ['options' => $pedidos, 'empty' => true]);
            echo $this->Form->input('pedido_fecha', array('empty' => true, 'default' => ''));
            echo $this->Form->input('pedido_ds_numero');
            echo $this->Form->input('pedido_tipo');
            echo $this->Form->input('envio_numero');
            echo $this->Form->input('envio_fecha', array('empty' => true, 'default' => ''));
            echo $this->Form->input('recibido_fecha', array('empty' => true, 'default' => ''));
            echo $this->Form->input('estado');
            echo $this->Form->input('codigo_operadora');
            echo $this->Form->input('remito_numero');
            echo $this->Form->input('factura_numero');
            echo $this->Form->input('factura_fecha', array('empty' => true, 'default' => ''));
            echo $this->Form->input('factura_tipo_elegida');
            echo $this->Form->input('factura_tipo_aplicada');
            echo $this->Form->input('factura_tipo_elegida_descuento');
            echo $this->Form->input('factura_tipo_aplicada_descuento');
            echo $this->Form->input('factura_tipo_elegida_vencimiento', array('empty' => true, 'default' => ''));
            echo $this->Form->input('factura_tipo_aplicada_vencimiento', array('empty' => true, 'default' => ''));
            echo $this->Form->input('combo');
            echo $this->Form->input('combo_fecha_vigencia', array('empty' => true, 'default' => ''));
            echo $this->Form->input('mensaje');
            echo $this->Form->input('mensaje_pedido');
            echo $this->Form->input('exento_total');
            echo $this->Form->input('exento_descuento');
            echo $this->Form->input('gravado_total');
            echo $this->Form->input('gravado_descuento');
            echo $this->Form->input('iva');
            echo $this->Form->input('perc_rg3337');
            echo $this->Form->input('ingreso_brutos');
            echo $this->Form->input('total');
            echo $this->Form->input('total_items');
            echo $this->Form->input('total_unidades');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
