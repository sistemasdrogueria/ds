<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grupo $grupo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Grupo'), ['action' => 'edit', $grupo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Grupo'), ['action' => 'delete', $grupo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grupo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Grupos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grupo'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Subcategorias'), ['controller' => 'Subcategorias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subcategoria'), ['controller' => 'Subcategorias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Subgrupos'), ['controller' => 'Subgrupos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subgrupo'), ['controller' => 'Subgrupos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Pagos'), ['controller' => 'CtacteTipoPagos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Tipo Pago'), ['controller' => 'CtacteTipoPagos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="grupos view large-9 medium-8 columns content">
    <h3><?= h($grupo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($grupo->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($grupo->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subcategoria') ?></th>
            <td><?= $grupo->has('subcategoria') ? $this->Html->link($grupo->subcategoria->id, ['controller' => 'Subcategorias', 'action' => 'view', $grupo->subcategoria->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($grupo->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ctacte Tipo Pagos') ?></h4>
        <?php if (!empty($grupo->ctacte_tipo_pagos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Nombre') ?></th>
                <th scope="col"><?= __('Terminobusqueda') ?></th>
                <th scope="col"><?= __('Grupo') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($grupo->ctacte_tipo_pagos as $ctacteTipoPagos): ?>
            <tr>
                <td><?= h($ctacteTipoPagos->id) ?></td>
                <td><?= h($ctacteTipoPagos->nombre) ?></td>
                <td><?= h($ctacteTipoPagos->terminobusqueda) ?></td>
                <td><?= h($ctacteTipoPagos->grupo) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CtacteTipoPagos', 'action' => 'view', $ctacteTipoPagos->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CtacteTipoPagos', 'action' => 'edit', $ctacteTipoPagos->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CtacteTipoPagos', 'action' => 'delete', $ctacteTipoPagos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTipoPagos->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Articulos') ?></h4>
        <?php if (!empty($grupo->articulos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Troquel') ?></th>
                <th scope="col"><?= __('Descripcion Sist') ?></th>
                <th scope="col"><?= __('Descripcion Pag') ?></th>
                <th scope="col"><?= __('Categoria Id') ?></th>
                <th scope="col"><?= __('Subcategoria Id') ?></th>
                <th scope="col"><?= __('Codigo Barras') ?></th>
                <th scope="col"><?= __('Laboratorio Id') ?></th>
                <th scope="col"><?= __('Precio Publico') ?></th>
                <th scope="col"><?= __('Precio Final') ?></th>
                <th scope="col"><?= __('Stock') ?></th>
                <th scope="col"><?= __('Cadena Frio') ?></th>
                <th scope="col"><?= __('Iva') ?></th>
                <th scope="col"><?= __('Msd') ?></th>
                <th scope="col"><?= __('Clave Amp') ?></th>
                <th scope="col"><?= __('Trazable') ?></th>
                <th scope="col"><?= __('Pack') ?></th>
                <th scope="col"><?= __('Proveedor Id') ?></th>
                <th scope="col"><?= __('Restringido') ?></th>
                <th scope="col"><?= __('Nuevo') ?></th>
                <th scope="col"><?= __('Fecha Alta') ?></th>
                <th scope="col"><?= __('Codigo Barras2') ?></th>
                <th scope="col"><?= __('Codigo Barras3') ?></th>
                <th scope="col"><?= __('Recupera Iva') ?></th>
                <th scope="col"><?= __('Eliminado') ?></th>
                <th scope="col"><?= __('Fv Cerca') ?></th>
                <th scope="col"><?= __('Fv') ?></th>
                <th scope="col"><?= __('Chequeo') ?></th>
                <th scope="col"><?= __('Compra Min') ?></th>
                <th scope="col"><?= __('Compra Multiplo') ?></th>
                <th scope="col"><?= __('Compra Max') ?></th>
                <th scope="col"><?= __('Restringido Perf') ?></th>
                <th scope="col"><?= __('Exportacion Avion') ?></th>
                <th scope="col"><?= __('C Barra') ?></th>
                <th scope="col"><?= __('Imagen') ?></th>
                <th scope="col"><?= __('Paq') ?></th>
                <th scope="col"><?= __('Venta Paq') ?></th>
                <th scope="col"><?= __('Precio Actualizacion') ?></th>
                <th scope="col"><?= __('Mcdp') ?></th>
                <th scope="col"><?= __('Importado') ?></th>
                <th scope="col"><?= __('Grupo Id') ?></th>
                <th scope="col"><?= __('Sub Grupo Id') ?></th>
                <th scope="col"><?= __('Marca Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($grupo->articulos as $articulos): ?>
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
                <td><?= h($articulos->proveedor_id) ?></td>
                <td><?= h($articulos->restringido) ?></td>
                <td><?= h($articulos->nuevo) ?></td>
                <td><?= h($articulos->fecha_alta) ?></td>
                <td><?= h($articulos->codigo_barras2) ?></td>
                <td><?= h($articulos->codigo_barras3) ?></td>
                <td><?= h($articulos->recupera_iva) ?></td>
                <td><?= h($articulos->eliminado) ?></td>
                <td><?= h($articulos->fv_cerca) ?></td>
                <td><?= h($articulos->fv) ?></td>
                <td><?= h($articulos->chequeo) ?></td>
                <td><?= h($articulos->compra_min) ?></td>
                <td><?= h($articulos->compra_multiplo) ?></td>
                <td><?= h($articulos->compra_max) ?></td>
                <td><?= h($articulos->restringido_perf) ?></td>
                <td><?= h($articulos->exportacion_avion) ?></td>
                <td><?= h($articulos->c_barra) ?></td>
                <td><?= h($articulos->imagen) ?></td>
                <td><?= h($articulos->paq) ?></td>
                <td><?= h($articulos->venta_paq) ?></td>
                <td><?= h($articulos->precio_actualizacion) ?></td>
                <td><?= h($articulos->mcdp) ?></td>
                <td><?= h($articulos->importado) ?></td>
                <td><?= h($articulos->grupo_id) ?></td>
                <td><?= h($articulos->sub_grupo_id) ?></td>
                <td><?= h($articulos->marca_id) ?></td>
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
    <div class="related">
        <h4><?= __('Related Clientes') ?></h4>
        <?php if (!empty($grupo->clientes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Codigo') ?></th>
                <th scope="col"><?= __('Razon Social') ?></th>
                <th scope="col"><?= __('Cuit') ?></th>
                <th scope="col"><?= __('Nombre') ?></th>
                <th scope="col"><?= __('Codigo Postal') ?></th>
                <th scope="col"><?= __('Domicilio') ?></th>
                <th scope="col"><?= __('Provincia Id') ?></th>
                <th scope="col"><?= __('Localidad Id') ?></th>
                <th scope="col"><?= __('Telefono') ?></th>
                <th scope="col"><?= __('Tienesucursal') ?></th>
                <th scope="col"><?= __('Representante Id') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Email Alternativo') ?></th>
                <th scope="col"><?= __('Email Factura') ?></th>
                <th scope="col"><?= __('Clave Pedidos') ?></th>
                <th scope="col"><?= __('Codigo Pedidos') ?></th>
                <th scope="col"><?= __('Ofertaxmail') ?></th>
                <th scope="col"><?= __('Respuestaxmail') ?></th>
                <th scope="col"><?= __('Facturaxmail') ?></th>
                <th scope="col"><?= __('Clacli') ?></th>
                <th scope="col"><?= __('Gln') ?></th>
                <th scope="col"><?= __('Grupo Id') ?></th>
                <th scope="col"><?= __('Habilitado') ?></th>
                <th scope="col"><?= __('Coeficiente') ?></th>
                <th scope="col"><?= __('Coeficientepp') ?></th>
                <th scope="col"><?= __('Eliminado') ?></th>
                <th scope="col"><?= __('Actualizo Correo') ?></th>
                <th scope="col"><?= __('Actualizo Gln') ?></th>
                <th scope="col"><?= __('Plazo Acordado') ?></th>
                <th scope="col"><?= __('Preciofarmacia Descuento') ?></th>
                <th scope="col"><?= __('Condicion Descuento') ?></th>
                <th scope="col"><?= __('Categoria') ?></th>
                <th scope="col"><?= __('Identificacion') ?></th>
                <th scope="col"><?= __('Cuentaprincipal') ?></th>
                <th scope="col"><?= __('Comunidadsur') ?></th>
                <th scope="col"><?= __('Farmapoint') ?></th>
                <th scope="col"><?= __('Selectos') ?></th>
                <th scope="col"><?= __('Creado') ?></th>
                <th scope="col"><?= __('Restringido') ?></th>
                <th scope="col"><?= __('Restringido Unidades') ?></th>
                <th scope="col"><?= __('Notas Pami') ?></th>
                <th scope="col"><?= __('Actualizo App') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($grupo->clientes as $clientes): ?>
            <tr>
                <td><?= h($clientes->id) ?></td>
                <td><?= h($clientes->codigo) ?></td>
                <td><?= h($clientes->razon_social) ?></td>
                <td><?= h($clientes->cuit) ?></td>
                <td><?= h($clientes->nombre) ?></td>
                <td><?= h($clientes->codigo_postal) ?></td>
                <td><?= h($clientes->domicilio) ?></td>
                <td><?= h($clientes->provincia_id) ?></td>
                <td><?= h($clientes->localidad_id) ?></td>
                <td><?= h($clientes->telefono) ?></td>
                <td><?= h($clientes->tienesucursal) ?></td>
                <td><?= h($clientes->representante_id) ?></td>
                <td><?= h($clientes->email) ?></td>
                <td><?= h($clientes->email_alternativo) ?></td>
                <td><?= h($clientes->email_factura) ?></td>
                <td><?= h($clientes->clave_pedidos) ?></td>
                <td><?= h($clientes->codigo_pedidos) ?></td>
                <td><?= h($clientes->ofertaxmail) ?></td>
                <td><?= h($clientes->respuestaxmail) ?></td>
                <td><?= h($clientes->facturaxmail) ?></td>
                <td><?= h($clientes->clacli) ?></td>
                <td><?= h($clientes->gln) ?></td>
                <td><?= h($clientes->grupo_id) ?></td>
                <td><?= h($clientes->habilitado) ?></td>
                <td><?= h($clientes->coeficiente) ?></td>
                <td><?= h($clientes->coeficientepp) ?></td>
                <td><?= h($clientes->eliminado) ?></td>
                <td><?= h($clientes->actualizo_correo) ?></td>
                <td><?= h($clientes->actualizo_gln) ?></td>
                <td><?= h($clientes->plazo_acordado) ?></td>
                <td><?= h($clientes->preciofarmacia_descuento) ?></td>
                <td><?= h($clientes->condicion_descuento) ?></td>
                <td><?= h($clientes->categoria) ?></td>
                <td><?= h($clientes->identificacion) ?></td>
                <td><?= h($clientes->cuentaprincipal) ?></td>
                <td><?= h($clientes->comunidadsur) ?></td>
                <td><?= h($clientes->farmapoint) ?></td>
                <td><?= h($clientes->selectos) ?></td>
                <td><?= h($clientes->creado) ?></td>
                <td><?= h($clientes->restringido) ?></td>
                <td><?= h($clientes->restringido_unidades) ?></td>
                <td><?= h($clientes->notas_pami) ?></td>
                <td><?= h($clientes->actualizo_app) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Clientes', 'action' => 'view', $clientes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Clientes', 'action' => 'edit', $clientes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Clientes', 'action' => 'delete', $clientes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Subgrupos') ?></h4>
        <?php if (!empty($grupo->subgrupos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Nombre') ?></th>
                <th scope="col"><?= __('Descripcion') ?></th>
                <th scope="col"><?= __('Grupo Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($grupo->subgrupos as $subgrupos): ?>
            <tr>
                <td><?= h($subgrupos->id) ?></td>
                <td><?= h($subgrupos->nombre) ?></td>
                <td><?= h($subgrupos->descripcion) ?></td>
                <td><?= h($subgrupos->grupo_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Subgrupos', 'action' => 'view', $subgrupos->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Subgrupos', 'action' => 'edit', $subgrupos->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Subgrupos', 'action' => 'delete', $subgrupos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subgrupos->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
