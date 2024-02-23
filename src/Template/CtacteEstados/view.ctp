<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Ctacte Estado'), ['action' => 'edit', $ctacteEstado->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Estado'), ['action' => 'delete', $ctacteEstado->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteEstado->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Estados'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Estado'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Registros'), ['controller' => 'CtacteTipoRegistros', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Tipo Registro'), ['controller' => 'CtacteTipoRegistros', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="ctacteEstados view large-10 medium-9 columns">
    <h2><?= h($ctacteEstado->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $ctacteEstado->has('cliente') ? $this->Html->link($ctacteEstado->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $ctacteEstado->cliente->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Ctacte Tipo Registro') ?></h6>
            <p><?= $ctacteEstado->has('ctacte_tipo_registro') ? $this->Html->link($ctacteEstado->ctacte_tipo_registro->id, ['controller' => 'CtacteTipoRegistros', 'action' => 'view', $ctacteEstado->ctacte_tipo_registro->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($ctacteEstado->id) ?></p>
            <h6 class="subheader"><?= __('Importe') ?></h6>
            <p><?= $this->Number->format($ctacteEstado->importe) ?></p>
            <h6 class="subheader"><?= __('Signo') ?></h6>
            <p><?= $this->Number->format($ctacteEstado->signo) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha Compra') ?></h6>
            <p><?= h($ctacteEstado->fecha_compra) ?></p>
            <h6 class="subheader"><?= __('Fecha Vencimiento') ?></h6>
            <p><?= h($ctacteEstado->fecha_vencimiento) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Transfer') ?></h6>
            <p><?= $ctacteEstado->transfer ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
