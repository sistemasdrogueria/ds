<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Ctacte Tarjetas Credito'), ['action' => 'edit', $ctacteTarjetasCredito->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Tarjetas Credito'), ['action' => 'delete', $ctacteTarjetasCredito->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTarjetasCredito->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Tarjetas Creditos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Tarjetas Credito'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="ctacteTarjetasCreditos view large-10 medium-9 columns">
    <h2><?= h($ctacteTarjetasCredito->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $ctacteTarjetasCredito->has('cliente') ? $this->Html->link($ctacteTarjetasCredito->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $ctacteTarjetasCredito->cliente->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Detalle') ?></h6>
            <p><?= h($ctacteTarjetasCredito->detalle) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($ctacteTarjetasCredito->id) ?></p>
            <h6 class="subheader"><?= __('Nro Liquidacion') ?></h6>
            <p><?= $this->Number->format($ctacteTarjetasCredito->nro_liquidacion) ?></p>
            <h6 class="subheader"><?= __('Importe') ?></h6>
            <p><?= $this->Number->format($ctacteTarjetasCredito->importe) ?></p>
            <h6 class="subheader"><?= __('Nro Nota Credito') ?></h6>
            <p><?= $this->Number->format($ctacteTarjetasCredito->nro_nota_credito) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha Acreditacion') ?></h6>
            <p><?= h($ctacteTarjetasCredito->fecha_acreditacion) ?></p>
            <h6 class="subheader"><?= __('Fecha Ingreso') ?></h6>
            <p><?= h($ctacteTarjetasCredito->fecha_ingreso) ?></p>
        </div>
    </div>
</div>
