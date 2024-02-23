<div class="facturasCabeceras index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('fecha') ?></th>
            <th><?= $this->Paginator->sort('cliente_id') ?></th>
            <th><?= $this->Paginator->sort('pedido_ds') ?></th>
            <th><?= $this->Paginator->sort('letra') ?></th>
            <th><?= $this->Paginator->sort('comprobante_id') ?></th>
            <th><?= $this->Paginator->sort('pedido_tipo') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($facturasCabeceras as $facturasCabecera): ?>
        <tr>
            <td><?= $this->Number->format($facturasCabecera->id) ?></td>
            <td><?= h($facturasCabecera->fecha) ?></td>
            <td>
                <?= $facturasCabecera->has('cliente') ? $this->Html->link($facturasCabecera->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $facturasCabecera->cliente->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($facturasCabecera->pedido_ds) ?></td>
            <td><?= h($facturasCabecera->letra) ?></td>
            <td>
                <?= $facturasCabecera->has('comprobante') ? $this->Html->link($facturasCabecera->comprobante->id, ['controller' => 'Comprobantes', 'action' => 'view', $facturasCabecera->comprobante->id]) : '' ?>
            </td>
            <td><?= h($facturasCabecera->pedido_tipo) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $facturasCabecera->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $facturasCabecera->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $facturasCabecera->id], ['confirm' => __('Are you sure you want to delete # {0}?', $facturasCabecera->id)]) ?>
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
