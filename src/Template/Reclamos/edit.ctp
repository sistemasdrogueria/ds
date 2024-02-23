<div class="reclamos form large-10 medium-9 columns">
    <?= $this->Form->create($reclamo); ?>
    <fieldset>
        <legend><?= __('Edit Reclamo') ?></legend>
        <?php
            
            echo $this->Form->input('factura_numero');
            echo $this->Form->input('guia_numero');
            echo $this->Form->input('reclamos_tipo_id', ['options' => $reclamosTipos, 'empty' => true]);
            echo $this->Form->input('transporte');
            echo $this->Form->input('observaciones');
            echo $this->Form->input('fecha_recepcion', array('empty' => true, 'default' => ''));
            echo $this->Form->input('estado_id', ['options' => $estados, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
