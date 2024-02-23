<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Permiso'), ['action' => 'edit', $permiso->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Permiso'), ['action' => 'delete', $permiso->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permiso->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Permisos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Permiso'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Perfiles'), ['controller' => 'Perfiles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Perfile'), ['controller' => 'Perfiles', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="permisos view large-10 medium-9 columns">
    <h2><?= h($permiso->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Clase') ?></h6>
            <p><?= h($permiso->clase) ?></p>
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($permiso->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($permiso->id) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Perfiles') ?></h4>
    <?php if (!empty($permiso->perfiles)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Nombre') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($permiso->perfiles as $perfiles): ?>
        <tr>
            <td><?= h($perfiles->id) ?></td>
            <td><?= h($perfiles->nombre) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Perfiles', 'action' => 'view', $perfiles->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Perfiles', 'action' => 'edit', $perfiles->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Perfiles', 'action' => 'delete', $perfiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $perfiles->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
