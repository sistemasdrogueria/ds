<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Incorporation[]|\Cake\Collection\CollectionInterface $incorporations
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Incorporation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Incorporations Tipos'), ['controller' => 'IncorporationsTipos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Incorporations Tipo'), ['controller' => 'IncorporationsTipos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="incorporations index large-9 medium-8 columns content">
    <h3><?= __('Incorporations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha_desde') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha_hasta') ?></th>
                <th scope="col"><?= $this->Paginator->sort('incorporations_tipos_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('imagen') ?></th>
                <th scope="col"><?= $this->Paginator->sort('habilitada') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incorporations as $incorporation): ?>
            <tr>
                <td><?= $this->Number->format($incorporation->id) ?></td>
                <td><?= h($incorporation->fecha_desde) ?></td>
                <td><?= h($incorporation->fecha_hasta) ?></td>
                <td><?= $incorporation->has('incorporations_tipo') ? $this->Html->link($incorporation->incorporations_tipo->id, ['controller' => 'IncorporationsTipos', 'action' => 'view', $incorporation->incorporations_tipo->id]) : '' ?></td>
                <td><?= h($incorporation->imagen) ?></td>
                <td><?= $this->Number->format($incorporation->habilitada) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $incorporation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $incorporation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $incorporation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incorporation->id)]) ?>
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
