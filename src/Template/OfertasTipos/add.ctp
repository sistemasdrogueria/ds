<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Ofertas Tipos'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="ofertasTipos form large-10 medium-9 columns">
    <?= $this->Form->create($ofertasTipo) ?>
    <fieldset>
        <legend><?= __('Add Ofertas Tipo') ?></legend>
        <?php
            echo $this->Form->input('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
