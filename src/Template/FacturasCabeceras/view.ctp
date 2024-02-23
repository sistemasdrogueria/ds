<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Facturas Cabecera'), ['action' => 'edit', $facturasCabecera->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Facturas Cabecera'), ['action' => 'delete', $facturasCabecera->id], ['confirm' => __('Are you sure you want to delete # {0}?', $facturasCabecera->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Facturas Cabeceras'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facturas Cabecera'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comprobantes'), ['controller' => 'Comprobantes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comprobante'), ['controller' => 'Comprobantes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="facturasCabeceras view large-10 medium-9 columns">
    <h2><?= h($facturasCabecera->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $facturasCabecera->has('cliente') ? $this->Html->link($facturasCabecera->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $facturasCabecera->cliente->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Letra') ?></h6>
            <p><?= h($facturasCabecera->letra) ?></p>
            <h6 class="subheader"><?= __('Comprobante') ?></h6>
            <p><?= $facturasCabecera->has('comprobante') ? $this->Html->link($facturasCabecera->comprobante->id, ['controller' => 'Comprobantes', 'action' => 'view', $facturasCabecera->comprobante->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Pedido Tipo') ?></h6>
            <p><?= h($facturasCabecera->pedido_tipo) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->id) ?></p>
            <h6 class="subheader"><?= __('Pedido Ds') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->pedido_ds) ?></p>
            <h6 class="subheader"><?= __('Imp Exento') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->imp_exento) ?></p>
            <h6 class="subheader"><?= __('Imp Gravado') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->imp_gravado) ?></p>
            <h6 class="subheader"><?= __('Imp Iva') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->imp_iva) ?></p>
            <h6 class="subheader"><?= __('Imp Rg3337') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->imp_rg3337) ?></p>
            <h6 class="subheader"><?= __('Imp Ingreso Bruto') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->imp_ingreso_bruto) ?></p>
            <h6 class="subheader"><?= __('Total') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->total) ?></p>
            <h6 class="subheader"><?= __('Total Items') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->total_items) ?></p>
            <h6 class="subheader"><?= __('Total Unidades') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->total_unidades) ?></p>
            <h6 class="subheader"><?= __('Estado') ?></h6>
            <p><?= $this->Number->format($facturasCabecera->estado) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha') ?></h6>
            <p><?= h($facturasCabecera->fecha) ?></p>
        </div>
    </div>
</div>
