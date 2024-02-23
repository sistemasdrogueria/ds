<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Clientesno'), ['action' => 'edit', $clientesno->codigo]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Clientesno'), ['action' => 'delete', $clientesno->codigo], ['confirm' => __('Are you sure you want to delete # {0}?', $clientesno->codigo)]) ?> </li>
        <li><?= $this->Html->link(__('List Clientesnos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Clientesno'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="clientesnos view large-10 medium-9 columns">
    <h2><?= h($clientesno->codigo) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Representante') ?></h6>
            <p><?= h($clientesno->representante) ?></p>
            <h6 class="subheader"><?= __('Cambio Clave') ?></h6>
            <p><?= h($clientesno->cambio_clave) ?></p>
            <h6 class="subheader"><?= __('Email') ?></h6>
            <p><?= h($clientesno->email) ?></p>
            <h6 class="subheader"><?= __('Clacli') ?></h6>
            <p><?= h($clientesno->clacli) ?></p>
            <h6 class="subheader"><?= __('Domicilio') ?></h6>
            <p><?= h($clientesno->domicilio) ?></p>
            <h6 class="subheader"><?= __('Provinciatxt') ?></h6>
            <p><?= h($clientesno->provinciatxt) ?></p>
            <h6 class="subheader"><?= __('Localidad') ?></h6>
            <p><?= h($clientesno->localidad) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Codigo') ?></h6>
            <p><?= $this->Number->format($clientesno->codigo) ?></p>
            <h6 class="subheader"><?= __('Provincia') ?></h6>
            <p><?= $this->Number->format($clientesno->provincia) ?></p>
            <h6 class="subheader"><?= __('Clave Pedidos') ?></h6>
            <p><?= $this->Number->format($clientesno->clave_pedidos) ?></p>
            <h6 class="subheader"><?= __('Codigo Pedidos') ?></h6>
            <p><?= $this->Number->format($clientesno->codigo_pedidos) ?></p>
            <h6 class="subheader"><?= __('Ofertaxmail') ?></h6>
            <p><?= $this->Number->format($clientesno->ofertaxmail) ?></p>
            <h6 class="subheader"><?= __('Respxmail') ?></h6>
            <p><?= $this->Number->format($clientesno->respxmail) ?></p>
            <h6 class="subheader"><?= __('Sucursal') ?></h6>
            <p><?= $this->Number->format($clientesno->sucursal) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Razon Social') ?></h6>
            <?= $this->Text->autoParagraph(h($clientesno->razon_social)) ?>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Password') ?></h6>
            <?= $this->Text->autoParagraph(h($clientesno->password)) ?>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Codigo Postal') ?></h6>
            <?= $this->Text->autoParagraph(h($clientesno->codigo_postal)) ?>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('E Mail') ?></h6>
            <?= $this->Text->autoParagraph(h($clientesno->e_mail)) ?>
        </div>
    </div>
</div>
