<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaLaboratorio[]|\Cake\Collection\CollectionInterface $alfabetaLaboratorios
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Laboratorio'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaLaboratorios index large-9 medium-8 columns content">
    <h3><?= __('Alfabeta Laboratorios') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('codigo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('eliminado') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alfabetaLaboratorios as $alfabetaLaboratorio): ?>
            <tr>
                <td><?= $this->Number->format($alfabetaLaboratorio->id) ?></td>
                <td><?= h($alfabetaLaboratorio->nombre) ?></td>
                <td><?= $this->Number->format($alfabetaLaboratorio->codigo) ?></td>
                <td><?= h($alfabetaLaboratorio->eliminado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $alfabetaLaboratorio->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $alfabetaLaboratorio->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $alfabetaLaboratorio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaLaboratorio->id)]) ?>
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
