<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Facturas Cuerpos Items'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Facturas Cabeceras'), ['controller' => 'FacturasCabeceras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Facturas Cabecera'), ['controller' => 'FacturasCabeceras', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="facturasCuerposItems form large-10 medium-9 columns">
    <?= $this->Form->create($facturasCuerposItem) ?>
    <fieldset>
        <legend><?= __('Add Facturas Cuerpos Item') ?></legend>
        <?php
            echo $this->Form->input('facturas_encabezados_id', ['options' => $facturasCabeceras, 'empty' => true]);
            echo $this->Form->input('pedido_ds');
            echo $this->Form->input('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->input('iva');
            echo $this->Form->input('cantidad_facturada');
            echo $this->Form->input('precio_unitario');
            echo $this->Form->input('precio_publico');
            echo $this->Form->input('precio_total');
            echo $this->Form->input('descripcion');
            echo $this->Form->input('troquel');
            echo $this->Form->input('codigo_barra');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
