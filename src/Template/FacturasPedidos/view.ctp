<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Facturas Pedido'), ['action' => 'edit', $facturasPedido->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Facturas Pedido'), ['action' => 'delete', $facturasPedido->id], ['confirm' => __('Are you sure you want to delete # {0}?', $facturasPedido->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Facturas Pedidos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facturas Pedido'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos'), ['controller' => 'Pedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedido'), ['controller' => 'Pedidos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="facturasPedidos view large-10 medium-9 columns">
    <h2><?= h($facturasPedido->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $facturasPedido->has('cliente') ? $this->Html->link($facturasPedido->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $facturasPedido->cliente->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Pedido') ?></h6>
            <p><?= $facturasPedido->has('pedido') ? $this->Html->link($facturasPedido->pedido->id, ['controller' => 'Pedidos', 'action' => 'view', $facturasPedido->pedido->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($facturasPedido->id) ?></p>
            <h6 class="subheader"><?= __('Pedido Ds Numero') ?></h6>
            <p><?= $this->Number->format($facturasPedido->pedido_ds_numero) ?></p>
            <h6 class="subheader"><?= __('Envio Numero') ?></h6>
            <p><?= $this->Number->format($facturasPedido->envio_numero) ?></p>
            <h6 class="subheader"><?= __('Codigo Operadora') ?></h6>
            <p><?= $this->Number->format($facturasPedido->codigo_operadora) ?></p>
            <h6 class="subheader"><?= __('Remito Numero') ?></h6>
            <p><?= $this->Number->format($facturasPedido->remito_numero) ?></p>
            <h6 class="subheader"><?= __('Factura Numero') ?></h6>
            <p><?= $this->Number->format($facturasPedido->factura_numero) ?></p>
            <h6 class="subheader"><?= __('Factura Tipo Elegida Descuento') ?></h6>
            <p><?= $this->Number->format($facturasPedido->factura_tipo_elegida_descuento) ?></p>
            <h6 class="subheader"><?= __('Factura Tipo Aplicada Descuento') ?></h6>
            <p><?= $this->Number->format($facturasPedido->factura_tipo_aplicada_descuento) ?></p>
            <h6 class="subheader"><?= __('Exento Total') ?></h6>
            <p><?= $this->Number->format($facturasPedido->exento_total) ?></p>
            <h6 class="subheader"><?= __('Exento Descuento') ?></h6>
            <p><?= $this->Number->format($facturasPedido->exento_descuento) ?></p>
            <h6 class="subheader"><?= __('Gravado Total') ?></h6>
            <p><?= $this->Number->format($facturasPedido->gravado_total) ?></p>
            <h6 class="subheader"><?= __('Gravado Descuento') ?></h6>
            <p><?= $this->Number->format($facturasPedido->gravado_descuento) ?></p>
            <h6 class="subheader"><?= __('Iva') ?></h6>
            <p><?= $this->Number->format($facturasPedido->iva) ?></p>
            <h6 class="subheader"><?= __('Perc Rg3337') ?></h6>
            <p><?= $this->Number->format($facturasPedido->perc_rg3337) ?></p>
            <h6 class="subheader"><?= __('Ingreso Brutos') ?></h6>
            <p><?= $this->Number->format($facturasPedido->ingreso_brutos) ?></p>
            <h6 class="subheader"><?= __('Total') ?></h6>
            <p><?= $this->Number->format($facturasPedido->total) ?></p>
            <h6 class="subheader"><?= __('Total Items') ?></h6>
            <p><?= $this->Number->format($facturasPedido->total_items) ?></p>
            <h6 class="subheader"><?= __('Total Unidades') ?></h6>
            <p><?= $this->Number->format($facturasPedido->total_unidades) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Pedido Fecha') ?></h6>
            <p><?= h($facturasPedido->pedido_fecha) ?></p>
            <h6 class="subheader"><?= __('Envio Fecha') ?></h6>
            <p><?= h($facturasPedido->envio_fecha) ?></p>
            <h6 class="subheader"><?= __('Recibido Fecha') ?></h6>
            <p><?= h($facturasPedido->recibido_fecha) ?></p>
            <h6 class="subheader"><?= __('Factura Fecha') ?></h6>
            <p><?= h($facturasPedido->factura_fecha) ?></p>
            <h6 class="subheader"><?= __('Factura Tipo Elegida Vencimiento') ?></h6>
            <p><?= h($facturasPedido->factura_tipo_elegida_vencimiento) ?></p>
            <h6 class="subheader"><?= __('Factura Tipo Aplicada Vencimiento') ?></h6>
            <p><?= h($facturasPedido->factura_tipo_aplicada_vencimiento) ?></p>
            <h6 class="subheader"><?= __('Combo Fecha Vigencia') ?></h6>
            <p><?= h($facturasPedido->combo_fecha_vigencia) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Pedido Tipo') ?></h6>
            <?= $this->Text->autoParagraph(h($facturasPedido->pedido_tipo)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <?= $this->Text->autoParagraph(h($facturasPedido->estado)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Factura Tipo Elegida') ?></h6>
            <?= $this->Text->autoParagraph(h($facturasPedido->factura_tipo_elegida)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Factura Tipo Aplicada') ?></h6>
            <?= $this->Text->autoParagraph(h($facturasPedido->factura_tipo_aplicada)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Combo') ?></h6>
            <?= $this->Text->autoParagraph(h($facturasPedido->combo)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Mensaje') ?></h6>
            <?= $this->Text->autoParagraph(h($facturasPedido->mensaje)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Mensaje Pedido') ?></h6>
            <?= $this->Text->autoParagraph(h($facturasPedido->mensaje_pedido)); ?>

        </div>
    </div>
</div>
