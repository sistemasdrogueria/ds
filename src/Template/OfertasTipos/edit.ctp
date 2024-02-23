<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ofertasTipo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ofertasTipo->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ofertas Tipos'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="ofertasTipos form large-10 medium-9 columns">
    <?= $this->Form->create($ofertasTipo) ?>
    <fieldset>
        <legend><?= __('Edit Ofertas Tipo') ?></legend>
        <?php
            echo $this->Form->input('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
