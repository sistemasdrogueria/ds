<?= $this->Html->css('tickets/tickets_view') ?>
<div class="col-md-4">
    <div class="product-item-3">
        <div class="ticket-container" style="padding: 0px;">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="ticket-container">
                        <header class="ticket-header">
                            <h1>Ticket</h1>
                        </header>
                        <?= $this->element('ticket_info'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-8">
    <div class="product-item-3">
        <div class="ticket-container" style="padding: 0px;">
            <header class="ticket-header">
                <h1>Productos</h1>
            </header>
            <?php
            if ($reclamositemstemps != null) {
                echo $this->element('ticket_search_item_temp_result');
            }
            ?>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="contain-mensajes">
        <div class="ticket-container">
            <header class="ticket-header">
                <h1>Mensajes</h1>
            </header>
            <?php echo $this->element('ticket_sistema_mensajes', ['reclamo' => $reclamo]); ?>
        </div>


        <?php echo $this->element('ticket_formulario_enviar_mensaje', ['action' => 'enviarMensajes', 'tipoid' => 'mensaje-editor']); ?>

        <script src="https://cdn.ckeditor.com/4.22.0/basic/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('mensaje-editor');
        </script>

    </div>
    <div id="imageModal" style="display:none;">
        <span id="closeModal" style="position:absolute;top:10px;right:10px;cursor:pointer;">&times;</span>
        <img id="modalImage" src="" alt="" style="width:100%;height:auto;">
    </div>
</div>



<?php if ($mostrarModal): ?>
    <style>
        /* The Modal (background) */
        .modal-pdf-info {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            -webkit-animation-name: fadeIn;
            -webkit-animation-duration: 0.4s;
            animation-name: fadeIn;
            animation-duration: 0.4s;
        }

        /* Modal Content */
        .modal-content {
            position: fixed;
            font: 15px/21px "Open Sans", Arial, sans-serif;
            bottom: 0;
            background-color: #fefefe;
            width: 100%;
            -webkit-animation-name: slideIn;
            -webkit-animation-duration: 0.4s;
            animation-name: slideIn;
            animation-duration: 0.4s
        }

        /* The Close Button */
        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: row-reverse;
        }

        .modal-body {
            padding: 2px 16px;
        }

        .modal-footer {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
            text-align: center;
        }

        /* Add Animation */
        @-webkit-keyframes slideIn {
            from {
                bottom: -300px;
                opacity: 0
            }

            to {
                bottom: 0;
                opacity: 1
            }
        }

        @keyframes slideIn {
            from {
                bottom: -300px;
                opacity: 0
            }

            to {
                bottom: 0;
                opacity: 1
            }
        }

        @-webkit-keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }
    </style>

    <!-- The Modal -->
    <div id="myModal" class="modal-pdf-info">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>IMPORTANTE</h2>
            </div>
            <div class="modal-body">
                <p>Estimado cliente: <br>
                    <?= $reclamo->tipo == 1 ? 'Recuerde adjuntar comprobante Obligatorio de Reclamo y enviarlo por mail a reclamos@drogueriasur.com.ar' : 'Recuerde imprimir el comprobante Obligatorio de Devolución y enviarlo con la mercaderia'; ?>
                    <br>
                    <?php echo 'El comprobante es requisito excluyente para dar curso a la operación.' ?>
                    <br>
                    <?php
                    if ($reclamo['tipo'] == 0)
                        echo 'La mercadería a devolver debe coincidir con la informada en el comprobante obligatorio de devolución. Caso contrario, la devolución se anula. '; ?>
                    <br>
                    <br>
                    <?php echo 'Gracias.' ?><br>
                    <br>
                </p>
            </div>
            <div class="modal-footer">
                <h4 style="color:white;">
                    <?= $reclamo->tipo == 1 ? 'Descargar comprobante Obligatorio de Reclamo' : 'Descargar comprobante Obligatorio de Devolución';

                    echo $this->Html->image("pdf.png", [
                        "alt" => "pdf",
                        "style" => "margin-left:10px",
                        'url' => ['controller' => 'Tickets', 'action' => 'ticketpdf',  $reclamo['id'], '_ext' => 'pdf', '_full' => true]
                    ]); ?>
                </h4>
            </div>
        </div>
    </div>

    <!-- Script mostrar y ocultar modal para Ticket -->
    <script>
        var modal = document.getElementById('myModal');
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];
        modal.style.display = "block";

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
<?php endif; ?>

<!-- Script dar evento a imagenes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('imageModal');
        var modalImage = document.getElementById('modalImage');
        var closeModal = document.getElementById('closeModal');
        var messagesContainer = document.querySelector('.messages');

        function openModal(imageElement) {
            modal.style.display = 'flex';
            modalImage.src = imageElement.src;
        }

        messagesContainer.addEventListener('click', function(event) {
            if (event.target && event.target.tagName === 'IMG' && event.target.id.startsWith('imagenMensaje-')) {
                openModal(event.target);
            }
        });

        closeModal.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    });
</script>

<!-- Script CargarMensajes -->
<script>
    let mensajesCargados = new Set();

    function cargarMensajes() {
        $.ajax({
            url: '<?= $this->Url->build(['action' => 'getMensajesUser', $reclamo->id]) ?>',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let messagesContainer = $('.messages');
                let nuevosMensajes = '';

                data.mensajes.forEach(function(mensaje) {
                    if (!mensajesCargados.has(parseInt(mensaje.id))) {
                        mensajesCargados.add(parseInt(mensaje.id));

                        let creado = new Date(mensaje.creado).toLocaleString();
                        let clase = mensaje.tipo === 'system' ? 'system-message' :
                            (mensaje.cliente_id == 34525 ? 'admin' : 'user-ticket');

                        nuevosMensajes += `<div id="mensaje-${mensaje.id}" class="message-box ${clase}">`;

                        if (mensaje.tipo === 'system') {
                            nuevosMensajes += `<p style="color:rgb(255, 255, 255); font-weight: bold;">${mensaje.mensaje}</p>`;
                        } else {
                            nuevosMensajes += `
                            <h2>${mensaje.cliente.razon_social}</h2>
                            <p>${mensaje.mensaje}</p>`;

                            if (mensaje.imagen) {
                                nuevosMensajes += `<img src="<?= $this->Url->build('/reclamos/') ?>${mensaje.reclamo.id}/imagen/${mensaje.imagen}" alt="${mensaje.imagen}" style="max-width: 400px;max-height: 200px;cursor:pointer;" id="imagenMensaje-${mensaje.id}" />`;

                            }
                        }

                        if (mensaje.tipo !== 'system') {
                            nuevosMensajes += `<p style="text-align: right;color: #b3b3b3;">${creado}</p>`;
                        }
                        nuevosMensajes += '</div>';
                    }
                });

                if (nuevosMensajes) {
                    messagesContainer.append(nuevosMensajes);
                }
            },
            error: function() {
                console.error('Error al cargar mensajes');
            }
        });
    }


    setInterval(cargarMensajes, 5000);

    $(document).ready(function() {
        $('.messages .message-box').each(function() {
            let mensajeId = $(this).attr('id')?.replace('mensaje-', '');
            if (mensajeId) {
                mensajesCargados.add(parseInt(mensajeId));
            }
        });

        cargarMensajes();
    });
</script>