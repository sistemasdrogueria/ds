<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Facturas Pedidos Item'), ['action' => 'edit', $facturasPedidosItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Facturas Pedidos Item'), ['action' => 'delete', $facturasPedidosItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $facturasPedidosItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Facturas Pedidos Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facturas Pedidos Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Facturas Pedidos'), ['controller' => 'FacturasPedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facturas Pedido'), ['controller' => 'FacturasPedidos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="facturasPedidosItems view large-10 medium-9 columns">
    <h2><?= h($facturasPedidosItem->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Facturas Pedido') ?></h6>
            <p><?= $facturasPedidosItem->has('facturas_pedido') ? $this->Html->link($facturasPedidosItem->facturas_pedido->id, ['controller' => 'FacturasPedidos', 'action' => 'view', $facturasPedidosItem->facturas_pedido->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($facturasPedidosItem->id) ?></p>
            <h6 class="subheader"><?= __('Nro Envio') ?></h6>
            <p><?= $this->Number->format($facturasPedidosItem->nro_envio) ?></p>
            <h6 class="subheader"><?= __('Cantidad Pedida') ?></h6>
            <p><?= $this->Number->format($facturasPedidosItem->cantidad_pedida) ?></p>
            <h6 class="subheader"><?= __('Cantidad Facturada') ?></h6>
            <p><?= $this->Number->format($facturasPedidosItem->cantidad_facturada) ?></p>
            <h6 class="subheader"><?= __('Precio Facturado') ?></h6>
            <p><?= $this->Number->format($facturasPedidosItem->precio_facturado) ?></p>
            <h6 class="subheader"><?= __('Desc Aplicado') ?></h6>
            <p><?= $this->Number->format($facturasPedidosItem->desc_aplicado) ?></p>
            <h6 class="subheader"><?= __('Nro Pedido Dsur') ?></h6>
            <p><?= $this->Number->format($facturasPedidosItem->nro_pedido_dsur) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Troquel') ?></h6>
            <?= $this->Text->autoParagraph(h($facturasPedidosItem->troquel)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Descripcion') ?></h6>
            <?= $this->Text->autoParagraph(h($facturasPedidosItem->descripcion)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Estado Stock') ?></h6>
            <?= $this->Text->autoParagraph(h($facturasPedidosItem->estado_stock)); ?>

        </div>
    </div>
</div>
