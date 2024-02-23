<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Usuarios Tipo'), ['action' => 'edit', $usuariosTipo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Usuarios Tipo'), ['action' => 'delete', $usuariosTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usuariosTipo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Usuarios Tipos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Usuarios Tipo'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="usuariosTipos view large-10 medium-9 columns">
    <h2><?= h($usuariosTipo->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($usuariosTipo->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($usuariosTipo->id) ?></p>
        </div>
    </div>
</div>
