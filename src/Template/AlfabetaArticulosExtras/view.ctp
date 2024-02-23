<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaArticulosExtra $alfabetaArticulosExtra
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Articulos Extra'), ['action' => 'edit', $alfabetaArticulosExtra->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Articulos Extra'), ['action' => 'delete', $alfabetaArticulosExtra->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulosExtra->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Extras'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Extra'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Tamanos'), ['controller' => 'AlfabetaTamanos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Tamano'), ['controller' => 'AlfabetaTamanos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Monodrogas'), ['controller' => 'AlfabetaMonodrogas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Monodroga'), ['controller' => 'AlfabetaMonodrogas', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Formas'), ['controller' => 'AlfabetaFormas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Forma'), ['controller' => 'AlfabetaFormas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaArticulosExtras view large-9 medium-8 columns content">
    <h3><?= h($alfabetaArticulosExtra->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Alfabeta Articulo') ?></th>
            <td><?= $alfabetaArticulosExtra->has('alfabeta_articulo') ? $this->Html->link($alfabetaArticulosExtra->alfabeta_articulo->id, ['controller' => 'AlfabetaArticulos', 'action' => 'view', $alfabetaArticulosExtra->alfabeta_articulo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Articulo') ?></th>
            <td><?= $alfabetaArticulosExtra->has('articulo') ? $this->Html->link($alfabetaArticulosExtra->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $alfabetaArticulosExtra->articulo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Tamano') ?></th>
            <td><?= $alfabetaArticulosExtra->has('alfabeta_tamano') ? $this->Html->link($alfabetaArticulosExtra->alfabeta_tamano->id, ['controller' => 'AlfabetaTamanos', 'action' => 'view', $alfabetaArticulosExtra->alfabeta_tamano->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Monodroga') ?></th>
            <td><?= $alfabetaArticulosExtra->has('alfabeta_monodroga') ? $this->Html->link($alfabetaArticulosExtra->alfabeta_monodroga->id, ['controller' => 'AlfabetaMonodrogas', 'action' => 'view', $alfabetaArticulosExtra->alfabeta_monodroga->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Forma') ?></th>
            <td><?= $alfabetaArticulosExtra->has('alfabeta_forma') ? $this->Html->link($alfabetaArticulosExtra->alfabeta_forma->, ['controller' => 'AlfabetaFormas', 'action' => 'view', $alfabetaArticulosExtra->alfabeta_forma->]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Potencia') ?></th>
            <td><?= h($alfabetaArticulosExtra->potencia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaArticulosExtra->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Accion Far Id') ?></th>
            <td><?= $this->Number->format($alfabetaArticulosExtra->alfabeta_accion_far_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Unidad Potencia Id') ?></th>
            <td><?= $this->Number->format($alfabetaArticulosExtra->alfabeta_unidad_potencia_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Tipo Unidad Id') ?></th>
            <td><?= $this->Number->format($alfabetaArticulosExtra->alfabeta_tipo_unidad_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Vias') ?></th>
            <td><?= $this->Number->format($alfabetaArticulosExtra->alfabeta_vias) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($alfabetaArticulosExtra->creado) ?></td>
        </tr>
    </table>
</div>
