<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $oferta->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $oferta->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ofertas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ofertas Tipos'), ['controller' => 'OfertasTipos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ofertas Tipo'), ['controller' => 'OfertasTipos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ofertas form large-9 medium-8 columns content">
    <?= $this->Form->create($oferta) ?>
    <fieldset>
        <legend><?= __('Edit Oferta') ?></legend>
        <?php
            echo $this->Form->input('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->input('descripcion');
            echo $this->Form->input('detalle');
            echo $this->Form->input('busqueda');
            echo $this->Form->input('descuento_producto');
            echo $this->Form->input('unidades_minimas');
            echo $this->Form->input('fecha_desde', ['empty' => true]);
            echo $this->Form->input('fecha_hasta', ['empty' => true]);
            echo $this->Form->input('plazos');
            echo $this->Form->input('oferta_tipo_id', ['options' => $ofertasTipos, 'empty' => true]);
            echo $this->Form->input('unidades_maximas');
            echo $this->Form->input('imagen');
            echo $this->Form->input('activo');
            echo $this->Form->input('habilitada');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
