<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Contacto'), ['action' => 'edit', $contacto->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contacto'), ['action' => 'delete', $contacto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contacto->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contactos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contacto'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="contactos view large-10 medium-9 columns">
    <h2><?= h($contacto->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($contacto->nombre) ?></p>
            <h6 class="subheader"><?= __('Email') ?></h6>
            <p><?= h($contacto->email) ?></p>
            <h6 class="subheader"><?= __('Telefono') ?></h6>
            <p><?= h($contacto->telefono) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($contacto->id) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Detalle') ?></h6>
            <?= $this->Text->autoParagraph(h($contacto->detalle)); ?>

        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Departamento') ?></h6>
            <?= $this->Text->autoParagraph(h($contacto->departamento)); ?>

        </div>
    </div>
</div>
