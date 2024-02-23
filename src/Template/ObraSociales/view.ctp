<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Obra Sociale'), ['action' => 'edit', $obraSociale->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Obra Sociale'), ['action' => 'delete', $obraSociale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $obraSociale->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Obra Sociales'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Obra Sociale'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="obraSociales view large-10 medium-9 columns">
    <h2><?= h($obraSociale->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($obraSociale->nombre) ?></p>
            <h6 class="subheader"><?= __('Nombrecompleto') ?></h6>
            <p><?= h($obraSociale->nombrecompleto) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($obraSociale->id) ?></p>
            <h6 class="subheader"><?= __('Codigo') ?></h6>
            <p><?= $this->Number->format($obraSociale->codigo) ?></p>
        </div>
    </div>
</div>
