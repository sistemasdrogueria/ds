<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Localidades'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="localidades form large-10 medium-9 columns">
    <?= $this->Form->create($localidade); ?>
    <fieldset>
        <legend><?= __('Add Localidade') ?></legend>
        <?php
            echo $this->Form->input('codigo');
            echo $this->Form->input('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
