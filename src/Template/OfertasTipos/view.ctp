<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Ofertas Tipo'), ['action' => 'edit', $ofertasTipo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ofertas Tipo'), ['action' => 'delete', $ofertasTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ofertasTipo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ofertas Tipos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ofertas Tipo'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="ofertasTipos view large-10 medium-9 columns">
    <h2><?= h($ofertasTipo->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($ofertasTipo->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($ofertasTipo->id) ?></p>
        </div>
    </div>
</div>
