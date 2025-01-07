<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\outlets $outlets
 */
?><nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $outlets->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $outlets->id)]
            )
        ?></li>        <li><?= $this->Html->link(__('ListOutlet'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('ListArticulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('NewArticulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="outlet form large-9 medium-8 columns content">
    <?= $this->Form->create($outlets) ?>
    <fieldset>
        <legend><?= __('EditOutlet') ?></legend>
        <?php            echo $this->Form->control('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->control('fecha_inicio', ['empty' => true]);
            echo $this->Form->control('fecha_final', ['empty' => true]);
            echo $this->Form->control('condicion');
            echo $this->Form->control('descuento_por_condicion');
            echo $this->Form->control('activo');
            echo $this->Form->control('unidades_stock');
            echo $this->Form->control('venc');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
