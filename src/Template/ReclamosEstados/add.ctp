<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Reclamos Estados'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="reclamosEstados form large-10 medium-9 columns">
    <?= $this->Form->create($reclamosEstado) ?>
    <fieldset>
        <legend><?= __('Add Reclamos Estado') ?></legend>
        <?php
            echo $this->Form->input('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
