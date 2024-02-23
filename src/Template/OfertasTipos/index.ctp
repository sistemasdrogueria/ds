<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Ofertas Tipo'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="ofertasTipos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($ofertasTipos as $ofertasTipo): ?>
        <tr>
            <td><?= $this->Number->format($ofertasTipo->id) ?></td>
            <td><?= h($ofertasTipo->nombre) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $ofertasTipo->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ofertasTipo->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ofertasTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ofertasTipo->id)]) ?>
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
