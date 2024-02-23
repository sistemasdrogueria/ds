<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Contactos'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="contactos form large-10 medium-9 columns">
    <?= $this->Form->create($contacto); ?>
    <fieldset>
        <legend><?= __('Add Contacto') ?></legend>
        <?php
            echo $this->Form->input('nombre');
            echo $this->Form->input('email');
            echo $this->Form->input('telefono');
            echo $this->Form->input('detalle');
            echo $this->Form->input('departamento');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
