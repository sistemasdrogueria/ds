<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Fragancias Presentacione'), ['action' => 'edit', $fraganciasPresentacione->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Fragancias Presentacione'), ['action' => 'delete', $fraganciasPresentacione->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fraganciasPresentacione->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Fragancias Presentaciones'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fragancias Presentacione'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Fragancias'), ['controller' => 'Fragancias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fragancia'), ['controller' => 'Fragancias', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="fraganciasPresentaciones view large-9 medium-8 columns content">
    <h3><?= h($fraganciasPresentacione->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Articulo') ?></th>
            <td><?= $fraganciasPresentacione->has('articulo') ? $this->Html->link($fraganciasPresentacione->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $fraganciasPresentacione->articulo->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Fragancia') ?></th>
            <td><?= $fraganciasPresentacione->has('fragancia') ? $this->Html->link($fraganciasPresentacione->fragancia->id, ['controller' => 'Fragancias', 'action' => 'view', $fraganciasPresentacione->fragancia->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Detalle') ?></th>
            <td><?= h($fraganciasPresentacione->detalle) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($fraganciasPresentacione->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Creado') ?></th>
            <td><?= h($fraganciasPresentacione->creado) ?></td>
        </tr>
    </table>
</div>
