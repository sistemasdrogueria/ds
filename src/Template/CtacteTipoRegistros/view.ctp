<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Ctacte Tipo Registro'), ['action' => 'edit', $ctacteTipoRegistro->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Tipo Registro'), ['action' => 'delete', $ctacteTipoRegistro->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTipoRegistro->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Registros'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Tipo Registro'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="ctacteTipoRegistros view large-10 medium-9 columns">
    <h2><?= h($ctacteTipoRegistro->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($ctacteTipoRegistro->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($ctacteTipoRegistro->id) ?></p>
            <h6 class="subheader"><?= __('Codigo') ?></h6>
            <p><?= $this->Number->format($ctacteTipoRegistro->codigo) ?></p>
        </div>
    </div>
</div>
