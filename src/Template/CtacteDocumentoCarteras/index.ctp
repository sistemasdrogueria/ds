<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Ctacte Documento Cartera'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="ctacteDocumentoCarteras index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('fecha_deposito') ?></th>
            <th><?= $this->Paginator->sort('cliente_id') ?></th>
            <th><?= $this->Paginator->sort('nro_cheque') ?></th>
            <th><?= $this->Paginator->sort('fecha_ingreso') ?></th>
            <th><?= $this->Paginator->sort('importe') ?></th>
            <th><?= $this->Paginator->sort('origen') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($ctacteDocumentoCarteras as $ctacteDocumentoCartera): ?>
        <tr>
            <td><?= $this->Number->format($ctacteDocumentoCartera->id) ?></td>
            <td><?= h($ctacteDocumentoCartera->fecha_deposito) ?></td>
            <td>
                <?= $ctacteDocumentoCartera->has('cliente') ? $this->Html->link($ctacteDocumentoCartera->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $ctacteDocumentoCartera->cliente->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($ctacteDocumentoCartera->nro_cheque) ?></td>
            <td><?= h($ctacteDocumentoCartera->fecha_ingreso) ?></td>
            <td><?= $this->Number->format($ctacteDocumentoCartera->importe) ?></td>
            <td><?= $this->Number->format($ctacteDocumentoCartera->origen) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $ctacteDocumentoCartera->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ctacteDocumentoCartera->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ctacteDocumentoCartera->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteDocumentoCartera->id)]) ?>
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
