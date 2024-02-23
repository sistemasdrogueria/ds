<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientesNovedade[]|\Cake\Collection\CollectionInterface $clientesNovedades
 */
?><nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('NewClientes Novedade'), ['action' => 'add']) ?></li>        <li><?= $this->Html->link(__('ListClientes Novedades Tipos'), ['controller' => 'ClientesNovedadesTipos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('NewClientes Novedades Tipo'), ['controller' => 'ClientesNovedadesTipos', 'action' => 'add']) ?></li>    </ul>
</nav>
<div class="clientesNovedades index large-9 medium-8 columns content">
    <h3><?= __('Clientes Novedades') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>                <th scope="col"><?= $this->Paginator->sort('id') ?></th>                <th scope="col"><?= $this->Paginator->sort('titulo') ?></th>                <th scope="col"><?= $this->Paginator->sort('clientes_novedades_tipos_id') ?></th>                <th scope="col"><?= $this->Paginator->sort('img_file') ?></th>                <th scope="col"><?= $this->Paginator->sort('fecha') ?></th>                <th scope="col"><?= $this->Paginator->sort('activo') ?></th>                <th scope="col"><?= $this->Paginator->sort('creado') ?></th>                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientesNovedades as $clientesNovedade): ?>
            <tr>                <td><?= $this->Number->format($clientesNovedade->id) ?></td>                <td><?= h($clientesNovedade->titulo) ?></td>                <td><?= $clientesNovedade->has('clientes_novedades_tipo') ? $this->Html->link($clientesNovedade->clientes_novedades_tipo->id, ['controller' => 'ClientesNovedadesTipos', 'action' => 'view', $clientesNovedade->clientes_novedades_tipo->id]) : '' ?></td>                <td><?= h($clientesNovedade->img_file) ?></td>                <td><?= h($clientesNovedade->fecha) ?></td>                <td><?= h($clientesNovedade->activo) ?></td>                <td><?= h($clientesNovedade->creado) ?></td>                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view',$clientesNovedade->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit',$clientesNovedade->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete',$clientesNovedade->id], ['confirm' => __('Are you sure you want to delete # {0}?',$clientesNovedade->id)]) ?>
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
        <p><?= $this->Paginator->counter(['format' => __('Page{{page}} of{{pages}}, showing{{current}} record(s) out of{{count}} total')]) ?></p>
    </div>
</div>
