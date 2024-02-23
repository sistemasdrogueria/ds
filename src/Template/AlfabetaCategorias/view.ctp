<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaCategoria $alfabetaCategoria
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Categoria'), ['action' => 'edit', $alfabetaCategoria->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Categoria'), ['action' => 'delete', $alfabetaCategoria->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaCategoria->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Categorias'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Categoria'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaCategorias view large-9 medium-8 columns content">
    <h3><?= h($alfabetaCategoria->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Codigo') ?></th>
            <td><?= h($alfabetaCategoria->codigo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($alfabetaCategoria->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($alfabetaCategoria->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaCategoria->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Alfabeta Articulos') ?></h4>
        <?php if (!empty($alfabetaCategoria->alfabeta_articulos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Troquel') ?></th>
                <th scope="col"><?= __('Nombre') ?></th>
                <th scope="col"><?= __('Presentacion') ?></th>
                <th scope="col"><?= __('Alfabeta Laboratorio Id') ?></th>
                <th scope="col"><?= __('Precio') ?></th>
                <th scope="col"><?= __('Fecha') ?></th>
                <th scope="col"><?= __('Alfabeta Categoria Id') ?></th>
                <th scope="col"><?= __('Importado') ?></th>
                <th scope="col"><?= __('Alfabeta Tipo Venta Id') ?></th>
                <th scope="col"><?= __('Iva') ?></th>
                <th scope="col"><?= __('Baja') ?></th>
                <th scope="col"><?= __('Codigo Barra') ?></th>
                <th scope="col"><?= __('Articulo Id') ?></th>
                <th scope="col"><?= __('Unidad') ?></th>
                <th scope="col"><?= __('Tamano') ?></th>
                <th scope="col"><?= __('Cadena Frio') ?></th>
                <th scope="col"><?= __('Chequeo') ?></th>
                <th scope="col"><?= __('Gtin') ?></th>
                <th scope="col"><?= __('Eliminado') ?></th>
                <th scope="col"><?= __('Creado') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($alfabetaCategoria->alfabeta_articulos as $alfabetaArticulos): ?>
            <tr>
                <td><?= h($alfabetaArticulos->id) ?></td>
                <td><?= h($alfabetaArticulos->troquel) ?></td>
                <td><?= h($alfabetaArticulos->nombre) ?></td>
                <td><?= h($alfabetaArticulos->presentacion) ?></td>
                <td><?= h($alfabetaArticulos->alfabeta_laboratorio_id) ?></td>
                <td><?= h($alfabetaArticulos->precio) ?></td>
                <td><?= h($alfabetaArticulos->fecha) ?></td>
                <td><?= h($alfabetaArticulos->alfabeta_categoria_id) ?></td>
                <td><?= h($alfabetaArticulos->importado) ?></td>
                <td><?= h($alfabetaArticulos->alfabeta_tipo_venta_id) ?></td>
                <td><?= h($alfabetaArticulos->iva) ?></td>
                <td><?= h($alfabetaArticulos->baja) ?></td>
                <td><?= h($alfabetaArticulos->codigo_barra) ?></td>
                <td><?= h($alfabetaArticulos->articulo_id) ?></td>
                <td><?= h($alfabetaArticulos->unidad) ?></td>
                <td><?= h($alfabetaArticulos->tamano) ?></td>
                <td><?= h($alfabetaArticulos->cadena_frio) ?></td>
                <td><?= h($alfabetaArticulos->chequeo) ?></td>
                <td><?= h($alfabetaArticulos->gtin) ?></td>
                <td><?= h($alfabetaArticulos->eliminado) ?></td>
                <td><?= h($alfabetaArticulos->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AlfabetaArticulos', 'action' => 'view', $alfabetaArticulos->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AlfabetaArticulos', 'action' => 'edit', $alfabetaArticulos->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AlfabetaArticulos', 'action' => 'delete', $alfabetaArticulos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulos->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
