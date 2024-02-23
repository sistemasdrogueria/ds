<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Clientesnos'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="clientesnos form large-10 medium-9 columns">
    <?= $this->Form->create($clientesno) ?>
    <fieldset>
        <legend><?= __('Add Clientesno') ?></legend>
        <?php
            echo $this->Form->input('razon_social');
            echo $this->Form->input('password');
            echo $this->Form->input('codigo_postal');
            echo $this->Form->input('provincia');
            echo $this->Form->input('representante');
            echo $this->Form->input('cambio_clave');
            echo $this->Form->input('email');
            echo $this->Form->input('clave_pedidos');
            echo $this->Form->input('codigo_pedidos');
            echo $this->Form->input('clacli');
            echo $this->Form->input('e_mail');
            echo $this->Form->input('domicilio');
            echo $this->Form->input('provinciatxt');
            echo $this->Form->input('localidad');
            echo $this->Form->input('ofertaxmail');
            echo $this->Form->input('respxmail');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
