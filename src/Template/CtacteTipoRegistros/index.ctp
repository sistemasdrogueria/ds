<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Ctacte Tipo Registro'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="ctacteTipoRegistros index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th><?= $this->Paginator->sort('codigo') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($ctacteTipoRegistros as $ctacteTipoRegistro): ?>
        <tr>
            <td><?= $this->Number->format($ctacteTipoRegistro->id) ?></td>
            <td><?= h($ctacteTipoRegistro->nombre) ?></td>
            <td><?= $this->Number->format($ctacteTipoRegistro->codigo) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $ctacteTipoRegistro->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ctacteTipoRegistro->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ctacteTipoRegistro->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTipoRegistro->id)]) ?>
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
