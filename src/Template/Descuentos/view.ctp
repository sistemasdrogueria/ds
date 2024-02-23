<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Descuento'), ['action' => 'edit', $descuento->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Descuento'), ['action' => 'delete', $descuento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $descuento->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Descuentos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Descuento'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="descuentos view large-10 medium-9 columns">
    <h2><?= h($descuento->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Articulo') ?></h6>
            <p><?= $descuento->has('articulo') ? $this->Html->link($descuento->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $descuento->articulo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Discrimina Iva') ?></h6>
            <p><?= h($descuento->discrimina_iva) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($descuento->id) ?></p>
            <h6 class="subheader"><?= __('Precio Costo') ?></h6>
            <p><?= $this->Number->format($descuento->precio_costo) ?></p>
            <h6 class="subheader"><?= __('Dto Patagonia') ?></h6>
            <p><?= $this->Number->format($descuento->dto_patagonia) ?></p>
            <h6 class="subheader"><?= __('Dto Drogueria') ?></h6>
            <p><?= $this->Number->format($descuento->dto_drogueria) ?></p>
            <h6 class="subheader"><?= __('Unidadfact') ?></h6>
            <p><?= $this->Number->format($descuento->unidadfact) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha Desde') ?></h6>
            <p><?= h($descuento->fecha_desde) ?></p>
            <h6 class="subheader"><?= __('Fecha Hasta') ?></h6>
            <p><?= h($descuento->fecha_hasta) ?></p>
        </div>
    </div>
</div>
