<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ctacte Tipo Pago'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ctacteTipoPagos index large-9 medium-8 columns content">
    <h3><?= __('Ctacte Tipo Pagos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('nombre') ?></th>
                <th><?= $this->Paginator->sort('terminobusqueda') ?></th>
                <th><?= $this->Paginator->sort('grupo') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ctacteTipoPagos as $ctacteTipoPago): ?>
            <tr>
                <td><?= $this->Number->format($ctacteTipoPago->id) ?></td>
                <td><?= h($ctacteTipoPago->nombre) ?></td>
                <td><?= h($ctacteTipoPago->terminobusqueda) ?></td>
                <td><?= $this->Number->format($ctacteTipoPago->grupo) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ctacteTipoPago->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ctacteTipoPago->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ctacteTipoPago->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTipoPago->id)]) ?>
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
