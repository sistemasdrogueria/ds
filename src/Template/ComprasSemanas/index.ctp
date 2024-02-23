<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Compras Semana'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="comprasSemanas index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('codigo') ?></th>
            <th><?= $this->Paginator->sort('numero') ?></th>
            <th><?= $this->Paginator->sort('fecha_factura') ?></th>
            <th><?= $this->Paginator->sort('importe') ?></th>
            <th><?= $this->Paginator->sort('tipo') ?></th>
            <th><?= $this->Paginator->sort('fecha_vencimiento') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($comprasSemanas as $comprasSemana): ?>
        <tr>
            <td><?= $this->Number->format($comprasSemana->id) ?></td>
            <td><?= $this->Number->format($comprasSemana->codigo) ?></td>
            <td><?= $this->Number->format($comprasSemana->numero) ?></td>
            <td><?= h($comprasSemana->fecha_factura) ?></td>
            <td><?= $this->Number->format($comprasSemana->importe) ?></td>
            <td><?= h($comprasSemana->tipo) ?></td>
            <td><?= h($comprasSemana->fecha_vencimiento) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $comprasSemana->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $comprasSemana->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $comprasSemana->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comprasSemana->id)]) ?>
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
