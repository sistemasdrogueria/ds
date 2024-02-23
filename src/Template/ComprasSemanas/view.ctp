<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Compras Semana'), ['action' => 'edit', $comprasSemana->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Compras Semana'), ['action' => 'delete', $comprasSemana->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comprasSemana->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Compras Semanas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Compras Semana'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="comprasSemanas view large-10 medium-9 columns">
    <h2><?= h($comprasSemana->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Tipo') ?></h6>
            <p><?= h($comprasSemana->tipo) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($comprasSemana->id) ?></p>
            <h6 class="subheader"><?= __('Codigo') ?></h6>
            <p><?= $this->Number->format($comprasSemana->codigo) ?></p>
            <h6 class="subheader"><?= __('Numero') ?></h6>
            <p><?= $this->Number->format($comprasSemana->numero) ?></p>
            <h6 class="subheader"><?= __('Importe') ?></h6>
            <p><?= $this->Number->format($comprasSemana->importe) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha Factura') ?></h6>
            <p><?= h($comprasSemana->fecha_factura) ?></p>
            <h6 class="subheader"><?= __('Fecha Vencimiento') ?></h6>
            <p><?= h($comprasSemana->fecha_vencimiento) ?></p>
        </div>
    </div>
</div>
