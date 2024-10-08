<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $obraSociale->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $obraSociale->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Obra Sociales'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="obraSociales form large-10 medium-9 columns">
    <?= $this->Form->create($obraSociale) ?>
    <fieldset>
        <legend><?= __('Edit Obra Sociale') ?></legend>
        <?php
            echo $this->Form->input('codigo');
            echo $this->Form->input('nombre');
            echo $this->Form->input('nombrecompleto');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
