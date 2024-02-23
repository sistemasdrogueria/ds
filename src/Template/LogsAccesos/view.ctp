<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Logs Acceso'), ['action' => 'edit', $logsAcceso->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Logs Acceso'), ['action' => 'delete', $logsAcceso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $logsAcceso->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Logs Accesos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Logs Acceso'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="logsAccesos view large-10 medium-9 columns">
    <h2><?= h($logsAcceso->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Cliente') ?></h6>
            <p><?= $logsAcceso->has('cliente') ? $this->Html->link($logsAcceso->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $logsAcceso->cliente->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Ip') ?></h6>
            <p><?= h($logsAcceso->ip) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($logsAcceso->id) ?></p>
            <h6 class="subheader"><?= __('Usuario Id') ?></h6>
            <p><?= $this->Number->format($logsAcceso->usuario_id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha') ?></h6>
            <p><?= h($logsAcceso->fecha) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Super') ?></h6>
            <p><?= $logsAcceso->super ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
