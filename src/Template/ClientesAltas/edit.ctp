<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientesAlta $clientesAlta
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clientesAlta->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientesAlta->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Clientes Altas'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="clientesAltas form large-9 medium-8 columns content">
    <?= $this->Form->create($clientesAlta) ?>
    <fieldset>
        <legend><?= __('Edit Clientes Alta') ?></legend>
        <?php
            echo $this->Form->control('razon_social');
            echo $this->Form->control('nombre_fantasia');
            echo $this->Form->control('domicilio');
            echo $this->Form->control('localidad');
            echo $this->Form->control('codigo_postal');
            echo $this->Form->control('provincia');
            echo $this->Form->control('telefono');
            echo $this->Form->control('celular');
            echo $this->Form->control('email');
            echo $this->Form->control('inicio_actividad');
            echo $this->Form->control('farmaceutico_nombre');
            echo $this->Form->control('farmaceutico_matricula');
            echo $this->Form->control('gln');
            echo $this->Form->control('cuit');
            echo $this->Form->control('comentario');
            echo $this->Form->control('creado', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
