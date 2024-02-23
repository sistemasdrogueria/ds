<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CtacteResumenCuenta $ctacteResumenCuenta
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ctacteResumenCuenta->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteResumenCuenta->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ctacte Resumen Cuentas'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="ctacteResumenCuentas form large-9 medium-8 columns content">
    <?= $this->Form->create($ctacteResumenCuenta) ?>
    <fieldset>
        <legend><?= __('Edit Ctacte Resumen Cuenta') ?></legend>
        <?php
            echo $this->Form->control('nro_sistema');
            echo $this->Form->control('nro_semana');
            echo $this->Form->control('desde', ['empty' => true]);
            echo $this->Form->control('hasta', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
