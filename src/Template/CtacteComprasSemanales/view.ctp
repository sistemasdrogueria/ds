<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Ctacte Compras Semanale'), ['action' => 'edit', $ctacteComprasSemanale->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Compras Semanale'), ['action' => 'delete', $ctacteComprasSemanale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteComprasSemanale->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Compras Semanales'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Compras Semanale'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="ctacteComprasSemanales view large-10 medium-9 columns">
    <h2><?= h($ctacteComprasSemanale->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $ctacteComprasSemanale->has('cliente') ? $this->Html->link($ctacteComprasSemanale->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $ctacteComprasSemanale->cliente->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($ctacteComprasSemanale->id) ?></p>
            <h6 class="subheader"><?= __('Numero') ?></h6>
            <p><?= $this->Number->format($ctacteComprasSemanale->numero) ?></p>
            <h6 class="subheader"><?= __('Importe') ?></h6>
            <p><?= $this->Number->format($ctacteComprasSemanale->importe) ?></p>
            <h6 class="subheader"><?= __('Tipo') ?></h6>
            <p><?= $this->Number->format($ctacteComprasSemanale->tipo) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha Factura') ?></h6>
            <p><?= h($ctacteComprasSemanale->fecha_factura) ?></p>
            <h6 class="subheader"><?= __('Fecha Vencimiento') ?></h6>
            <p><?= h($ctacteComprasSemanale->fecha_vencimiento) ?></p>
        </div>
    </div>
</div>
