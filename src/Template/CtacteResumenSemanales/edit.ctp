<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ctacteResumenSemanale->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteResumenSemanale->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ctacte Resumen Semanales'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="ctacteResumenSemanales form large-10 medium-9 columns">
    <?= $this->Form->create($ctacteResumenSemanale) ?>
    <fieldset>
        <legend><?= __('Edit Ctacte Resumen Semanale') ?></legend>
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
