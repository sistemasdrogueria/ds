<div id="articulosGrid" class="articulos-grid">
    <?php foreach ($reclamositemstemps as $reclamosItemsTemp): ?>
        <div class="articulo-card">
            <h3 class="product-title"><?= $reclamosItemsTemp->detalle ?></h3>
            <div style="display: flex;flex-wrap: nowrap;flex-direction: row;align-items: center;">
                <div>
                    <?php
                    $articulo = $reclamosItemsTemp->articulo;
                    $articuloData = [
                        'imagen' => $this->Url->build('/img/productos/big_' . $reclamosItemsTemp->articulo->imagen, ['fullBase' => true]),
                        'descripcionSist' => $articulo->descripcion_sist,
                        'descripcionPag' => $articulo->descripcion_pag,
                        'claveAmp' => $articulo->clave_amp,
                        'troquel' => $articulo->troquel,
                        'codigoBarras' => $articulo->codigo_barras,
                        'categoria' => $articulo->categoria->nombre ?? ' - ',
                        'subcategoria' => $articulo->subcategoria->nombre ?? ' - ',
                        'marca' => $articulo->marca->nombre ?? ' - ',
                        'laboratorio' => $articulo->laboratorio_id . ' - ' . $articulo->laboratorio->nombre,
                        'proveedor' => $articulo->proveedor_id . ' - ' . $articulo->proveedor->razon_social,
                        'iva' => $articulo->iva == 1 ? 'Sí' : 'No',
                        'cadenaFrio' => $articulo->cadena_frio ? 'Sí' : 'No',
                        'fechaAlta' => date_format($articulo->fecha_alta, 'd/m/Y'),
                        'trazable' => $articulo->trazable ? 'Sí' : 'No',
                        'paq' => $articulo->paq,
                        'stock' => $articulo->stock,
                        'stockFisico' => $articulo->stock_fisico,
                        'precioActualizacion' => date_format($articulo->precio_actualizacion, 'd/m/Y'),
                    ];
                    ?>
                    <div id="product-image">
                        <?= $this->Html->image('productos/big_' . $reclamosItemsTemp->articulo->imagen, [
                            'alt' => 'no-img',
                            'style' => 'height:200px;width:200px;cursor:pointer;',
                            'id' => 'articulo-' . $articulo->id,
                            'class' => 'open-modal',
                            'onclick' => 'cargarArticulo(' . json_encode($articuloData) . ')',
                        ]) ?>
                    </div>

                </div>
                <div style="margin-left: 15px;">
                    <div class="articulo-detail"><span class="articulo-label">Cantidad:</span> <?= $this->Number->format($reclamosItemsTemp->cantidad) ?></div>
                    <div class="articulo-detail"><span class="articulo-label">EAN:</span> <?php echo $reclamosItemsTemp->articulo->codigo_barras; ?></div>
                    <div class="articulo-detail">
                        <span class="articulo-label">Fecha Venc.:</span>
                        <?= $reclamosItemsTemp->fecha_vencimiento ? $reclamosItemsTemp->fecha_vencimiento->format('d/m/Y') : 'Sin completar'; ?>
                    </div>
                    <div class="articulo-detail">
                        <span class="articulo-label">Lote:</span>
                        <?= $reclamosItemsTemp->lote ? h($reclamosItemsTemp->lote) : 'Sin Completar'; ?>
                    </div>
                    <div class="articulo-detail">
                        <span class="articulo-label">Serie:</span>
                        <?= $reclamosItemsTemp->serie ? h($reclamosItemsTemp->serie) : 'Sin Completar'; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>