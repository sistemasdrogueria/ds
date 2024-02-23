<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Publication $publication
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $publication->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $publication->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Publications'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="publications form large-9 medium-8 columns content">
    <?= $this->Form->create($publication) ?>
    <fieldset>
        <legend><?= __('Edit Publication') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
            echo $this->Form->control('url_controlador');
            echo $this->Form->control('url_metodo');
            echo $this->Form->control('url_campo');
            echo $this->Form->control('fecha_desde', ['empty' => true]);
            echo $this->Form->control('fecha_hasta', ['empty' => true]);
            echo $this->Form->control('imagen');
            echo $this->Form->control('habilitada');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
