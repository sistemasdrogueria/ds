<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $catalogo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $catalogo->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Catalogos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="catalogos form large-9 medium-8 columns content">
    <?= $this->Form->create($catalogo) ?>
    <fieldset>
        <legend><?= __('Edit Catalogo') ?></legend>
        <?php
            echo $this->Form->control('nombre');
            echo $this->Form->control('paginas');
            echo $this->Form->control('tipo_catalogo');
            echo $this->Form->control('desde', ['empty' => true]);
            echo $this->Form->control('hasta', ['empty' => true]);
            echo $this->Form->control('creado', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
