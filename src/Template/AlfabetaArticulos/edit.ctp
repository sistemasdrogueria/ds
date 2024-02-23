<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaArticulo $alfabetaArticulo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alfabetaArticulo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulo->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['action' => 'index']) ?></li>
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
<div class="alfabetaArticulos form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaArticulo) ?>
    <fieldset>
        <legend><?= __('Edit Alfabeta Articulo') ?></legend>
        <?php
            echo $this->Form->control('troquel');
            echo $this->Form->control('nombre');
            echo $this->Form->control('presentacion');
            echo $this->Form->control('alfabeta_laboratorio_id', ['options' => $alfabetaLaboratorios, 'empty' => true]);
            echo $this->Form->control('precio');
            echo $this->Form->control('fecha', ['empty' => true]);
            echo $this->Form->control('alfabeta_categoria_id', ['options' => $alfabetaCategorias, 'empty' => true]);
            echo $this->Form->control('importado');
            echo $this->Form->control('alfabeta_tipo_venta_id');
            echo $this->Form->control('iva');
            echo $this->Form->control('baja');
            echo $this->Form->control('codigo_barra');
            echo $this->Form->control('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->control('unidad');
            echo $this->Form->control('tamano');
            echo $this->Form->control('cadena_frio');
            echo $this->Form->control('chequeo');
            echo $this->Form->control('gtin');
            echo $this->Form->control('eliminado');
            echo $this->Form->control('creado', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
