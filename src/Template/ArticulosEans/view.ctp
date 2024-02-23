<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Articulos Ean'), ['action' => 'edit', $articulosEan->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Articulos Ean'), ['action' => 'delete', $articulosEan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articulosEan->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Articulos Eans'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulos Ean'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="articulosEans view large-10 medium-9 columns">
    <h2><?= h($articulosEan->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Articulo') ?></h6>
            <p><?= $articulosEan->has('articulo') ? $this->Html->link($articulosEan->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $articulosEan->articulo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Codigo Barra') ?></h6>
            <p><?= h($articulosEan->codigo_barra) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($articulosEan->id) ?></p>
        </div>
    </div>
</div>
