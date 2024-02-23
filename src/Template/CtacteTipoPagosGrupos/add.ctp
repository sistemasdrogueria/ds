<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Pagos Grupos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="ctacteTipoPagosGrupos form large-9 medium-8 columns content">
    <?= $this->Form->create($ctacteTipoPagosGrupo) ?>
    <fieldset>
        <legend><?= __('Add Ctacte Tipo Pagos Grupo') ?></legend>
        <?php
            echo $this->Form->input('nombre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
