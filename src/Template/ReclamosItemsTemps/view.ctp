<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Reclamos Items Temp'), ['action' => 'edit', $reclamosItemsTemp->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reclamos Items Temp'), ['action' => 'delete', $reclamosItemsTemp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamosItemsTemp->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reclamos Items Temps'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamos Items Temp'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="reclamosItemsTemps view large-10 medium-9 columns">
    <h2><?= h($reclamosItemsTemp->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $reclamosItemsTemp->has('cliente') ? $this->Html->link($reclamosItemsTemp->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $reclamosItemsTemp->cliente->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Articulo') ?></h6>
            <p><?= $reclamosItemsTemp->has('articulo') ? $this->Html->link($reclamosItemsTemp->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $reclamosItemsTemp->articulo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Detalle') ?></h6>
            <p><?= h($reclamosItemsTemp->detalle) ?></p>
            <h6 class="subheader"><?= __('Lote') ?></h6>
            <p><?= h($reclamosItemsTemp->lote) ?></p>
            <h6 class="subheader"><?= __('Serie') ?></h6>
            <p><?= h($reclamosItemsTemp->serie) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($reclamosItemsTemp->id) ?></p>
            <h6 class="subheader"><?= __('Cantidad') ?></h6>
            <p><?= $this->Number->format($reclamosItemsTemp->cantidad) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha Vencimiento') ?></h6>
            <p><?= h($reclamosItemsTemp->fecha_vencimiento) ?></p>
            <h6 class="subheader"><?= __('Creado') ?></h6>
            <p><?= h($reclamosItemsTemp->creado) ?></p>
        </div>
    </div>
</div>
