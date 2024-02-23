<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grupo[]|\Cake\Collection\CollectionInterface $grupos
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Grupo'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Subcategorias'), ['controller' => 'Subcategorias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Subcategoria'), ['controller' => 'Subcategorias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Subgrupos'), ['controller' => 'Subgrupos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Subgrupo'), ['controller' => 'Subgrupos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Pagos'), ['controller' => 'CtacteTipoPagos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ctacte Tipo Pago'), ['controller' => 'CtacteTipoPagos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="grupos index large-9 medium-8 columns content">
    <h3><?= __('Grupos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subcategoria_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grupos as $grupo): ?>
            <tr>
                <td><?= $this->Number->format($grupo->id) ?></td>
                <td><?= h($grupo->nombre) ?></td>
                <td><?= h($grupo->descripcion) ?></td>
                <td><?= $grupo->has('subcategoria') ? $this->Html->link($grupo->subcategoria->id, ['controller' => 'Subcategorias', 'action' => 'view', $grupo->subcategoria->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $grupo->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $grupo->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $grupo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grupo->id)]) ?>
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
