<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ctacte Tipo Pagos Grupo'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ctacteTipoPagosGrupos index large-9 medium-8 columns content">
    <h3><?= __('Ctacte Tipo Pagos Grupos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('nombre') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ctacteTipoPagosGrupos as $ctacteTipoPagosGrupo): ?>
            <tr>
                <td><?= $this->Number->format($ctacteTipoPagosGrupo->id) ?></td>
                <td><?= h($ctacteTipoPagosGrupo->nombre) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ctacteTipoPagosGrupo->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ctacteTipoPagosGrupo->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ctacteTipoPagosGrupo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTipoPagosGrupo->id)]) ?>
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
