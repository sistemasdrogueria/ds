<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Curriculum $curriculum
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $curriculum->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $curriculum->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Curriculums'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Puestos'), ['controller' => 'Puestos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Puesto'), ['controller' => 'Puestos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="curriculums form large-9 medium-8 columns content">
    <?= $this->Form->create($curriculum) ?>
    <fieldset>
        <legend><?= __('Edit Curriculum') ?></legend>
        <?php
            echo $this->Form->control('nombres');
            echo $this->Form->control('apellidos');
            echo $this->Form->control('tipo_documento');
            echo $this->Form->control('documento');
            echo $this->Form->control('email');
            echo $this->Form->control('sexo');
            echo $this->Form->control('fecha_nacimiento');
            echo $this->Form->control('nacionalidad');
            echo $this->Form->control('puesto_id', ['options' => $puestos]);
            echo $this->Form->control('linkedin');
            echo $this->Form->control('archivo_cv');
            echo $this->Form->control('foto');
            echo $this->Form->control('creado');
            echo $this->Form->control('modificado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
