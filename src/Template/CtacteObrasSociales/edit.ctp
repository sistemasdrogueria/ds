<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ctacteObrasSociale->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteObrasSociale->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ctacte Obras Sociales'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Obra Sociales'), ['controller' => 'ObraSociales', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Obra Sociale'), ['controller' => 'ObraSociales', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="ctacteObrasSociales form large-10 medium-9 columns">
    <?= $this->Form->create($ctacteObrasSociale) ?>
    <fieldset>
        <legend><?= __('Edit Ctacte Obras Sociale') ?></legend>
        <?php
            echo $this->Form->input('fecha', ['empty' => true, 'default' => '']);
            echo $this->Form->input('importe');
            echo $this->Form->input('obra_sociales_id', ['options' => $obraSociales, 'empty' => true]);
            echo $this->Form->input('nro_nota');
            echo $this->Form->input('tipo_nota');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
