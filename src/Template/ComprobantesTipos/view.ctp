<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Comprobantes Tipo'), ['action' => 'edit', $comprobantesTipo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Comprobantes Tipo'), ['action' => 'delete', $comprobantesTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comprobantesTipo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Comprobantes Tipos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comprobantes Tipo'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="comprobantesTipos view large-10 medium-9 columns">
    <h2><?= h($comprobantesTipo->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($comprobantesTipo->nombre) ?></p>
            <h6 class="subheader"><?= __('Tipo') ?></h6>
            <p><?= h($comprobantesTipo->tipo) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($comprobantesTipo->id) ?></p>
        </div>
    </div>
</div>
