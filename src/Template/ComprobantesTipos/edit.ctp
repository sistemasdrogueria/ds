<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $comprobantesTipo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $comprobantesTipo->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Comprobantes Tipos'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="comprobantesTipos form large-10 medium-9 columns">
    <?= $this->Form->create($comprobantesTipo) ?>
    <fieldset>
        <legend><?= __('Edit Comprobantes Tipo') ?></legend>
        <?php
            echo $this->Form->input('nombre');
            echo $this->Form->input('tipo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
