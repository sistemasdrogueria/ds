<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ctacteTipoRegistro->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTipoRegistro->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Registros'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="ctacteTipoRegistros form large-10 medium-9 columns">
    <?= $this->Form->create($ctacteTipoRegistro) ?>
    <fieldset>
        <legend><?= __('Edit Ctacte Tipo Registro') ?></legend>
        <?php
            echo $this->Form->input('nombre');
            echo $this->Form->input('codigo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
