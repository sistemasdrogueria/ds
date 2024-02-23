<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Ctacte Documento Cartera'), ['action' => 'edit', $ctacteDocumentoCartera->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Documento Cartera'), ['action' => 'delete', $ctacteDocumentoCartera->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteDocumentoCartera->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Documento Carteras'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Documento Cartera'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="ctacteDocumentoCarteras view large-10 medium-9 columns">
    <h2><?= h($ctacteDocumentoCartera->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $ctacteDocumentoCartera->has('cliente') ? $this->Html->link($ctacteDocumentoCartera->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $ctacteDocumentoCartera->cliente->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($ctacteDocumentoCartera->id) ?></p>
            <h6 class="subheader"><?= __('Nro Cheque') ?></h6>
            <p><?= $this->Number->format($ctacteDocumentoCartera->nro_cheque) ?></p>
            <h6 class="subheader"><?= __('Importe') ?></h6>
            <p><?= $this->Number->format($ctacteDocumentoCartera->importe) ?></p>
            <h6 class="subheader"><?= __('Origen') ?></h6>
            <p><?= $this->Number->format($ctacteDocumentoCartera->origen) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha Deposito') ?></h6>
            <p><?= h($ctacteDocumentoCartera->fecha_deposito) ?></p>
            <h6 class="subheader"><?= __('Fecha Ingreso') ?></h6>
            <p><?= h($ctacteDocumentoCartera->fecha_ingreso) ?></p>
        </div>
    </div>
</div>
