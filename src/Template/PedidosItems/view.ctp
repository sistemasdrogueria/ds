<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Pedidos Item'), ['action' => 'edit', $pedidosItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pedidos Item'), ['action' => 'delete', $pedidosItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pedidosItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedidos Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos'), ['controller' => 'Pedidos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedido'), ['controller' => 'Pedidos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combos'), ['controller' => 'Combos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo'), ['controller' => 'Combos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="pedidosItems view large-10 medium-9 columns">
    <h2><?= h($pedidosItem->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Pedido') ?></h6>
            <p><?= $pedidosItem->has('pedido') ? $this->Html->link($pedidosItem->pedido->id, ['controller' => 'Pedidos', 'action' => 'view', $pedidosItem->pedido->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Articulo') ?></h6>
            <p><?= $pedidosItem->has('articulo') ? $this->Html->link($pedidosItem->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $pedidosItem->articulo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Tipo Precio') ?></h6>
            <p><?= h($pedidosItem->tipo_precio) ?></p>
            <h6 class="subheader"><?= __('Plazoley Dcto') ?></h6>
            <p><?= h($pedidosItem->plazoley_dcto) ?></p>
            <h6 class="subheader"><?= __('Combo') ?></h6>
            <p><?= $pedidosItem->has('combo') ? $this->Html->link($pedidosItem->combo->id, ['controller' => 'Combos', 'action' => 'view', $pedidosItem->combo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Tipo Oferta') ?></h6>
            <p><?= h($pedidosItem->tipo_oferta) ?></p>
            <h6 class="subheader"><?= __('Tipo Oferta Elegida') ?></h6>
            <p><?= h($pedidosItem->tipo_oferta_elegida) ?></p>
            <h6 class="subheader"><?= __('Tipo Fact') ?></h6>
            <p><?= h($pedidosItem->tipo_fact) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($pedidosItem->id) ?></p>
            <h6 class="subheader"><?= __('Cantidad') ?></h6>
            <p><?= $this->Number->format($pedidosItem->cantidad) ?></p>
            <h6 class="subheader"><?= __('Precio Publico') ?></h6>
            <p><?= $this->Number->format($pedidosItem->precio_publico) ?></p>
            <h6 class="subheader"><?= __('Descuento') ?></h6>
            <p><?= $this->Number->format($pedidosItem->descuento) ?></p>
            <h6 class="subheader"><?= __('Unidad Minima') ?></h6>
            <p><?= $this->Number->format($pedidosItem->unidad_minima) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Agregado') ?></h6>
            <p><?= h($pedidosItem->agregado) ?></p>
        </div>
    </div>
</div>
