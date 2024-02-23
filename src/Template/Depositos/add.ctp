<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Articulos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Categorias'), ['controller' => 'Categorias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Categoria'), ['controller' => 'Categorias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Laboratorios'), ['controller' => 'Laboratorios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Laboratorio'), ['controller' => 'Laboratorios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carritos Items'), ['controller' => 'CarritosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carritos Item'), ['controller' => 'CarritosItems', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Descuentos'), ['controller' => 'Descuentos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Descuento'), ['controller' => 'Descuentos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ofertas'), ['controller' => 'Ofertas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Oferta'), ['controller' => 'Ofertas', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos Items'), ['controller' => 'PedidosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedidos Item'), ['controller' => 'PedidosItems', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reclamos Items'), ['controller' => 'ReclamosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamos Item'), ['controller' => 'ReclamosItems', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="articulos form large-10 medium-9 columns">
    <?= $this->Form->create($articulo); ?>
    <fieldset>
        <legend><?= __('Add Articulo') ?></legend>
        <?php
            echo $this->Form->input('troquel');
            echo $this->Form->input('descripcion_sist');
            echo $this->Form->input('descripcion_pag');
            echo $this->Form->input('categoria_id', ['options' => $categorias, 'empty' => true]);
            echo $this->Form->input('subcategoria_id');
            echo $this->Form->input('codigo_barras');
            echo $this->Form->input('laboratorio_id', ['options' => $laboratorios, 'empty' => true]);
            echo $this->Form->input('precio_publico');
            echo $this->Form->input('precio_final');
            echo $this->Form->input('stock');
            echo $this->Form->input('cadena_frio');
            echo $this->Form->input('iva');
            echo $this->Form->input('msd');
            echo $this->Form->input('clave_amp');
            echo $this->Form->input('trazable');
            echo $this->Form->input('pack');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
