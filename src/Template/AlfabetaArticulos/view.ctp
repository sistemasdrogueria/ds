<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaArticulo $alfabetaArticulo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Articulo'), ['action' => 'edit', $alfabetaArticulo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Articulo'), ['action' => 'delete', $alfabetaArticulo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Laboratorios'), ['controller' => 'AlfabetaLaboratorios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Laboratorio'), ['controller' => 'AlfabetaLaboratorios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Categorias'), ['controller' => 'AlfabetaCategorias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Categoria'), ['controller' => 'AlfabetaCategorias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Eans'), ['controller' => 'AlfabetaArticulosEans', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Ean'), ['controller' => 'AlfabetaArticulosEans', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Extras'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Extra'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Multidrogas'), ['controller' => 'AlfabetaMultidrogas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Multidroga'), ['controller' => 'AlfabetaMultidrogas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaArticulos view large-9 medium-8 columns content">
    <h3><?= h($alfabetaArticulo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Troquel') ?></th>
            <td><?= h($alfabetaArticulo->troquel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($alfabetaArticulo->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Presentacion') ?></th>
            <td><?= h($alfabetaArticulo->presentacion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Laboratorio') ?></th>
            <td><?= $alfabetaArticulo->has('alfabeta_laboratorio') ? $this->Html->link($alfabetaArticulo->alfabeta_laboratorio->id, ['controller' => 'AlfabetaLaboratorios', 'action' => 'view', $alfabetaArticulo->alfabeta_laboratorio->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Categoria') ?></th>
            <td><?= $alfabetaArticulo->has('alfabeta_categoria') ? $this->Html->link($alfabetaArticulo->alfabeta_categoria->id, ['controller' => 'AlfabetaCategorias', 'action' => 'view', $alfabetaArticulo->alfabeta_categoria->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Codigo Barra') ?></th>
            <td><?= h($alfabetaArticulo->codigo_barra) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Articulo') ?></th>
            <td><?= $alfabetaArticulo->has('articulo') ? $this->Html->link($alfabetaArticulo->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $alfabetaArticulo->articulo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tamano') ?></th>
            <td><?= h($alfabetaArticulo->tamano) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gtin') ?></th>
            <td><?= h($alfabetaArticulo->gtin) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaArticulo->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Precio') ?></th>
            <td><?= $this->Number->format($alfabetaArticulo->precio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Tipo Venta Id') ?></th>
            <td><?= $this->Number->format($alfabetaArticulo->alfabeta_tipo_venta_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unidad') ?></th>
            <td><?= $this->Number->format($alfabetaArticulo->unidad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Chequeo') ?></th>
            <td><?= $this->Number->format($alfabetaArticulo->chequeo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Eliminado') ?></th>
            <td><?= $this->Number->format($alfabetaArticulo->eliminado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($alfabetaArticulo->fecha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($alfabetaArticulo->creado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Importado') ?></th>
            <td><?= $alfabetaArticulo->importado ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Iva') ?></th>
            <td><?= $alfabetaArticulo->iva ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Baja') ?></th>
            <td><?= $alfabetaArticulo->baja ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cadena Frio') ?></th>
            <td><?= $alfabetaArticulo->cadena_frio ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Alfabeta Articulos Eans') ?></h4>
        <?php if (!empty($alfabetaArticulo->alfabeta_articulos_eans)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Alfabeta Articulo Id') ?></th>
                <th scope="col"><?= __('Codigo Barra') ?></th>
                <th scope="col"><?= __('Creado') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($alfabetaArticulo->alfabeta_articulos_eans as $alfabetaArticulosEans): ?>
            <tr>
                <td><?= h($alfabetaArticulosEans->id) ?></td>
                <td><?= h($alfabetaArticulosEans->alfabeta_articulo_id) ?></td>
                <td><?= h($alfabetaArticulosEans->codigo_barra) ?></td>
                <td><?= h($alfabetaArticulosEans->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AlfabetaArticulosEans', 'action' => 'view', $alfabetaArticulosEans->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AlfabetaArticulosEans', 'action' => 'edit', $alfabetaArticulosEans->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AlfabetaArticulosEans', 'action' => 'delete', $alfabetaArticulosEans->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulosEans->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Alfabeta Articulos Extras') ?></h4>
        <?php if (!empty($alfabetaArticulo->alfabeta_articulos_extras)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Alfabeta Articulo Id') ?></th>
                <th scope="col"><?= __('Articulo Id') ?></th>
                <th scope="col"><?= __('Alfabeta Tamano Id') ?></th>
                <th scope="col"><?= __('Alfabeta Accion Far Id') ?></th>
                <th scope="col"><?= __('Alfabeta Monodroga Id') ?></th>
                <th scope="col"><?= __('Alfabeta Forma Id') ?></th>
                <th scope="col"><?= __('Potencia') ?></th>
                <th scope="col"><?= __('Alfabeta Unidad Potencia Id') ?></th>
                <th scope="col"><?= __('Alfabeta Tipo Unidad Id') ?></th>
                <th scope="col"><?= __('Alfabeta Vias') ?></th>
                <th scope="col"><?= __('Creado') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($alfabetaArticulo->alfabeta_articulos_extras as $alfabetaArticulosExtras): ?>
            <tr>
                <td><?= h($alfabetaArticulosExtras->id) ?></td>
                <td><?= h($alfabetaArticulosExtras->alfabeta_articulo_id) ?></td>
                <td><?= h($alfabetaArticulosExtras->articulo_id) ?></td>
                <td><?= h($alfabetaArticulosExtras->alfabeta_tamano_id) ?></td>
                <td><?= h($alfabetaArticulosExtras->alfabeta_accion_far_id) ?></td>
                <td><?= h($alfabetaArticulosExtras->alfabeta_monodroga_id) ?></td>
                <td><?= h($alfabetaArticulosExtras->alfabeta_forma_id) ?></td>
                <td><?= h($alfabetaArticulosExtras->potencia) ?></td>
                <td><?= h($alfabetaArticulosExtras->alfabeta_unidad_potencia_id) ?></td>
                <td><?= h($alfabetaArticulosExtras->alfabeta_tipo_unidad_id) ?></td>
                <td><?= h($alfabetaArticulosExtras->alfabeta_vias) ?></td>
                <td><?= h($alfabetaArticulosExtras->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'view', $alfabetaArticulosExtras->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'edit', $alfabetaArticulosExtras->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'delete', $alfabetaArticulosExtras->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulosExtras->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Alfabeta Multidrogas') ?></h4>
        <?php if (!empty($alfabetaArticulo->alfabeta_multidrogas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Alfabeta Articulo Id') ?></th>
                <th scope="col"><?= __('Articulo Id') ?></th>
                <th scope="col"><?= __('Alfabeta Nueva Droga Id') ?></th>
                <th scope="col"><?= __('Potencia') ?></th>
                <th scope="col"><?= __('Alfabeta Unidad Potencia Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($alfabetaArticulo->alfabeta_multidrogas as $alfabetaMultidrogas): ?>
            <tr>
                <td><?= h($alfabetaMultidrogas->id) ?></td>
                <td><?= h($alfabetaMultidrogas->alfabeta_articulo_id) ?></td>
                <td><?= h($alfabetaMultidrogas->articulo_id) ?></td>
                <td><?= h($alfabetaMultidrogas->alfabeta_nueva_droga_id) ?></td>
                <td><?= h($alfabetaMultidrogas->potencia) ?></td>
                <td><?= h($alfabetaMultidrogas->alfabeta_unidad_potencia_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AlfabetaMultidrogas', 'action' => 'view', $alfabetaMultidrogas->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AlfabetaMultidrogas', 'action' => 'edit', $alfabetaMultidrogas->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AlfabetaMultidrogas', 'action' => 'delete', $alfabetaMultidrogas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaMultidrogas->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
