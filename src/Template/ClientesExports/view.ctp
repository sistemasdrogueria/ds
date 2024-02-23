<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Clientes Export'), ['action' => 'edit', $clientesExport->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Clientes Export'), ['action' => 'delete', $clientesExport->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientesExport->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Clientes Exports'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Clientes Export'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientesExports view large-9 medium-8 columns content">
    <h3><?= h($clientesExport->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientesExport->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Cta Comun') ?></th>
            <td><?= $this->Number->format($clientesExport->cta_comun) ?></td>
        </tr>
        <tr>
            <th><?= __('Cta Exportacion') ?></th>
            <td><?= $this->Number->format($clientesExport->cta_exportacion) ?></td>
        </tr>
        <tr>
            <th><?= __('Cliente Comun Id') ?></th>
            <td><?= $this->Number->format($clientesExport->cliente_comun_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Cliente Export Id') ?></th>
            <td><?= $this->Number->format($clientesExport->cliente_export_id) ?></td>
        </tr>
    </table>
</div>
