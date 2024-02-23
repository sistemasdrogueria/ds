<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Evento $evento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Eventos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="eventos form large-9 medium-8 columns content">
    <?= $this->Form->create($evento) ?>
    <fieldset>
        <legend><?= __('Add Evento') ?></legend>
        <?php
            echo $this->Form->control('nombre');
            echo $this->Form->control('lugar');
            echo $this->Form->control('fecha', ['empty' => true]);
            echo $this->Form->control('cantidad_fotos');
            echo $this->Form->control('carpeta_fotos');
            echo $this->Form->control('creado', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
