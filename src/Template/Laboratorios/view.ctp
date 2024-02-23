<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Laboratorio'), ['action' => 'edit', $laboratorio->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Laboratorio'), ['action' => 'delete', $laboratorio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $laboratorio->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Laboratorios'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Laboratorio'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="laboratorios view large-10 medium-9 columns">
    <h2><?= h($laboratorio->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Codigo') ?></h6>
            <p><?= h($laboratorio->codigo) ?></p>
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($laboratorio->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($laboratorio->id) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Articulos') ?></h4>
    <?php if (!empty($laboratorio->articulos)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Troquel') ?></th>
            <th><?= __('Descripcion Sist') ?></th>
            <th><?= __('Descripcion Pag') ?></th>
            <th><?= __('Categoria Id') ?></th>
            <th><?= __('Subcategoria Id') ?></th>
            <th><?= __('Codigo Barras') ?></th>
            <th><?= __('Laboratorio Id') ?></th>
            <th><?= __('Precio Publico') ?></th>
            <th><?= __('Precio Final') ?></th>
            <th><?= __('Stock') ?></th>
            <th><?= __('Cadena Frio') ?></th>
            <th><?= __('Iva') ?></th>
            <th><?= __('Msd') ?></th>
            <th><?= __('Clave Amp') ?></th>
            <th><?= __('Trazable') ?></th>
            <th><?= __('Pack') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($laboratorio->articulos as $articulos): ?>
        <tr>
            <td><?= h($articulos->id) ?></td>
            <td><?= h($articulos->troquel) ?></td>
            <td><?= h($articulos->descripcion_sist) ?></td>
            <td><?= h($articulos->descripcion_pag) ?></td>
            <td><?= h($articulos->categoria_id) ?></td>
            <td><?= h($articulos->subcategoria_id) ?></td>
            <td><?= h($articulos->codigo_barras) ?></td>
            <td><?= h($articulos->laboratorio_id) ?></td>
            <td><?= h($articulos->precio_publico) ?></td>
            <td><?= h($articulos->precio_final) ?></td>
            <td><?= h($articulos->stock) ?></td>
            <td><?= h($articulos->cadena_frio) ?></td>
            <td><?= h($articulos->iva) ?></td>
            <td><?= h($articulos->msd) ?></td>
            <td><?= h($articulos->clave_amp) ?></td>
            <td><?= h($articulos->trazable) ?></td>
            <td><?= h($articulos->pack) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Articulos', 'action' => 'view', $articulos->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Articulos', 'action' => 'edit', $articulos->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Articulos', 'action' => 'delete', $articulos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articulos->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
