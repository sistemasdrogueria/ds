<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaArticulosExtra $alfabetaArticulosExtra
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaArticulosExtra->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulosExtra->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Extras'), ['action' => 'index']) ?></li>
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
<div class="alfabetaArticulosExtras form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaArticulosExtra) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Articulos Extra') ?></legend>
        <?php
            echo $this->Form->control('alfabeta_articulo_id', ['options' => $alfabetaArticulos, 'empty' => true]);
            echo $this->Form->control('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->control('alfabeta_tamano_id', ['options' => $alfabetaTamanos, 'empty' => true]);
            echo $this->Form->control('alfabeta_accion_far_id');
            echo $this->Form->control('alfabeta_monodroga_id', ['options' => $alfabetaMonodrogas, 'empty' => true]);
            echo $this->Form->control('alfabeta_forma_id', ['options' => $alfabetaFormas, 'empty' => true]);
            echo $this->Form->control('potencia');
            echo $this->Form->control('alfabeta_unidad_potencia_id');
            echo $this->Form->control('alfabeta_tipo_unidad_id');
            echo $this->Form->control('alfabeta_vias');
            echo $this->Form->control('creado', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
