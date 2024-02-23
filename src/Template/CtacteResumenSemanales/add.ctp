<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Ctacte Resumen Semanales'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="ctacteResumenSemanales form large-10 medium-9 columns">
    <?= $this->Form->create($ctacteResumenSemanale) ?>
    <fieldset>
        <legend><?= __('Add Ctacte Resumen Semanale') ?></legend>
        <?php
            echo $this->Form->input('nro_sistema');
            echo $this->Form->input('nro_semana');
            echo $this->Form->input('desde', ['empty' => true, 'default' => '']);
            echo $this->Form->input('hasta', ['empty' => true, 'default' => '']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
