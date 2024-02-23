<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Publication $publication
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Publication'), ['action' => 'edit', $publication->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Publication'), ['action' => 'delete', $publication->id], ['confirm' => __('Are you sure you want to delete # {0}?', $publication->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Publications'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Publication'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="publications view large-9 medium-8 columns content">
    <h3><?= h($publication->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Url Controlador') ?></th>
            <td><?= h($publication->url_controlador) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url Metodo') ?></th>
            <td><?= h($publication->url_metodo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url Campo') ?></th>
            <td><?= h($publication->url_campo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Imagen') ?></th>
            <td><?= h($publication->imagen) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($publication->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Habilitada') ?></th>
            <td><?= $this->Number->format($publication->habilitada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Desde') ?></th>
            <td><?= h($publication->fecha_desde) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Hasta') ?></th>
            <td><?= h($publication->fecha_hasta) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Descripcion') ?></h4>
        <?= $this->Text->autoParagraph(h($publication->descripcion)); ?>
    </div>
</div>
