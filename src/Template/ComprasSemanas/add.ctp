<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Compras Semanas'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="comprasSemanas form large-10 medium-9 columns">
    <?= $this->Form->create($comprasSemana); ?>
    <fieldset>
        <legend><?= __('Add Compras Semana') ?></legend>
        <?php
            echo $this->Form->input('codigo');
            echo $this->Form->input('numero');
            echo $this->Form->input('fecha_factura', array('empty' => true, 'default' => ''));
            echo $this->Form->input('importe');
            echo $this->Form->input('tipo');
            echo $this->Form->input('fecha_vencimiento', array('empty' => true, 'default' => ''));
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
