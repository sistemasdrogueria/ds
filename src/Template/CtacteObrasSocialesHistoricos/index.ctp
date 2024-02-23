<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ctacte Obras Sociales Historico'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ctacteObrasSocialesHistoricos index large-9 medium-8 columns content">
    <h3><?= __('Ctacte Obras Sociales Historicos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cliente_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('importe') ?></th>
                <th scope="col"><?= $this->Paginator->sort('obra_social_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nro_nota') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_nota') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ctacteObrasSocialesHistoricos as $ctacteObrasSocialesHistorico): ?>
            <tr>
                <td><?= $this->Number->format($ctacteObrasSocialesHistorico->id) ?></td>
                <td><?= $ctacteObrasSocialesHistorico->has('cliente') ? $this->Html->link($ctacteObrasSocialesHistorico->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $ctacteObrasSocialesHistorico->cliente->id]) : '' ?></td>
                <td><?= h($ctacteObrasSocialesHistorico->fecha) ?></td>
                <td><?= $this->Number->format($ctacteObrasSocialesHistorico->importe) ?></td>
                <td><?= $this->Number->format($ctacteObrasSocialesHistorico->obra_social_id) ?></td>
                <td><?= $this->Number->format($ctacteObrasSocialesHistorico->nro_nota) ?></td>
                <td><?= $this->Number->format($ctacteObrasSocialesHistorico->tipo_nota) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ctacteObrasSocialesHistorico->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ctacteObrasSocialesHistorico->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ctacteObrasSocialesHistorico->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteObrasSocialesHistorico->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
