<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationsTipo $publicationsTipo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Publications Tipo'), ['action' => 'edit', $publicationsTipo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Publications Tipo'), ['action' => 'delete', $publicationsTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $publicationsTipo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Publications Tipos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Publications Tipo'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="publicationsTipos view large-9 medium-8 columns content">
    <h3><?= h($publicationsTipo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($publicationsTipo->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($publicationsTipo->id) ?></td>
        </tr>
    </table>
</div>
