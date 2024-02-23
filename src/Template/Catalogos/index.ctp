<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Catalogo[]|\Cake\Collection\CollectionInterface $catalogos
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Catalogo'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="catalogos index large-9 medium-8 columns content">
    <h3><?= __('Catalogos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('paginas') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_catalogo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('desde') ?></th>
                <th scope="col"><?= $this->Paginator->sort('hasta') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creado') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($catalogos as $catalogo): ?>
            <tr>
                <td><?= $this->Number->format($catalogo->id) ?></td>
                <td><?= h($catalogo->nombre) ?></td>
                <td><?= $this->Number->format($catalogo->paginas) ?></td>
                <td><?= $this->Number->format($catalogo->tipo_catalogo) ?></td>
                <td><?= h($catalogo->desde) ?></td>
                <td><?= h($catalogo->hasta) ?></td>
                <td><?= h($catalogo->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $catalogo->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $catalogo->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $catalogo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $catalogo->id)]) ?>
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
