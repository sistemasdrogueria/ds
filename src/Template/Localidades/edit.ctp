<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $localidade->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $localidade->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Localidades'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="localidades form large-10 medium-9 columns">
    <?= $this->Form->create($localidade); ?>
    <fieldset>
        <legend><?= __('Edit Localidade') ?></legend>
        <?php
            echo $this->Form->input('codigo');
            echo $this->Form->input('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
