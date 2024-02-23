<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientesNovedadesTipo $clientesNovedadesTipo
 */
?><nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clientesNovedadesTipo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientesNovedadesTipo->id)]
            )
        ?></li>        <li><?= $this->Html->link(__('ListClientes Novedades Tipos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="clientesNovedadesTipos form large-9 medium-8 columns content">
    <?= $this->Form->create($clientesNovedadesTipo) ?>
    <fieldset>
        <legend><?= __('EditClientes Novedades Tipo') ?></legend>
        <?php            echo $this->Form->control('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
