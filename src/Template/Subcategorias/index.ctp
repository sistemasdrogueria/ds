<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Subcategoria'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categorias'), ['controller' => 'Categorias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Categoria'), ['controller' => 'Categorias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="subcategorias index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th><?= $this->Paginator->sort('descripcion') ?></th>
            <th><?= $this->Paginator->sort('categoria_id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($subcategorias as $subcategoria): ?>
        <tr>
            <td><?= $this->Number->format($subcategoria->id) ?></td>
            <td><?= h($subcategoria->nombre) ?></td>
            <td><?= h($subcategoria->descripcion) ?></td>
            <td>
                <?= $subcategoria->has('categoria') ? $this->Html->link($subcategoria->categoria->id, ['controller' => 'Categorias', 'action' => 'view', $subcategoria->categoria->id]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $subcategoria->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $subcategoria->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subcategoria->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subcategoria->id)]) ?>
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
