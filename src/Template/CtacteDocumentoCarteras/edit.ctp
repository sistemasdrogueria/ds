<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ctacteDocumentoCartera->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteDocumentoCartera->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ctacte Documento Carteras'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="ctacteDocumentoCarteras form large-10 medium-9 columns">
    <?= $this->Form->create($ctacteDocumentoCartera) ?>
    <fieldset>
        <legend><?= __('Edit Ctacte Documento Cartera') ?></legend>
        <?php
            echo $this->Form->input('fecha_deposito', ['empty' => true, 'default' => '']);
            echo $this->Form->input('cliente_id', ['options' => $clientes, 'empty' => true]);
            echo $this->Form->input('nro_cheque');
            echo $this->Form->input('fecha_ingreso', ['empty' => true, 'default' => '']);
            echo $this->Form->input('importe');
            echo $this->Form->input('origen');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
