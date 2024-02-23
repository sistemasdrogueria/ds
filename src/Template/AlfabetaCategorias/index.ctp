<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaCategoria[]|\Cake\Collection\CollectionInterface $alfabetaCategorias
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Categoria'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaCategorias index large-9 medium-8 columns content">
    <h3><?= __('Alfabeta Categorias') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('codigo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alfabetaCategorias as $alfabetaCategoria): ?>
            <tr>
                <td><?= $this->Number->format($alfabetaCategoria->id) ?></td>
                <td><?= h($alfabetaCategoria->codigo) ?></td>
                <td><?= h($alfabetaCategoria->nombre) ?></td>
                <td><?= h($alfabetaCategoria->descripcion) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $alfabetaCategoria->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $alfabetaCategoria->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $alfabetaCategoria->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaCategoria->id)]) ?>
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
