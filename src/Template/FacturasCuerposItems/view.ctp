<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Facturas Cuerpos Item'), ['action' => 'edit', $facturasCuerposItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Facturas Cuerpos Item'), ['action' => 'delete', $facturasCuerposItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $facturasCuerposItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Facturas Cuerpos Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facturas Cuerpos Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Facturas Cabeceras'), ['controller' => 'FacturasCabeceras', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facturas Cabecera'), ['controller' => 'FacturasCabeceras', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="facturasCuerposItems view large-10 medium-9 columns">
    <h2><?= h($facturasCuerposItem->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Facturas Cabecera') ?></h6>
            <p><?= $facturasCuerposItem->has('facturas_cabecera') ? $this->Html->link($facturasCuerposItem->facturas_cabecera->id, ['controller' => 'FacturasCabeceras', 'action' => 'view', $facturasCuerposItem->facturas_cabecera->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Articulo') ?></h6>
            <p><?= $facturasCuerposItem->has('articulo') ? $this->Html->link($facturasCuerposItem->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $facturasCuerposItem->articulo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Descripcion') ?></h6>
            <p><?= h($facturasCuerposItem->descripcion) ?></p>
            <h6 class="subheader"><?= __('Troquel') ?></h6>
            <p><?= h($facturasCuerposItem->troquel) ?></p>
            <h6 class="subheader"><?= __('Codigo Barra') ?></h6>
            <p><?= h($facturasCuerposItem->codigo_barra) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($facturasCuerposItem->id) ?></p>
            <h6 class="subheader"><?= __('Pedido Ds') ?></h6>
            <p><?= $this->Number->format($facturasCuerposItem->pedido_ds) ?></p>
            <h6 class="subheader"><?= __('Cantidad Facturada') ?></h6>
            <p><?= $this->Number->format($facturasCuerposItem->cantidad_facturada) ?></p>
            <h6 class="subheader"><?= __('Precio Unitario') ?></h6>
            <p><?= $this->Number->format($facturasCuerposItem->precio_unitario) ?></p>
            <h6 class="subheader"><?= __('Precio Publico') ?></h6>
            <p><?= $this->Number->format($facturasCuerposItem->precio_publico) ?></p>
            <h6 class="subheader"><?= __('Precio Total') ?></h6>
            <p><?= $this->Number->format($facturasCuerposItem->precio_total) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Iva') ?></h6>
            <p><?= $facturasCuerposItem->iva ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
