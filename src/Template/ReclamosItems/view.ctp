<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Reclamos Item'), ['action' => 'edit', $reclamosItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reclamos Item'), ['action' => 'delete', $reclamosItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamosItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reclamos Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamos Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reclamos'), ['controller' => 'Reclamos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamo'), ['controller' => 'Reclamos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="reclamosItems view large-10 medium-9 columns">
    <h2><?= h($reclamosItem->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Reclamo') ?></h6>
            <p><?= $reclamosItem->has('reclamo') ? $this->Html->link($reclamosItem->reclamo->id, ['controller' => 'Reclamos', 'action' => 'view', $reclamosItem->reclamo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Articulo') ?></h6>
            <p><?= $reclamosItem->has('articulo') ? $this->Html->link($reclamosItem->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $reclamosItem->articulo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Detalle') ?></h6>
            <p><?= h($reclamosItem->detalle) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($reclamosItem->id) ?></p>
            <h6 class="subheader"><?= __('Cantidad') ?></h6>
            <p><?= $this->Number->format($reclamosItem->cantidad) ?></p>
        </div>
    </div>
</div>
