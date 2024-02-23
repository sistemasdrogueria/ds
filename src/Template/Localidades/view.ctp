<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Localidade'), ['action' => 'edit', $localidade->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Localidade'), ['action' => 'delete', $localidade->id], ['confirm' => __('Are you sure you want to delete # {0}?', $localidade->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Localidades'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Localidade'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="localidades view large-10 medium-9 columns">
    <h2><?= h($localidade->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Codigo') ?></h6>
            <p><?= h($localidade->codigo) ?></p>
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($localidade->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($localidade->id) ?></p>
        </div>
    </div>
</div>
