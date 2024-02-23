<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $articulosEan->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $articulosEan->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Articulos Eans'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="articulosEans form large-10 medium-9 columns">
    <?= $this->Form->create($articulosEan) ?>
    <fieldset>
        <legend><?= __('Edit Articulos Ean') ?></legend>
        <?php
            echo $this->Form->input('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->input('codigo_barra');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
