<style>
    .text-center {
        text-align: center;
    }
</style>
<div>
    <h2 class="text-center">Resultado Pedidos FP</h2>
    <div>
        <table class="tablesorter">
            <thead>
                <tr>
                    <th class="centrado"><?= $this->Paginator->sort('PedidoFP') ?></th>
                    <th class="centrado"><?= $this->Paginator->sort('Fecha Recepcion') ?></th>
                    <th class="centrado"><?= $this->Paginator->sort('Código') ?></th>
                    <th class="centrado"><?= $this->Paginator->sort('Razón Social') ?></th>
                    <th class="centrado"><?= $this->Paginator->sort('tipo fact') ?></th>


                    <th class="centrado"><?= $this->Paginator->sort('pedido_ds_id', ' Pedido Web') ?></th>
                    <th class="centrado"><?= $this->Paginator->sort('comentario', 'Comentario') ?></th>
                    <th class="centrado"><?= $this->Paginator->sort('Envio') ?></th>

                </tr>
            </thead>
            <tbody id="pedidos-tbody">
                <?php
                if (isset($pedidosFp['pedidosfp'])) {
                    foreach ($pedidosFp['pedidosfp'] as $pedido): ?>
                        <tr>
                            <td class="text-center"><?= $pedido['order_id_fp']; ?></td>
                            <td class="text-center"><?= $pedido['creado']; ?></td>
                            <td class="text-center"><?= $pedido['pedidos_ds']['clientes']['codigo'] ?></td>
                            <td class="text-center"><?= $pedido['pedidos_ds']['clientes']['nombre']; ?></td>
                            <td class="text-center"><?= $pedido['tipo_fact']; ?></td>


                            <td class="text-center">
                                <a href="javascript:void(0)" onclick="toggleAccordion(<?= $pedido['pedido_ds_id']; ?>)">
                                    <?= $pedido['pedido_ds_id']; ?>
                                </a>
                            </td>
                            <td class="text-center"><?= $pedido['comentario']; ?></td>
                            <td class="text-center">
                                <?php
                                if ($pedido['forma_envio'] == 98) {
                                    echo "Retira Cadete";
                                } elseif ($pedido['forma_envio'] == 0) {
                                    echo "Envia Drogueria";
                                } elseif ($pedido['forma_envio'] == 97) {
                                    echo "Envia Drogueria";
                                }
                                ?>
                            </td>

                        </tr>

                        <!-- Detalle de pedidosDs, inicialmente oculto -->
                        <tr id="accordion-<?= $pedido['pedido_ds_id']; ?>" class="accordion-content" style="display:none;height:auto">
                            <td colspan="3" style="border:1px solid;">
                                <strong>Detalles del PedidoDs:</strong><br>
                                <p> <strong>Cliente ID:</strong> <?= $pedido['pedidos_ds']['cliente_id'] ?? 'N/A'; ?><br></p>
                                <p> <strong>Sucursal ID:</strong> <?= $pedido['pedidos_ds']['sucursal_id'] == 98 ? 'Retira Cadete' : 'Logistica Drogueria'; ?><br></p>
                                <p><strong>Forma de Envío:</strong> <?= $pedido['pedidos_ds']['forma_envio'] == 98 ? 'Retira Cadete' : 'Logistica Drogueria'; ?><br></p>
                                <p><strong>Tipo Fact: </strong><?= $pedido['pedidos_ds']['tipo_fact'] ?? 'N/A'; ?><br></p>
                                <p><strong>Estado ID:</strong> <?= $pedido['pedidos_ds']['estado_id'] ?? 'N/A'; ?><br></p>
                                <p><strong>Comentario:</strong> <?= $pedido['pedidos_ds']['comentario'] ?? 'N/A'; ?><br></p>
                                <p><strong>Nro Pedido DS:</strong> <?= $pedido['pedidos_ds']['nro_pedido_ds'] ?? 'N/A'; ?><br></p>
                                <p> <strong>Cantidad Item:</strong> <?= $pedido['pedidos_ds']['cantidad_item'] ?? 'N/A'; ?><br></p>
                                <?php $mensaje = 'Nada';
                                switch ($pedido['pedidos_ds']['pedidos_status_id']) {
                                    case 1:
                                        $mensaje = 'No Habilitada';
                                        break;
                                        // case 2: $mensaje = 'Cta. Export';break;
                                    case 3:
                                        $mensaje = 'Posible Duplicado';
                                        break;
                                    case 4:
                                        $mensaje = 'Cod. Cliente Incorrecto';
                                        break;
                                    case 5:
                                        $mensaje = 'Limite Compra';
                                        break;
                                    case 8:
                                        $mensaje = 'Anulado';
                                        break;
                                    case 9:
                                        $mensaje = 'Pos. Duplicado';
                                        break;
                                    case 10:
                                        $mensaje = 'Sin NC PAMI';
                                        break;
                                } ?>
                                <p><strong> Pedidos estatus id : </strong> <?= $mensaje ?><br> </p>
                            </td>
                            <td colspan="3" style="border:1px solid;">
                                <strong>Detalles del cliente:</strong><br>
                                <p> <strong>Codigó:<strong> <?= $pedido['pedidos_ds']['clientes']['codigo'] ?? 'N/A'; ?><br></p>
                                <p> <strong>Nombre:<strong> <?= $pedido['pedidos_ds']['clientes']['nombre'] ?? 'N/A'; ?><br></p>
                                <p> <strong>Domicilio:<strong> <?= $pedido['pedidos_ds']['clientes']['domicilio'] ?? 'N/A'; ?><br></p>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>

                                <br>

                            </td>
                            <td colspan="3" style="border:1px solid;">
                                <strong>Detalles del articulos:</strong><br>
                                <?php foreach ($pedido['pedidos_ds']['pedidos_items'] as $items) {
                                    echo "<p>";
                                    echo "<strong>Cantidad items:";
                                    echo $items["cantidad"];
                                    echo "</strong><br>";
                                    echo "<strong>";
                                    echo "Troquel:";
                                    echo   $items['articulos']['troquel'];
                                    echo "</strong>";
                                    echo "<strong><br>";
                                    echo "Descripción:";
                                    echo "<strong>";
                                    echo $items['articulos']['descripcion_pag'];
                                    echo "</strong>";
                                    echo "<br>";
                                    echo "Codigó barras";
                                    echo "<strong>";
                                    echo  $items['articulos']['codigo_barras'];
                                    echo "</strong>";
                                    echo "</p>";
                                } ?>

                                <br>
                                <br>




                            </td>
                        </tr>
                <?php endforeach;
                } ?>
            </tbody>
        </table>
    </div>

    <script>
        function toggleAccordion(pedidoDsId) {
            var content = document.getElementById('accordion-' + pedidoDsId);
            if (content.style.display === "none") {
                content.style.display = "table-row";
            } else {
                content.style.display = "none";
            }
        }
    </script>