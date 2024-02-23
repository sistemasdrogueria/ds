<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Ctacte Tarjetas Credito'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="ctacteTarjetasCreditos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('fecha_acreditacion') ?></th>
            <th><?= $this->Paginator->sort('cliente_id') ?></th>
            <th><?= $this->Paginator->sort('nro_liquidacion') ?></th>
            <th><?= $this->Paginator->sort('fecha_ingreso') ?></th>
            <th><?= $this->Paginator->sort('importe') ?></th>
            <th><?= $this->Paginator->sort('detalle') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($ctacteTarjetasCreditos as $ctacteTarjetasCredito): ?>
        <tr>
            <td><?= $this->Number->format($ctacteTarjetasCredito->id) ?></td>
            <td><?= h($ctacteTarjetasCredito->fecha_acreditacion) ?></td>
            <td>
                <?= $ctacteTarjetasCredito->has('cliente') ? $this->Html->link($ctacteTarjetasCredito->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $ctacteTarjetasCredito->cliente->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($ctacteTarjetasCredito->nro_liquidacion) ?></td>
            <td><?= h($ctacteTarjetasCredito->fecha_ingreso) ?></td>
            <td><?= $this->Number->format($ctacteTarjetasCredito->importe) ?></td>
            <td><?= h($ctacteTarjetasCredito->detalle) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $ctacteTarjetasCredito->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ctacteTarjetasCredito->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ctacteTarjetasCredito->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTarjetasCredito->id)]) ?>
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
