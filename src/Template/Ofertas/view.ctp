<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Oferta'), ['action' => 'edit', $oferta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Oferta'), ['action' => 'delete', $oferta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $oferta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ofertas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Oferta'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ofertas Tipos'), ['controller' => 'OfertasTipos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ofertas Tipo'), ['controller' => 'OfertasTipos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ofertas view large-9 medium-8 columns content">
    <h3><?= h($oferta->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Articulo') ?></th>
            <td><?= $oferta->has('articulo') ? $this->Html->link($oferta->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $oferta->articulo->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Busqueda') ?></th>
            <td><?= h($oferta->busqueda) ?></td>
        </tr>
        <tr>
            <th><?= __('Ofertas Tipo') ?></th>
            <td><?= $oferta->has('ofertas_tipo') ? $this->Html->link($oferta->ofertas_tipo->id, ['controller' => 'OfertasTipos', 'action' => 'view', $oferta->ofertas_tipo->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Imagen') ?></th>
            <td><?= h($oferta->imagen) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($oferta->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Descuento Producto') ?></th>
            <td><?= $this->Number->format($oferta->descuento_producto) ?></td>
        </tr>
        <tr>
            <th><?= __('Unidades Minimas') ?></th>
            <td><?= $this->Number->format($oferta->unidades_minimas) ?></td>
        </tr>
        <tr>
            <th><?= __('Unidades Maximas') ?></th>
            <td><?= $this->Number->format($oferta->unidades_maximas) ?></td>
        </tr>
        <tr>
            <th><?= __('Activo') ?></th>
            <td><?= $this->Number->format($oferta->activo) ?></td>
        </tr>
        <tr>
            <th><?= __('Habilitada') ?></th>
            <td><?= $this->Number->format($oferta->habilitada) ?></td>
        </tr>
        <tr>
            <th><?= __('Fecha Desde') ?></th>
            <td><?= h($oferta->fecha_desde) ?></td>
        </tr>
        <tr>
            <th><?= __('Fecha Hasta') ?></th>
            <td><?= h($oferta->fecha_hasta) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Descripcion') ?></h4>
        <?= $this->Text->autoParagraph(h($oferta->descripcion)); ?>
    </div>
    <div class="row">
        <h4><?= __('Detalle') ?></h4>
        <?= $this->Text->autoParagraph(h($oferta->detalle)); ?>
    </div>
    <div class="row">
        <h4><?= __('Plazos') ?></h4>
        <?= $this->Text->autoParagraph(h($oferta->plazos)); ?>
    </div>
</div>
