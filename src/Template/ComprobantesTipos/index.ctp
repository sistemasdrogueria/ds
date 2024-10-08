<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Comprobantes Tipo'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="comprobantesTipos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th><?= $this->Paginator->sort('tipo') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($comprobantesTipos as $comprobantesTipo): ?>
        <tr>
            <td><?= $this->Number->format($comprobantesTipo->id) ?></td>
            <td><?= h($comprobantesTipo->nombre) ?></td>
            <td><?= h($comprobantesTipo->tipo) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $comprobantesTipo->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $comprobantesTipo->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $comprobantesTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comprobantesTipo->id)]) ?>
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
