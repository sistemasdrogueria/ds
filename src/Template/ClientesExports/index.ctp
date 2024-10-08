<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Clientes Export'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientesExports index large-9 medium-8 columns content">
    <h3><?= __('Clientes Exports') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('cta_comun') ?></th>
                <th><?= $this->Paginator->sort('cta_exportacion') ?></th>
                <th><?= $this->Paginator->sort('cliente_comun_id') ?></th>
                <th><?= $this->Paginator->sort('cliente_export_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientesExports as $clientesExport): ?>
            <tr>
                <td><?= $this->Number->format($clientesExport->id) ?></td>
                <td><?= $this->Number->format($clientesExport->cta_comun) ?></td>
                <td><?= $this->Number->format($clientesExport->cta_exportacion) ?></td>
                <td><?= $this->Number->format($clientesExport->cliente_comun_id) ?></td>
                <td><?= $this->Number->format($clientesExport->cliente_export_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientesExport->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientesExport->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientesExport->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientesExport->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
