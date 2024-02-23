<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Ctacte Obras Sociale'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Obra Sociales'), ['controller' => 'ObraSociales', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Obra Sociale'), ['controller' => 'ObraSociales', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="ctacteObrasSociales index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('fecha') ?></th>
            <th><?= $this->Paginator->sort('importe') ?></th>
            <th><?= $this->Paginator->sort('obra_sociales_id') ?></th>
            <th><?= $this->Paginator->sort('nro_nota') ?></th>
            <th><?= $this->Paginator->sort('tipo_nota') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($ctacteObrasSociales as $ctacteObrasSociale): ?>
        <tr>
            <td><?= $this->Number->format($ctacteObrasSociale->id) ?></td>
            <td><?= h($ctacteObrasSociale->fecha) ?></td>
            <td><?= $this->Number->format($ctacteObrasSociale->importe) ?></td>
            <td>
                <?= $ctacteObrasSociale->has('obra_sociale') ? $this->Html->link($ctacteObrasSociale->obra_sociale->id, ['controller' => 'ObraSociales', 'action' => 'view', $ctacteObrasSociale->obra_sociale->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($ctacteObrasSociale->nro_nota) ?></td>
            <td><?= $this->Number->format($ctacteObrasSociale->tipo_nota) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $ctacteObrasSociale->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ctacteObrasSociale->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ctacteObrasSociale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteObrasSociale->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
