<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaMonodroga $alfabetaMonodroga
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Monodroga'), ['action' => 'edit', $alfabetaMonodroga->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Monodroga'), ['action' => 'delete', $alfabetaMonodroga->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaMonodroga->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Monodrogas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Monodroga'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Extras'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Extra'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaMonodrogas view large-9 medium-8 columns content">
    <h3><?= h($alfabetaMonodroga->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($alfabetaMonodroga->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaMonodroga->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Alfabeta Articulos Extras') ?></h4>
        <?php if (!empty($alfabetaMonodroga->alfabeta_articulos_extras)): ?>
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
            <?php foreach ($alfabetaMonodroga->alfabeta_articulos_extras as $alfabetaArticulosExtras): ?>
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
</div>
