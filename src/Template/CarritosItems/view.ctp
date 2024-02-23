<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Carritos Item'), ['action' => 'edit', $carritosItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Carritos Item'), ['action' => 'delete', $carritosItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carritosItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Carritos Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carritos Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carritos'), ['controller' => 'Carritos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carrito'), ['controller' => 'Carritos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combos'), ['controller' => 'Combos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo'), ['controller' => 'Combos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="carritosItems view large-10 medium-9 columns">
    <h2><?= h($carritosItem->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Carrito') ?></h6>
            <p><?= $carritosItem->has('carrito') ? $this->Html->link($carritosItem->carrito->id, ['controller' => 'Carritos', 'action' => 'view', $carritosItem->carrito->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Articulo') ?></h6>
            <p><?= $carritosItem->has('articulo') ? $this->Html->link($carritosItem->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $carritosItem->articulo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Tipo Precio') ?></h6>
            <p><?= h($carritosItem->tipo_precio) ?></p>
            <h6 class="subheader"><?= __('Plazoley Dcto') ?></h6>
            <p><?= h($carritosItem->plazoley_dcto) ?></p>
            <h6 class="subheader"><?= __('Combo') ?></h6>
            <p><?= $carritosItem->has('combo') ? $this->Html->link($carritosItem->combo->id, ['controller' => 'Combos', 'action' => 'view', $carritosItem->combo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Tipo Oferta') ?></h6>
            <p><?= h($carritosItem->tipo_oferta) ?></p>
            <h6 class="subheader"><?= __('Tipo Oferta Elegida') ?></h6>
            <p><?= h($carritosItem->tipo_oferta_elegida) ?></p>
            <h6 class="subheader"><?= __('Tipo Fact') ?></h6>
            <p><?= h($carritosItem->tipo_fact) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($carritosItem->id) ?></p>
            <h6 class="subheader"><?= __('Cantidad') ?></h6>
            <p><?= $this->Number->format($carritosItem->cantidad) ?></p>
            <h6 class="subheader"><?= __('Precio Publico') ?></h6>
            <p><?= $this->Number->format($carritosItem->precio_publico) ?></p>
            <h6 class="subheader"><?= __('Descuento') ?></h6>
            <p><?= $this->Number->format($carritosItem->descuento) ?></p>
            <h6 class="subheader"><?= __('Unidad Minima') ?></h6>
            <p><?= $this->Number->format($carritosItem->unidad_minima) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Agregado') ?></h6>
            <p><?= h($carritosItem->agregado) ?></p>
        </div>
    </div>
</div>
