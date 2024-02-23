<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Reclamos Tipo'), ['action' => 'edit', $reclamosTipo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reclamos Tipo'), ['action' => 'delete', $reclamosTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamosTipo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reclamos Tipos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamos Tipo'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reclamos'), ['controller' => 'Reclamos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamo'), ['controller' => 'Reclamos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="reclamosTipos view large-10 medium-9 columns">
    <h2><?= h($reclamosTipo->id) ?></h2>
    <div class="row">
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($reclamosTipo->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($reclamosTipo->nombre) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Reclamos') ?></h4>
    <?php if (!empty($reclamosTipo->reclamos)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Cliente Id') ?></th>
            <th><?= __('Factura Numero') ?></th>
            <th><?= __('Guia Numero') ?></th>
            <th><?= __('Reclamos Tipo Id') ?></th>
            <th><?= __('Transporte') ?></th>
            <th><?= __('Observaciones') ?></th>
            <th><?= __('Fecha Recepcion') ?></th>
            <th><?= __('Estado Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($reclamosTipo->reclamos as $reclamos): ?>
        <tr>
            <td><?= h($reclamos->id) ?></td>
            <td><?= h($reclamos->cliente_id) ?></td>
            <td><?= h($reclamos->factura_numero) ?></td>
            <td><?= h($reclamos->guia_numero) ?></td>
            <td><?= h($reclamos->reclamos_tipo_id) ?></td>
            <td><?= h($reclamos->transporte) ?></td>
            <td><?= h($reclamos->observaciones) ?></td>
            <td><?= h($reclamos->fecha_recepcion) ?></td>
            <td><?= h($reclamos->estado_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Reclamos', 'action' => 'view', $reclamos->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Reclamos', 'action' => 'edit', $reclamos->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Reclamos', 'action' => 'delete', $reclamos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamos->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
