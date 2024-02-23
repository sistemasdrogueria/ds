<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Articulo'), ['action' => 'edit', $articulo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Articulo'), ['action' => 'delete', $articulo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articulo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categorias'), ['controller' => 'Categorias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Categoria'), ['controller' => 'Categorias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Laboratorios'), ['controller' => 'Laboratorios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Laboratorio'), ['controller' => 'Laboratorios', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carritos Items'), ['controller' => 'CarritosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carritos Item'), ['controller' => 'CarritosItems', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Descuentos'), ['controller' => 'Descuentos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Descuento'), ['controller' => 'Descuentos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ofertas'), ['controller' => 'Ofertas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Oferta'), ['controller' => 'Ofertas', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedidos Items'), ['controller' => 'PedidosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedidos Item'), ['controller' => 'PedidosItems', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reclamos Items'), ['controller' => 'ReclamosItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reclamos Item'), ['controller' => 'ReclamosItems', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="articulos view large-10 medium-9 columns">
    <h2><?= h($articulo->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Troquel') ?></h6>
            <p><?= h($articulo->troquel) ?></p>
            <h6 class="subheader"><?= __('Descripcion Sist') ?></h6>
            <p><?= h($articulo->descripcion_sist) ?></p>
            <h6 class="subheader"><?= __('Descripcion Pag') ?></h6>
            <p><?= h($articulo->descripcion_pag) ?></p>
            <h6 class="subheader"><?= __('Categoria') ?></h6>
            <p><?= $articulo->has('categoria') ? $this->Html->link($articulo->categoria->id, ['controller' => 'Categorias', 'action' => 'view', $articulo->categoria->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Codigo Barras') ?></h6>
            <p><?= h($articulo->codigo_barras) ?></p>
            <h6 class="subheader"><?= __('Laboratorio') ?></h6>
            <p><?= $articulo->has('laboratorio') ? $this->Html->link($articulo->laboratorio->id, ['controller' => 'Laboratorios', 'action' => 'view', $articulo->laboratorio->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Stock') ?></h6>
            <p><?= h($articulo->stock) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($articulo->id) ?></p>
            <h6 class="subheader"><?= __('Subcategoria Id') ?></h6>
            <p><?= $this->Number->format($articulo->subcategoria_id) ?></p>
            <h6 class="subheader"><?= __('Precio Publico') ?></h6>
            <p><?= $this->Number->format($articulo->precio_publico) ?></p>
            <h6 class="subheader"><?= __('Precio Final') ?></h6>
            <p><?= $this->Number->format($articulo->precio_final) ?></p>
            <h6 class="subheader"><?= __('Clave Amp') ?></h6>
            <p><?= $this->Number->format($articulo->clave_amp) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Cadena Frio') ?></h6>
            <p><?= $articulo->cadena_frio ? __('Yes') : __('No'); ?></p>
            <h6 class="subheader"><?= __('Iva') ?></h6>
            <p><?= $articulo->iva ? __('Yes') : __('No'); ?></p>
            <h6 class="subheader"><?= __('Msd') ?></h6>
            <p><?= $articulo->msd ? __('Yes') : __('No'); ?></p>
            <h6 class="subheader"><?= __('Trazable') ?></h6>
            <p><?= $articulo->trazable ? __('Yes') : __('No'); ?></p>
            <h6 class="subheader"><?= __('Pack') ?></h6>
            <p><?= $articulo->pack ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related CarritosItems') ?></h4>
    <?php if (!empty($articulo->carritos_items)): ?>
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
        <?php foreach ($articulo->carritos_items as $carritosItems): ?>
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
    <h4 class="subheader"><?= __('Related Descuentos') ?></h4>
    <?php if (!empty($articulo->descuentos)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Articulo Id') ?></th>
            <th><?= __('Fecha Desde') ?></th>
            <th><?= __('Fecha Hasta') ?></th>
            <th><?= __('Precio Costo') ?></th>
            <th><?= __('Dto Patagonia') ?></th>
            <th><?= __('Dto Drogueria') ?></th>
            <th><?= __('Unidadfact') ?></th>
            <th><?= __('Discrimina Iva') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($articulo->descuentos as $descuentos): ?>
        <tr>
            <td><?= h($descuentos->id) ?></td>
            <td><?= h($descuentos->articulo_id) ?></td>
            <td><?= h($descuentos->fecha_desde) ?></td>
            <td><?= h($descuentos->fecha_hasta) ?></td>
            <td><?= h($descuentos->precio_costo) ?></td>
            <td><?= h($descuentos->dto_patagonia) ?></td>
            <td><?= h($descuentos->dto_drogueria) ?></td>
            <td><?= h($descuentos->unidadfact) ?></td>
            <td><?= h($descuentos->discrimina_iva) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Descuentos', 'action' => 'view', $descuentos->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Descuentos', 'action' => 'edit', $descuentos->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Descuentos', 'action' => 'delete', $descuentos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $descuentos->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Ofertas') ?></h4>
    <?php if (!empty($articulo->ofertas)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Proveedor Id') ?></th>
            <th><?= __('Articulo Id') ?></th>
            <th><?= __('Descripcion') ?></th>
            <th><?= __('Descuento Producto') ?></th>
            <th><?= __('Unidades Minimas') ?></th>
            <th><?= __('Fecha Desde') ?></th>
            <th><?= __('Fecha Hasta') ?></th>
            <th><?= __('Plazos') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($articulo->ofertas as $ofertas): ?>
        <tr>
            <td><?= h($ofertas->id) ?></td>
            <td><?= h($ofertas->proveedor_id) ?></td>
            <td><?= h($ofertas->articulo_id) ?></td>
            <td><?= h($ofertas->descripcion) ?></td>
            <td><?= h($ofertas->descuento_producto) ?></td>
            <td><?= h($ofertas->unidades_minimas) ?></td>
            <td><?= h($ofertas->fecha_desde) ?></td>
            <td><?= h($ofertas->fecha_hasta) ?></td>
            <td><?= h($ofertas->plazos) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Ofertas', 'action' => 'view', $ofertas->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Ofertas', 'action' => 'edit', $ofertas->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ofertas', 'action' => 'delete', $ofertas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ofertas->id)]) ?>

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
    <?php if (!empty($articulo->pedidos_items)): ?>
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
        <?php foreach ($articulo->pedidos_items as $pedidosItems): ?>
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
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related ReclamosItems') ?></h4>
    <?php if (!empty($articulo->reclamos_items)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Reclamo Id') ?></th>
            <th><?= __('Articulo Id') ?></th>
            <th><?= __('Cantidad') ?></th>
            <th><?= __('Detalle') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($articulo->reclamos_items as $reclamosItems): ?>
        <tr>
            <td><?= h($reclamosItems->id) ?></td>
            <td><?= h($reclamosItems->reclamo_id) ?></td>
            <td><?= h($reclamosItems->articulo_id) ?></td>
            <td><?= h($reclamosItems->cantidad) ?></td>
            <td><?= h($reclamosItems->detalle) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'ReclamosItems', 'action' => 'view', $reclamosItems->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'ReclamosItems', 'action' => 'edit', $reclamosItems->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ReclamosItems', 'action' => 'delete', $reclamosItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reclamosItems->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
