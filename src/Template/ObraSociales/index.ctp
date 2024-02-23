<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Obra Sociale'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="obraSociales index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('codigo') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th><?= $this->Paginator->sort('nombrecompleto') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($obraSociales as $obraSociale): ?>
        <tr>
            <td><?= $this->Number->format($obraSociale->id) ?></td>
            <td><?= $this->Number->format($obraSociale->codigo) ?></td>
            <td><?= h($obraSociale->nombre) ?></td>
            <td><?= h($obraSociale->nombrecompleto) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $obraSociale->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $obraSociale->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $obraSociale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $obraSociale->id)]) ?>
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
