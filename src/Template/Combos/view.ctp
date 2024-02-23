<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Combo'), ['action' => 'edit', $combo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Combo'), ['action' => 'delete', $combo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $combo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Combos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carritos Items'), ['controller' => 'CarritosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carritos Item'), ['controller' => 'CarritosItems', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos Items'), ['controller' => 'PedidosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedidos Item'), ['controller' => 'PedidosItems', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="combos view large-10 medium-9 columns">
    <h2><?= h($combo->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Nombre') ?></h6>
            <p><?= h($combo->nombre) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($combo->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Desde') ?></h6>
            <p><?= h($combo->desde) ?></p>
            <h6 class="subheader"><?= __('Hasta') ?></h6>
            <p><?= h($combo->hasta) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related CarritosItems') ?></h4>
    <?php if (!empty($combo->carritos_items)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Agregado') ?></th>
            <th><?= __('Carrito Id') ?></th>
            <th><?= __('Articulo Id') ?></th>
            <th><?= __('Cantidad') ?></th>
            <th><?= __('Precio Publico') ?></th>
            <th><?= __('Descuento') ?></th>
            <th><?= __('Unidad Minima') ?></th>
            <th><?= __('Tipo Precio') ?></th>
            <th><?= __('Plazoley Dcto') ?></th>
            <th><?= __('Combo Id') ?></th>
            <th><?= __('Tipo Oferta') ?></th>
            <th><?= __('Tipo Oferta Elegida') ?></th>
            <th><?= __('Tipo Fact') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($combo->carritos_items as $carritosItems): ?>
        <tr>
            <td><?= h($carritosItems->id) ?></td>
            <td><?= h($carritosItems->agregado) ?></td>
            <td><?= h($carritosItems->carrito_id) ?></td>
            <td><?= h($carritosItems->articulo_id) ?></td>
            <td><?= h($carritosItems->cantidad) ?></td>
            <td><?= h($carritosItems->precio_publico) ?></td>
            <td><?= h($carritosItems->descuento) ?></td>
            <td><?= h($carritosItems->unidad_minima) ?></td>
            <td><?= h($carritosItems->tipo_precio) ?></td>
            <td><?= h($carritosItems->plazoley_dcto) ?></td>
            <td><?= h($carritosItems->combo_id) ?></td>
            <td><?= h($carritosItems->tipo_oferta) ?></td>
            <td><?= h($carritosItems->tipo_oferta_elegida) ?></td>
            <td><?= h($carritosItems->tipo_fact) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'CarritosItems', 'action' => 'view', $carritosItems->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'CarritosItems', 'action' => 'edit', $carritosItems->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CarritosItems', 'action' => 'delete', $carritosItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carritosItems->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related PedidosItems') ?></h4>
    <?php if (!empty($combo->pedidos_items)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Agregado') ?></th>
            <th><?= __('Pedido Id') ?></th>
            <th><?= __('Articulo Id') ?></th>
            <th><?= __('Cantidad') ?></th>
            <th><?= __('Precio Publico') ?></th>
            <th><?= __('Descuento') ?></th>
            <th><?= __('Unidad Minima') ?></th>
            <th><?= __('Tipo Precio') ?></th>
            <th><?= __('Plazoley Dcto') ?></th>
            <th><?= __('Combo Id') ?></th>
            <th><?= __('Tipo Oferta') ?></th>
            <th><?= __('Tipo Oferta Elegida') ?></th>
            <th><?= __('Tipo Fact') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($combo->pedidos_items as $pedidosItems): ?>
        <tr>
            <td><?= h($pedidosItems->id) ?></td>
            <td><?= h($pedidosItems->agregado) ?></td>
            <td><?= h($pedidosItems->pedido_id) ?></td>
            <td><?= h($pedidosItems->articulo_id) ?></td>
            <td><?= h($pedidosItems->cantidad) ?></td>
            <td><?= h($pedidosItems->precio_publico) ?></td>
            <td><?= h($pedidosItems->descuento) ?></td>
            <td><?= h($pedidosItems->unidad_minima) ?></td>
            <td><?= h($pedidosItems->tipo_precio) ?></td>
            <td><?= h($pedidosItems->plazoley_dcto) ?></td>
            <td><?= h($pedidosItems->combo_id) ?></td>
            <td><?= h($pedidosItems->tipo_oferta) ?></td>
            <td><?= h($pedidosItems->tipo_oferta_elegida) ?></td>
            <td><?= h($pedidosItems->tipo_fact) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'PedidosItems', 'action' => 'view', $pedidosItems->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'PedidosItems', 'action' => 'edit', $pedidosItems->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PedidosItems', 'action' => 'delete', $pedidosItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pedidosItems->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
