<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Permisos Perfile'), ['action' => 'edit', $permisosPerfile->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Permisos Perfile'), ['action' => 'delete', $permisosPerfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permisosPerfile->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Permisos Perfiles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Permisos Perfile'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Perfiles'), ['controller' => 'Perfiles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Perfile'), ['controller' => 'Perfiles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Permisos'), ['controller' => 'Permisos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Permiso'), ['controller' => 'Permisos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="permisosPerfiles view large-10 medium-9 columns">
    <h2><?= h($permisosPerfile->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Perfile') ?></h6>
            <p><?= $permisosPerfile->has('perfile') ? $this->Html->link($permisosPerfile->perfile->id, ['controller' => 'Perfiles', 'action' => 'view', $permisosPerfile->perfile->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Permiso') ?></h6>
            <p><?= $permisosPerfile->has('permiso') ? $this->Html->link($permisosPerfile->permiso->id, ['controller' => 'Permisos', 'action' => 'view', $permisosPerfile->permiso->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($permisosPerfile->id) ?></p>
        </div>
    </div>
</div>
