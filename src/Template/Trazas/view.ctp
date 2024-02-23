<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Traza'), ['action' => 'edit', $traza->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Traza'), ['action' => 'delete', $traza->id], ['confirm' => __('Are you sure you want to delete # {0}?', $traza->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Trazas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Traza'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="trazas view large-10 medium-9 columns">
    <h2><?= h($traza->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Articulo') ?></h6>
            <p><?= $traza->has('articulo') ? $this->Html->link($traza->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $traza->articulo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Serie') ?></h6>
            <p><?= h($traza->serie) ?></p>
            <h6 class="subheader"><?= __('Lote') ?></h6>
            <p><?= h($traza->lote) ?></p>
            <h6 class="subheader"><?= __('Cod Transaccion') ?></h6>
            <p><?= h($traza->cod_transaccion) ?></p>
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $traza->has('cliente') ? $this->Html->link($traza->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $traza->cliente->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($traza->id) ?></p>
            <h6 class="subheader"><?= __('Nota') ?></h6>
            <p><?= $this->Number->format($traza->nota) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Vencimiento') ?></h6>
            <p><?= h($traza->vencimiento) ?></p>
            <h6 class="subheader"><?= __('Fecha') ?></h6>
            <p><?= h($traza->fecha) ?></p>
        </div>
    </div>
</div>
