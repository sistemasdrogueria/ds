<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Comprobante'), ['action' => 'edit', $comprobante->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Comprobante'), ['action' => 'delete', $comprobante->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comprobante->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Comprobantes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comprobante'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="comprobantes view large-10 medium-9 columns">
    <h2><?= h($comprobante->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $comprobante->has('cliente') ? $this->Html->link($comprobante->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $comprobante->cliente->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($comprobante->id) ?></p>
            <h6 class="subheader"><?= __('Nota') ?></h6>
            <p><?= $this->Number->format($comprobante->nota) ?></p>
            <h6 class="subheader"><?= __('Seccion') ?></h6>
            <p><?= $this->Number->format($comprobante->seccion) ?></p>
            <h6 class="subheader"><?= __('Numero') ?></h6>
            <p><?= $this->Number->format($comprobante->numero) ?></p>
            <h6 class="subheader"><?= __('Importe') ?></h6>
            <p><?= $this->Number->format($comprobante->importe) ?></p>
            <h6 class="subheader"><?= __('Comprobante Tipo Id') ?></h6>
            <p><?= $this->Number->format($comprobante->comprobante_tipo_id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha') ?></h6>
            <p><?= h($comprobante->fecha) ?></p>
        </div>
    </div>
</div>
