<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $descuento->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $descuento->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Descuentos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="descuentos form large-10 medium-9 columns">
    <?= $this->Form->create($descuento); ?>
    <fieldset>
        <legend><?= __('Edit Descuento') ?></legend>
        <?php
            echo $this->Form->input('articulo_id', ['options' => $articulos]);
            echo $this->Form->input('fecha_desde', array('empty' => true, 'default' => ''));
            echo $this->Form->input('fecha_hasta', array('empty' => true, 'default' => ''));
            echo $this->Form->input('precio_costo');
            echo $this->Form->input('dto_patagonia');
            echo $this->Form->input('dto_drogueria');
            echo $this->Form->input('unidadfact');
            echo $this->Form->input('discrimina_iva');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
