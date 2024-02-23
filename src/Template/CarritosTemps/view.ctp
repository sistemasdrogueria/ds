<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Carritos Temp'), ['action' => 'edit', $carritosTemp->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Carritos Temp'), ['action' => 'delete', $carritosTemp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carritosTemp->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Carritos Temps'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carritos Temp'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combos'), ['controller' => 'Combos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo'), ['controller' => 'Combos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="carritosTemps view large-10 medium-9 columns">
    <h2><?= h($carritosTemp->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $carritosTemp->has('cliente') ? $this->Html->link($carritosTemp->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $carritosTemp->cliente->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Articulo') ?></h6>
            <p><?= $carritosTemp->has('articulo') ? $this->Html->link($carritosTemp->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $carritosTemp->articulo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Descripcion') ?></h6>
            <p><?= h($carritosTemp->descripcion) ?></p>
            <h6 class="subheader"><?= __('Tipo Precio') ?></h6>
            <p><?= h($carritosTemp->tipo_precio) ?></p>
            <h6 class="subheader"><?= __('Plazoley Dcto') ?></h6>
            <p><?= h($carritosTemp->plazoley_dcto) ?></p>
            <h6 class="subheader"><?= __('Combo') ?></h6>
            <p><?= $carritosTemp->has('combo') ? $this->Html->link($carritosTemp->combo->id, ['controller' => 'Combos', 'action' => 'view', $carritosTemp->combo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Tipo Oferta') ?></h6>
            <p><?= h($carritosTemp->tipo_oferta) ?></p>
            <h6 class="subheader"><?= __('Tipo Oferta Elegida') ?></h6>
            <p><?= h($carritosTemp->tipo_oferta_elegida) ?></p>
            <h6 class="subheader"><?= __('Tipo Fact') ?></h6>
            <p><?= h($carritosTemp->tipo_fact) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($carritosTemp->id) ?></p>
            <h6 class="subheader"><?= __('Cantidad') ?></h6>
            <p><?= $this->Number->format($carritosTemp->cantidad) ?></p>
            <h6 class="subheader"><?= __('Precio Publico') ?></h6>
            <p><?= $this->Number->format($carritosTemp->precio_publico) ?></p>
            <h6 class="subheader"><?= __('Descuento') ?></h6>
            <p><?= $this->Number->format($carritosTemp->descuento) ?></p>
            <h6 class="subheader"><?= __('Unidad Minima') ?></h6>
            <p><?= $this->Number->format($carritosTemp->unidad_minima) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Creado') ?></h6>
            <p><?= h($carritosTemp->creado) ?></p>
            <h6 class="subheader"><?= __('Modificado') ?></h6>
            <p><?= h($carritosTemp->modificado) ?></p>
        </div>
    </div>
</div>
