<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientesAlta[]|\Cake\Collection\CollectionInterface $clientesAltas
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Clientes Alta'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientesAltas index large-9 medium-8 columns content">
    <h3><?= __('Clientes Altas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('razon_social') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre_fantasia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('localidad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('codigo_postal') ?></th>
                <th scope="col"><?= $this->Paginator->sort('provincia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefono') ?></th>
                <th scope="col"><?= $this->Paginator->sort('celular') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('inicio_actividad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('farmaceutico_nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('farmaceutico_matricula') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gln') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cuit') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creado') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientesAltas as $clientesAlta): ?>
            <tr>
                <td><?= $this->Number->format($clientesAlta->id) ?></td>
                <td><?= h($clientesAlta->razon_social) ?></td>
                <td><?= h($clientesAlta->nombre_fantasia) ?></td>
                <td><?= $this->Number->format($clientesAlta->localidad) ?></td>
                <td><?= h($clientesAlta->codigo_postal) ?></td>
                <td><?= $this->Number->format($clientesAlta->provincia) ?></td>
                <td><?= h($clientesAlta->telefono) ?></td>
                <td><?= h($clientesAlta->celular) ?></td>
                <td><?= h($clientesAlta->email) ?></td>
                <td><?= h($clientesAlta->inicio_actividad) ?></td>
                <td><?= h($clientesAlta->farmaceutico_nombre) ?></td>
                <td><?= h($clientesAlta->farmaceutico_matricula) ?></td>
                <td><?= h($clientesAlta->gln) ?></td>
                <td><?= h($clientesAlta->cuit) ?></td>
                <td><?= h($clientesAlta->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientesAlta->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientesAlta->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientesAlta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientesAlta->id)]) ?>
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
