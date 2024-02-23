<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaArticulosExtra[]|\Cake\Collection\CollectionInterface $alfabetaArticulosExtras
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Extra'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Tamanos'), ['controller' => 'AlfabetaTamanos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Tamano'), ['controller' => 'AlfabetaTamanos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Monodrogas'), ['controller' => 'AlfabetaMonodrogas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Monodroga'), ['controller' => 'AlfabetaMonodrogas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Formas'), ['controller' => 'AlfabetaFormas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Forma'), ['controller' => 'AlfabetaFormas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaArticulosExtras index large-9 medium-8 columns content">
    <h3><?= __('Alfabeta Articulos Extras') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_articulo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('articulo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_tamano_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_accion_far_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_monodroga_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_forma_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('potencia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_unidad_potencia_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_tipo_unidad_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_vias') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creado') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alfabetaArticulosExtras as $alfabetaArticulosExtra): ?>
            <tr>
                <td><?= $this->Number->format($alfabetaArticulosExtra->id) ?></td>
                <td><?= $alfabetaArticulosExtra->has('alfabeta_articulo') ? $this->Html->link($alfabetaArticulosExtra->alfabeta_articulo->id, ['controller' => 'AlfabetaArticulos', 'action' => 'view', $alfabetaArticulosExtra->alfabeta_articulo->id]) : '' ?></td>
                <td><?= $alfabetaArticulosExtra->has('articulo') ? $this->Html->link($alfabetaArticulosExtra->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $alfabetaArticulosExtra->articulo->id]) : '' ?></td>
                <td><?= $alfabetaArticulosExtra->has('alfabeta_tamano') ? $this->Html->link($alfabetaArticulosExtra->alfabeta_tamano->id, ['controller' => 'AlfabetaTamanos', 'action' => 'view', $alfabetaArticulosExtra->alfabeta_tamano->id]) : '' ?></td>
                <td><?= $this->Number->format($alfabetaArticulosExtra->alfabeta_accion_far_id) ?></td>
                <td><?= $alfabetaArticulosExtra->has('alfabeta_monodroga') ? $this->Html->link($alfabetaArticulosExtra->alfabeta_monodroga->id, ['controller' => 'AlfabetaMonodrogas', 'action' => 'view', $alfabetaArticulosExtra->alfabeta_monodroga->id]) : '' ?></td>
                <td><?= $alfabetaArticulosExtra->has('alfabeta_forma') ? $this->Html->link($alfabetaArticulosExtra->alfabeta_forma->, ['controller' => 'AlfabetaFormas', 'action' => 'view', $alfabetaArticulosExtra->alfabeta_forma->]) : '' ?></td>
                <td><?= h($alfabetaArticulosExtra->potencia) ?></td>
                <td><?= $this->Number->format($alfabetaArticulosExtra->alfabeta_unidad_potencia_id) ?></td>
                <td><?= $this->Number->format($alfabetaArticulosExtra->alfabeta_tipo_unidad_id) ?></td>
                <td><?= $this->Number->format($alfabetaArticulosExtra->alfabeta_vias) ?></td>
                <td><?= h($alfabetaArticulosExtra->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $alfabetaArticulosExtra->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $alfabetaArticulosExtra->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $alfabetaArticulosExtra->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulosExtra->id)]) ?>
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
