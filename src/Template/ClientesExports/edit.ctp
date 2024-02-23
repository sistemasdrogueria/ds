<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clientesExport->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientesExport->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Clientes Exports'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="clientesExports form large-9 medium-8 columns content">
    <?= $this->Form->create($clientesExport) ?>
    <fieldset>
        <legend><?= __('Edit Clientes Export') ?></legend>
        <?php
            echo $this->Form->input('cta_comun');
            echo $this->Form->input('cta_exportacion');
            echo $this->Form->input('cliente_comun_id');
            echo $this->Form->input('cliente_export_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
