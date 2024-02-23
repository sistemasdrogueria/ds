<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationsTipo $publicationsTipo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $publicationsTipo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $publicationsTipo->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Publications Tipos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="publicationsTipos form large-9 medium-8 columns content">
    <?= $this->Form->create($publicationsTipo) ?>
    <fieldset>
        <legend><?= __('Edit Publications Tipo') ?></legend>
        <?php
            echo $this->Form->control('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
