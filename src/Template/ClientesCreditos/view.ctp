<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Clientes Credito'), ['action' => 'edit', $clientesCredito->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Clientes Credito'), ['action' => 'delete', $clientesCredito->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientesCredito->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Clientes Creditos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Clientes Credito'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="clientesCreditos view large-10 medium-9 columns">
    <h2><?= h($clientesCredito->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $clientesCredito->has('cliente') ? $this->Html->link($clientesCredito->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $clientesCredito->cliente->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Credito Tipo') ?></h6>
            <p><?= h($clientesCredito->credito_tipo) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($clientesCredito->id) ?></p>
            <h6 class="subheader"><?= __('Credito Maximo') ?></h6>
            <p><?= $this->Number->format($clientesCredito->credito_maximo) ?></p>
            <h6 class="subheader"><?= __('Credito Consumo') ?></h6>
            <p><?= $this->Number->format($clientesCredito->credito_consumo) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha') ?></h6>
            <p><?= h($clientesCredito->fecha) ?></p>
        </div>
    </div>
</div>
