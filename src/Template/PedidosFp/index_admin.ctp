<article class="module width_3_quarter">
    <header>
        <h3 class="tabs_involved"><?= $titulo ?></h3>
        <div class="tabs_bt_nuevo">

        </div>
    </header>
    <div class="tab_container">
        <?php echo $this->element('pedidosFp_search_admin'); ?>
        <?php echo $this->element('pedidosFp_result_admin'); ?>
    </div><!-- end of .tab_container -->
</article><!-- end of content manager article -->
<?php echo $this->Html->script('bootstrap'); ?>

<script>
    function search() {
        var fechadesde = $('#fechadesde').val();
        var fechahasta = $('#fechahasta').val();
        var terminobuscarfp = $('#terminobuscarfp').val();
        var terminobuscards = $('#terminobuscards').val();
        var terminobuscarcodigods = $('#terminobuscarcodigods').val();

        if (fechadesde.length > 0 ||
            fechahasta.length > 0 ||
            terminobuscarfp.length > 0 ||
            terminobuscards.length > 0 ||
            terminobuscarcodigods.length > 0) {

            $('#fechadesde').removeClass('border-red');
            $('#fechahasta').removeClass('border-red');
            $('#terminobuscarfp').removeClass('border-red');
            $('#terminobuscards').removeClass('border-red');
            $('#terminobuscarcodigods').removeClass('border-red');
            $.ajax({
                url: searchPedidosFp,
                type: 'POST',
                dataType: 'json',
                data: {
                    fechadesde: fechadesde,
                    fechahasta: fechahasta,
                    terminobuscarfp: terminobuscarfp,
                    terminobuscards: terminobuscards,
                    terminobuscarcodigods: terminobuscarcodigods,
                },
                success: function(response) {

                    // Código que se ejecuta cuando la solicitud es exitosa
                    generarFilasPedidos(response.pedidosFp);
                    // Aquí puedes manipular el DOM o hacer cualquier otra acción con los datos recibidos
                },
                error: function(xhr, status, error) {
                    // Código que se ejecuta cuando hay un error en la solicitud
                    console.error("Error: " + error);
                    console.log("Estado: " + status);
                    console.dir(xhr);
                }
            });
        } else {
            alertify.error("Ingresa un campo de busqueda");
            $('#fechadesde').addClass('border-red');
            $('#fechahasta').addClass('border-red');
            $('#terminobuscarfp').addClass('border-red');
            $('#terminobuscards').addClass('border-red');
            $('#terminobuscarcodigods').addClass('border-red');
        }


    }



    function generarFilasPedidos(pedidosFp) {
        const tbody = document.getElementById('pedidos-tbody');
        tbody.innerHTML = ''; // Limpiar el contenido existente
        pedidosFp.sort((a, b) => b.order_id_fp - a.order_id_fp);

        pedidosFp.forEach(function(pedido) {
            // Crear la fila del pedido
            const trPedido = document.createElement('tr');
            trPedido.innerHTML = `
            <td class="text-center">${pedido.order_id_fp}</td>
			<td class="text-center">${pedido.creado}</td>
			<td class="text-center">${pedido.pedidos_ds?.clientes?.codigo ?? ''}</td>
			<td>${pedido.pedidos_ds?.clientes?.nombre ?? ''}</td>
			<td class="text-center">${pedido.tipo_fact}</td>
			<td class="text-center">
			 	<a href="javascript:void(0)" onclick="toggleAccordion(${pedido.pedido_ds_id})">
                    ${pedido.pedido_ds_id}
                </a>
			<td class="text-center">${pedido.comentario}</td>
			<td class="text-center">
            	${pedido.forma_envio == 98 ? "Retira Cadete" : "Envia Drogueria"}</td>   
            </td>
            
        `;

            // Añadir la fila al tbody
            tbody.appendChild(trPedido);

            // Crear la fila oculta para los detalles del pedido (accordion)
            const trDetalle = document.createElement('tr');
            trDetalle.id = `accordion-${pedido.pedido_ds_id}`;
            trDetalle.classList.add('accordion-content');
            trDetalle.style.display = 'none'; // Ocultar inicialmente

            const itemsDetalles = pedido.pedidos_ds?.pedidos_items?.map(function(item) {
                return `<div class="border-black">
                        <p><strong>Troquel:</strong> ${item.articulos?.troquel ?? 'N/A'}</p>
                        <p><strong>Descripción:</strong> ${item.articulos?.descripcion_pag ?? 'N/A'}</p>
                        <p><strong>Código de Barras:</strong> ${item.articulos?.codigo_barras ?? 'N/A'}</p>
                        <p><strong>Cantidad:</strong> ${item?.cantidad ?? 'N/A'}</p>
                        </div>
                    `;
            }).join('') || 'No hay detalles disponibles';
            trDetalle.innerHTML = `
            <td colspan="2" style="border:1px solid;">
                <strong>Detalles del PedidoDs:</strong><br>
                <p><strong>Cliente ID:</strong> ${pedido.pedidos_ds?.cliente_id ?? 'N/A'}</p>
                <p><strong>Sucursal ID:</strong> ${pedido.pedidos_ds?.sucursal_id == 98 ? 'Retira Cadete' : 'Logistica Drogueria'}</p>
                <p><strong>Forma de Envío:</strong> ${pedido.pedidos_ds?.forma_envio == 98 ? 'Retira Cadete' : 'Logistica Drogueria'}</p>
                <p><strong>Tipo Fact:</strong> ${pedido.pedidos_ds?.tipo_fact ?? 'N/A'}</p>
                <p><strong>Estado ID:</strong> ${pedido.pedidos_ds?.estado_id ?? 'N/A'}</p>
                <p><strong>Comentario:</strong> ${pedido.pedidos_ds?.comentario ?? 'N/A'}</p>
                <p><strong>Nro Pedido DS:</strong> ${pedido.pedidos_ds?.nro_pedido_ds ?? 'N/A'}</p>
                <p><strong>Cantidad Item:</strong> ${pedido.pedidos_ds?.cantidad_item ?? 'N/A'}</p>
                <p><strong>Pedidos estatus id:</strong> ${obtenerMensajeEstatus(pedido.pedidos_ds?.pedidos_status_id)}</p>
            </td>
            <td colspan="2" style="border:1px solid;">
                <strong>Detalles del cliente:</strong><br>
                <p><strong>Codigo:</strong> ${pedido.pedidos_ds?.clientes?.codigo ?? 'N/A'}</p>
                <p><strong>Nombre:</strong> ${pedido.pedidos_ds?.clientes?.nombre ?? 'N/A'}</p>
                <p><strong>Domicilio:</strong> ${pedido.pedidos_ds?.clientes?.domicilio ?? 'N/A'}</p>
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
            <td colspan="2" style="border:1px solid;">
            <strong>Detalles de los Items:</strong><br>
            ${itemsDetalles}
        </td>
        `;

            // Añadir la fila de detalles al tbody
            tbody.appendChild(trDetalle);
        });
    }

    // Función para manejar el estatus del pedido
    function obtenerMensajeEstatus(statusId) {
        switch (statusId) {
            case 0:
                return 'Facturado';
            case 1:
                return 'No Habilitada';
            case 3:
                return 'Posible Duplicado';
            case 4:
                return 'Cod. Cliente Incorrecto';
            case 5:
                return 'Limite Compra';
            case 8:
                return 'Anulado';
            case 9:
                return 'Pos. Duplicado';
            case 10:
                return 'Sin NC PAMI';
            default:
                return 'N/A';
        }
    }

    // Función para alternar la visibilidad del accordion
    function toggleAccordion(id) {
        const element = document.getElementById(`accordion-${id}`);
        if (element.style.display === 'none') {
            element.style.display = 'table-row';
        } else {
            element.style.display = 'none';
        }
    }

    setTimeout(() => {
        location.reload();
    }, 300000);
    
</script>