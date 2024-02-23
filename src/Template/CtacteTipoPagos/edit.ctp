<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ctacteTipoPago->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTipoPago->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Pagos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="ctacteTipoPagos form large-9 medium-8 columns content">
    <?= $this->Form->create($ctacteTipoPago) ?>
    <fieldset>
        <legend><?= __('Edit Ctacte Tipo Pago') ?></legend>
        <?php
            echo $this->Form->input('nombre');
            echo $this->Form->input('terminobusqueda');
            echo $this->Form->input('grupo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
