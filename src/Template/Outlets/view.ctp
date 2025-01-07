<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\outletss $outlets
 */
?><nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Editoutlets'), ['action' => 'edit',$outlets->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Deleteoutlets'), ['action' => 'delete',$outlets->id], ['confirm' => __('Are you sure you want to delete # {0}?',$outlets->id)]) ?> </li>
        <li><?= $this->Html->link(__('Listoutlets'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Newoutlets'), ['action' => 'add']) ?> </li>        <li><?= $this->Html->link(__('ListArticulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('NewArticulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>    </ul>
</nav>
<div class="outlets view large-9 medium-8 columns content">
    <h3><?= h($outlets->id) ?></h3>
    <table class="vertical-table">        <tr>
            <th scope="row"><?= __('Articulo') ?></th>
            <td><?= $outlets->has('articulo') ? $this->Html->link($outlets->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $outlets->articulo->id]) : '' ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Condicion') ?></th>
            <td><?= h($outlets->condicion) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Venc') ?></th>
            <td><?= h($outlets->venc) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($outlets->id) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Descuento Por Condicion') ?></th>
            <td><?= $this->Number->format($outlets->descuento_por_condicion) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Unidades Stock') ?></th>
            <td><?= $this->Number->format($outlets->unidades_stock) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Fecha Creado') ?></th>
            <td><?= h($outlets->fecha_inicio) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Fecha Final') ?></th>
            <td><?= h($outlets->fecha_final) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Activo') ?></th>
            <td><?= $outlets->activo ? __('Yes') : __('No'); ?></td>
        </tr>    </table></div>
