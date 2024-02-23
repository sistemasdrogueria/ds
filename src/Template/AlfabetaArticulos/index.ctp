<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaArticulo[]|\Cake\Collection\CollectionInterface $alfabetaArticulos
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Laboratorios'), ['controller' => 'AlfabetaLaboratorios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Laboratorio'), ['controller' => 'AlfabetaLaboratorios', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Categorias'), ['controller' => 'AlfabetaCategorias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Categoria'), ['controller' => 'AlfabetaCategorias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Eans'), ['controller' => 'AlfabetaArticulosEans', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Ean'), ['controller' => 'AlfabetaArticulosEans', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Extras'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Extra'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Multidrogas'), ['controller' => 'AlfabetaMultidrogas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Multidroga'), ['controller' => 'AlfabetaMultidrogas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaArticulos index large-9 medium-8 columns content">
    <h3><?= __('Alfabeta Articulos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('troquel') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('presentacion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_laboratorio_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('precio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_categoria_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('importado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_tipo_venta_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('iva') ?></th>
                <th scope="col"><?= $this->Paginator->sort('baja') ?></th>
                <th scope="col"><?= $this->Paginator->sort('codigo_barra') ?></th>
                <th scope="col"><?= $this->Paginator->sort('articulo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('unidad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tamano') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cadena_frio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('chequeo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gtin') ?></th>
                <th scope="col"><?= $this->Paginator->sort('eliminado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creado') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alfabetaArticulos as $alfabetaArticulo): ?>
            <tr>
                <td><?= $this->Number->format($alfabetaArticulo->id) ?></td>
                <td><?= h($alfabetaArticulo->troquel) ?></td>
                <td><?= h($alfabetaArticulo->nombre) ?></td>
                <td><?= h($alfabetaArticulo->presentacion) ?></td>
                <td><?= $alfabetaArticulo->has('alfabeta_laboratorio') ? $this->Html->link($alfabetaArticulo->alfabeta_laboratorio->id, ['controller' => 'AlfabetaLaboratorios', 'action' => 'view', $alfabetaArticulo->alfabeta_laboratorio->id]) : '' ?></td>
                <td><?= $this->Number->format($alfabetaArticulo->precio) ?></td>
                <td><?= h($alfabetaArticulo->fecha) ?></td>
                <td><?= $alfabetaArticulo->has('alfabeta_categoria') ? $this->Html->link($alfabetaArticulo->alfabeta_categoria->id, ['controller' => 'AlfabetaCategorias', 'action' => 'view', $alfabetaArticulo->alfabeta_categoria->id]) : '' ?></td>
                <td><?= h($alfabetaArticulo->importado) ?></td>
                <td><?= $this->Number->format($alfabetaArticulo->alfabeta_tipo_venta_id) ?></td>
                <td><?= h($alfabetaArticulo->iva) ?></td>
                <td><?= h($alfabetaArticulo->baja) ?></td>
                <td><?= h($alfabetaArticulo->codigo_barra) ?></td>
                <td><?= $alfabetaArticulo->has('articulo') ? $this->Html->link($alfabetaArticulo->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $alfabetaArticulo->articulo->id]) : '' ?></td>
                <td><?= $this->Number->format($alfabetaArticulo->unidad) ?></td>
                <td><?= h($alfabetaArticulo->tamano) ?></td>
                <td><?= h($alfabetaArticulo->cadena_frio) ?></td>
                <td><?= $this->Number->format($alfabetaArticulo->chequeo) ?></td>
                <td><?= h($alfabetaArticulo->gtin) ?></td>
                <td><?= $this->Number->format($alfabetaArticulo->eliminado) ?></td>
                <td><?= h($alfabetaArticulo->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $alfabetaArticulo->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $alfabetaArticulo->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $alfabetaArticulo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulo->id)]) ?>
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
