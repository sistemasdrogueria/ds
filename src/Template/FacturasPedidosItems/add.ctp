<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Facturas Pedidos Items'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Facturas Pedidos'), ['controller' => 'FacturasPedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facturas Pedido'), ['controller' => 'FacturasPedidos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="facturasPedidosItems form large-10 medium-9 columns">
    <?= $this->Form->create($facturasPedidosItem); ?>
    <fieldset>
        <legend><?= __('Add Facturas Pedidos Item') ?></legend>
        <?php
            echo $this->Form->input('facturas_pedido_id', ['options' => $facturasPedidos]);
            echo $this->Form->input('nro_envio');
            echo $this->Form->input('troquel');
            echo $this->Form->input('descripcion');
            echo $this->Form->input('cantidad_pedida');
            echo $this->Form->input('cantidad_facturada');
            echo $this->Form->input('precio_facturado');
            echo $this->Form->input('desc_aplicado');
            echo $this->Form->input('estado_stock');
            echo $this->Form->input('nro_pedido_dsur');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
