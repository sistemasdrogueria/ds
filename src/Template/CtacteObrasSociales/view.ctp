<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Ctacte Obras Sociale'), ['action' => 'edit', $ctacteObrasSociale->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Obras Sociale'), ['action' => 'delete', $ctacteObrasSociale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteObrasSociale->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Obras Sociales'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Obras Sociale'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Obra Sociales'), ['controller' => 'ObraSociales', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Obra Sociale'), ['controller' => 'ObraSociales', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="ctacteObrasSociales view large-10 medium-9 columns">
    <h2><?= h($ctacteObrasSociale->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Obra Sociale') ?></h6>
            <p><?= $ctacteObrasSociale->has('obra_sociale') ? $this->Html->link($ctacteObrasSociale->obra_sociale->id, ['controller' => 'ObraSociales', 'action' => 'view', $ctacteObrasSociale->obra_sociale->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($ctacteObrasSociale->id) ?></p>
            <h6 class="subheader"><?= __('Importe') ?></h6>
            <p><?= $this->Number->format($ctacteObrasSociale->importe) ?></p>
            <h6 class="subheader"><?= __('Nro Nota') ?></h6>
            <p><?= $this->Number->format($ctacteObrasSociale->nro_nota) ?></p>
            <h6 class="subheader"><?= __('Tipo Nota') ?></h6>
            <p><?= $this->Number->format($ctacteObrasSociale->tipo_nota) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Fecha') ?></h6>
            <p><?= h($ctacteObrasSociale->fecha) ?></p>
        </div>
    </div>
</div>
