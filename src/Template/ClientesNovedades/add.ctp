<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientesNovedade $clientesNovedade
 */
?><nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>        <li><?= $this->Html->link(__('ListClientes Novedades'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('ListClientes Novedades Tipos'), ['controller' => 'ClientesNovedadesTipos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('NewClientes Novedades Tipo'), ['controller' => 'ClientesNovedadesTipos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientesNovedades form large-9 medium-8 columns content">
    <?= $this->Form->create($clientesNovedade) ?>
    <fieldset>
        <legend><?= __('AddClientes Novedade') ?></legend>
        <?php            echo $this->Form->control('titulo');
            echo $this->Form->control('descripcion');
            echo $this->Form->control('clientes_novedades_tipos_id', ['options' => $clientesNovedadesTipos]);
            echo $this->Form->control('img_file');
            echo $this->Form->control('fecha', ['empty' => true]);
            echo $this->Form->control('activo');
            echo $this->Form->control('creado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
