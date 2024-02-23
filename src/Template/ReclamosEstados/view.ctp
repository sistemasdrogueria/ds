<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Reclamos Estado'), ['action' => 'edit', $reclamosEstado->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reclamos Estado'), ['action' => 'delete', $reclamosEstado->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamosEstado->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reclamos Estados'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamos Estado'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="reclamosEstados view large-10 medium-9 columns">
    <h2><?= h($reclamosEstado->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($reclamosEstado->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($reclamosEstado->id) ?></p>
        </div>
    </div>
</div>
