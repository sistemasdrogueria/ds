<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Oferta'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ofertas Tipos'), ['controller' => 'OfertasTipos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ofertas Tipo'), ['controller' => 'OfertasTipos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ofertas index large-9 medium-8 columns content">
    <h3><?= __('Ofertas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('articulo_id') ?></th>
                <th><?= $this->Paginator->sort('busqueda') ?></th>
                <th><?= $this->Paginator->sort('descuento_producto') ?></th>
                <th><?= $this->Paginator->sort('unidades_minimas') ?></th>
                <th><?= $this->Paginator->sort('fecha_desde') ?></th>
                <th><?= $this->Paginator->sort('fecha_hasta') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ofertas as $oferta): ?>
            <tr>
                <td><?= $this->Number->format($oferta->id) ?></td>
                <td><?= $oferta->has('articulo') ? $this->Html->link($oferta->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $oferta->articulo->id]) : '' ?></td>
                <td><?= h($oferta->busqueda) ?></td>
                <td><?= $this->Number->format($oferta->descuento_producto) ?></td>
                <td><?= $this->Number->format($oferta->unidades_minimas) ?></td>
                <td><?= h($oferta->fecha_desde) ?></td>
                <td><?= h($oferta->fecha_hasta) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $oferta->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $oferta->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $oferta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $oferta->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
