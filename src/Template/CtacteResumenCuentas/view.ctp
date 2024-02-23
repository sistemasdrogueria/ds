<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Ctacte Resumen Semanale'), ['action' => 'edit', $ctacteResumenSemanale->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Resumen Semanale'), ['action' => 'delete', $ctacteResumenSemanale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteResumenSemanale->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Resumen Semanales'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Resumen Semanale'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="ctacteResumenSemanales view large-10 medium-9 columns">
    <h2><?= h($ctacteResumenSemanale->id) ?></h2>
    <div class="row">
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($ctacteResumenSemanale->id) ?></p>
            <h6 class="subheader"><?= __('Nro Sistema') ?></h6>
            <p><?= $this->Number->format($ctacteResumenSemanale->nro_sistema) ?></p>
            <h6 class="subheader"><?= __('Nro Semana') ?></h6>
            <p><?= $this->Number->format($ctacteResumenSemanale->nro_semana) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Desde') ?></h6>
            <p><?= h($ctacteResumenSemanale->desde) ?></p>
            <h6 class="subheader"><?= __('Hasta') ?></h6>
            <p><?= h($ctacteResumenSemanale->hasta) ?></p>
        </div>
    </div>
</div>
