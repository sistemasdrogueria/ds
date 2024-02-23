<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Oferta'), ['action' => 'edit', $oferta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Oferta'), ['action' => 'delete', $oferta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $oferta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ofertas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Oferta'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="ofertas view large-10 medium-9 columns">
    <h2><?= h($oferta->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Articulo') ?></h6>
            <p><?= $oferta->has('articulo') ? $this->Html->link($oferta->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $oferta->articulo->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Imagen') ?></h6>
            <p><?= h($oferta->imagen) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($oferta->id) ?></p>
            <h6 class="subheader"><?= __('Descuento Producto') ?></h6>
            <p><?= $this->Number->format($oferta->descuento_producto) ?></p>
            <h6 class="subheader"><?= __('Unidades Minimas') ?></h6>
            <p><?= $this->Number->format($oferta->unidades_minimas) ?></p>
            <h6 class="subheader"><?= __('Oferta Tipo Id') ?></h6>
            <p><?= $this->Number->format($oferta->oferta_tipo_id) ?></p>
            <h6 class="subheader"><?= __('Unidades Maximas') ?></h6>
            <p><?= $this->Number->format($oferta->unidades_maximas) ?></p>
            <h6 class="subheader"><?= __('Activo') ?></h6>
            <p><?= $this->Number->format($oferta->activo) ?></p>
            <h6 class="subheader"><?= __('Habilitada') ?></h6>
            <p><?= $this->Number->format($oferta->habilitada) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha Desde') ?></h6>
            <p><?= h($oferta->fecha_desde) ?></p>
            <h6 class="subheader"><?= __('Fecha Hasta') ?></h6>
            <p><?= h($oferta->fecha_hasta) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Descripcion') ?></h6>
            <?= $this->Text->autoParagraph(h($oferta->descripcion)) ?>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Plazos') ?></h6>
            <?= $this->Text->autoParagraph(h($oferta->plazos)) ?>
        </div>
    </div>
</div>
