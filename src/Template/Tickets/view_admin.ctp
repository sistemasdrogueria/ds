<?= $this->Html->css('tickets/tickets_viewAdmin') ?>
<?php
$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
	$previous = $_SERVER['HTTP_REFERER'];
}
?>
<div class="clear"></div>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved"><?= $titulo ?></h3>
		<div class=header_icon>
			<div class="header_icon_mail">
				<?= $this->Html->image("admin/icon-sendmail.png", ["alt" => "Ver", 'url' => ['controller' => 'Tickets', 'action' => 'ticket_mail', $reclamo['id']]]); ?>
			</div>
			<div class="header_icon_print">
				<?= $this->Html->image("admin/icon-print2.png", ["alt" => "Ver", 'class' => 'btnPrint']); ?>
			</div>
			<div class="header_icon_return">
				<?php echo $this->Html->image('admin/icn_volver.png', ['url' => $previous]); ?> </div>
		</div>
	</header>


	<div id="dvContainer-print">
		<div class="module_content" id="printable">
			<table class="viewlabel">
				<tr>
					<td class="columna_reclamo_nombre">
						<h4><?= __('Nro') ?></h4>
					</td>
					<td>
						<h4><?= $this->Number->format($reclamo->id) ?></h4>
					</td>
				</tr>
				<tr>
					<td>
						<h4><?= __('Fecha y Hora') ?></h4>
					</td>
					<td>
						<h4>
							<?php echo date_format($reclamo->creado, 'd-m-Y H:i:s'); ?>
						</h4>
					</td>

				</tr>
				<tr>
					<td>
						<h4><?= __('Cliente') ?></h4>
					</td>
					<td>
						<h4>
							<?= $reclamo->has('cliente') ? h($reclamo->cliente->codigo) : '' ?> -
							<?= $reclamo->has('cliente') ? h($reclamo->cliente->nombre) : '' ?>

						</h4>
					</td>
				</tr>
				<tr>
					<td>
						<h4><?= __('Motivo') ?></h4>
					</td>
					<td>
						<h4><?= $reclamo->has('reclamos_tipo') ? h($reclamo->reclamos_tipo->nombre) : '' ?></h4>
					</td>
				</tr>
				<tr>
					<td>
						<h4><?= __('Email') ?></h4>
					</td>

					<td>
						<h4><?= $reclamo->has('cliente') ? h($reclamo->cliente->email) : '' ?></h4>
					</td>
				</tr>

				<tr>
					<td>
						<h4><?= __('Factura Nro') ?></h4>
					</td>
					<td>
						<h4><?php echo str_pad($reclamo['factura_seccion'], 4, '0', STR_PAD_LEFT) . '-' . str_pad($reclamo['factura_numero'], 8, '0', STR_PAD_LEFT); ?>
						</h4>
					</td>
				</tr>
				<tr>
					<td>
						<h4><?= __('Pedido Nro') ?></h4>
					</td>
					<td>
						<h4><?php echo $reclamo['pedido_numero']; ?>
						</h4>
					</td>
				</tr>
				<tr>
					<td>
						<h4><?= __('Factura Fecha') ?></h4>
					</td>
					<td>
						<h4>
							<?php echo date_format($reclamo->fecha_recepcion, 'd-m-Y'); ?>
						</h4>
					</td>

				</tr>

				<td>
					<h4><?= __('Estado') ?></h4>
				</td>
				<td>
					<h4><?= $reclamo->has('reclamos_estado') ? h($reclamo->reclamos_estado->nombre) : '' ?></h4>
				</td>
				</tr>
				<tr>
					<td>
						<h4><?= __('Observaciones') ?></h4>
					</td>
					<td>
						<h4><?= h($reclamo->observaciones) ?></h4>
					</td>
				</tr>
			</table>




			<div class="articulos index large-10 medium-9 columns">
				<table class='tablesorter' cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th>Cant.</th>
							<th>Descripción</th>
							<th>EAN</th>
							<th>Fecha Venc.</th>
							<th>Lote</th>
							<th>Serie</th>

						</tr>
					</thead>
					<tbody>
						<?php $lab = $laboratorios; ?>

					<tbody>
						<?php foreach ($reclamositemstemps as $reclamosItemsTemp): ?>
							<tr>
								<td class='form_reclamo_cant_td'><?= $this->Number->format($reclamosItemsTemp['cantidad']) ?></td>
								<td><?= h($reclamosItemsTemp['detalle']) ?></td>
								<td>
									<?php echo $reclamosItemsTemp->articulo->codigo_barras; ?>
								</td>
								<td class="form_reclamo_fv_td">
									<?php
									if ($reclamosItemsTemp['fecha_vencimiento'] != null)
										echo date_format($reclamosItemsTemp['fecha_vencimiento'], 'd-m-Y');
									?>
								</td>
								<td class="form_reclamo_lote_td"><?= h($reclamosItemsTemp['lote']) ?></td>
								<td class="form_reclamo_serie_td"><?= h($reclamosItemsTemp['serie']) ?></td>

							</tr>

						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<div id="dvContainer">
		<div class="main-container">
			<div class="container-data">
				<h2 class="title" id="titulo">Detalles del Reclamo</h2>
				<hr class="linea-divisor">
				<?php echo $this->element('ticket_info_reclamo_admin'); ?>
			</div>

			<div class="container-products">
				<h2 class="title">Artículos de Reclamo</h2>
				<hr class="linea-divisor">
				<?php echo $this->element('ticket_info_productos_admin', ['reclamositemstemps' => $reclamositemstemps]); ?>
			</div>
		</div>
	</div>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="container-messages">
			<h2 class="title">Mensajes</h2>
			<hr class="linea-divisor">
			<?php echo $this->element('ticket_sistema_mensajes', ['reclamo' => $reclamo]); ?>

			<?php echo $this->element('ticket_formulario_enviar_mensaje', ['action' => 'enviarMensajesAdmin', 'tipoid' => 'responseText']); ?>
		</div>
	</div>

	<div id="imageModal" style="display:none;">
		<span id="closeModal" style="position:absolute;top:10px;right:10px;cursor:pointer;">&times;</span>
		<div>
			<img id="modalImage" src="" alt="" style="height:auto;">
		</div>
	</div>

	<div id="articuloModal" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<h2 style="text-align: center;color: #2d68ab;margin-block-start: 10px;margin-block-end: 10px;">Detalle del Artículo</h2>
			<hr class="linea-divisor">
			<div class="modal-informacion">
				<div>
					<img class="imagen-modal" src="" class='imagen-modal' alt="no-img">
				</div>
				<div>
					<p id="descripcion-sist"><strong>Descripción Sist:</strong> <span></span></p>
					<p id="descripcion-pag"><strong>Descripción Pag:</strong> <span></span></p>
					<p id="clave-amp"><strong>Clave AMP:</strong> <span></span></p>
					<p id="troquel"><strong>Troquel:</strong> <span></span></p>
					<p id="codigo-barras"><strong>Código Barras:</strong> <span></span></p>
					<p id="categoria"><strong>Categoría:</strong> <span></span></p>
					<p id="subcategoria"><strong>Subcategoría:</strong> <span></span></p>
					<p id="marca"><strong>Marca:</strong> <span></span></p>
					<p id="laboratorio"><strong>Laboratorio:</strong> <span></span></p>
					<p id="proveedor"><strong>Proveedor:</strong> <span></span></p>
					<p id="iva"><strong>IVA:</strong> <span></span></p>
					<p id="cadena-frio"><strong>Cadena de Frío:</strong> <span></span></p>
					<p id="fecha-alta"><strong>Fecha Alta:</strong> <span></span></p>
					<p id="trazable"><strong>Trazable:</strong> <span></span></p>
					<p id="paq"><strong>PAQ:</strong> <span></span></p>
					<p id="stock"><strong>Stock:</strong> <span></span></p>
					<p id="stock-fisico"><strong>Stock Físico:</strong> <span></span></p>
					<p id="precio-actualizacion"><strong>Actualización de Precio:</strong> <span></span></p>
				</div>
			</div>
		</div>
	</div>

	<?php echo $this->Html->script('ckeditor/ckeditor'); ?>

	<!-- Script para mostrar Informacion Producto -->
	<script>
		function cargarArticulo(data) {
			const modal = document.querySelector('#articuloModal');
			if (!modal) {
				console.error('Modal no encontrado');
				return;
			}

			const imagenModal = modal.querySelector('.imagen-modal');
			if (imagenModal) {
				imagenModal.src = data.imagen;
			}

			const fields = ['descripcionSist', 'descripcionPag', 'claveAmp', 'troquel', 'codigoBarras', 'categoria', 'subcategoria', 'marca', 'laboratorio', 'proveedor', 'iva', 'cadenaFrio', 'fechaAlta', 'trazable', 'paq', 'stock', 'stockFisico', 'precioActualizacion'];

			fields.forEach(field => {
				const fieldElement = modal.querySelector(`#${field.replace(/([A-Z])/g, '-$1').toLowerCase()} span`);
				if (fieldElement) {
					fieldElement.textContent = data[field] || 'No disponible';
				}
			});

			modal.style.display = 'flex';
			setTimeout(() => {
				modal.classList.add('show');
			}, 10);

			document.addEventListener('scroll', cerrarModalAlEvento);
			document.addEventListener('keydown', cerrarModalConEscape);
		}

		document.addEventListener('DOMContentLoaded', function() {
			const modal = document.querySelector('#articuloModal');

			const closeButton = modal.querySelector('.close');
			if (closeButton) {
				closeButton.addEventListener('click', function() {
					cerrarModal();
				});
			}

			modal.addEventListener('click', function(event) {
				if (event.target === modal) {
					cerrarModal();
				}
			});
		});

		function cerrarModal() {
			const modal = document.querySelector('#articuloModal');
			if (modal) {
				modal.classList.remove('show');

				modal.style.display = 'none';
			}

			document.removeEventListener('scroll', cerrarModalAlEvento);
			document.removeEventListener('keydown', cerrarModalConEscape);
		}

		function cerrarModalAlEvento() {
			cerrarModal();
		}

		function cerrarModalConEscape(event) {
			if (event.key === 'Escape') {
				cerrarModal();
			}
		}
	</script>

	<!-- Cargar mas mensajes -->
	<script>
		let mensajesCargados = new Set();

		function cargarMensajes() {
			$.ajax({
				url: '<?= $this->Url->build(['action' => 'getMensajes', $reclamo->id]) ?>',
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

	<!-- Script para controlar el modal Mensaje -->
	<script>
		var modal = document.getElementById('imageModal');
		var modalImage = document.getElementById('modalImage');
		var closeModal = document.getElementById('closeModal');

		function openModal(imageElement) {
			modal.style.display = 'flex';
			modalImage.src = imageElement.src;
		}

		var images = document.querySelectorAll('img[id^="imagenMensaje-"]');
		images.forEach(function(image) {
			image.onclick = function() {
				openModal(this);
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
	</script>
	<?php echo $this->Html->css('print');	?>
	<script>
		$(document).ready(function() {
			//$('ul#tools').prepend('<li class="print"><a href="#print">Click me to print</a></li>');
			$('.btnPrint').click(function() {
				window.print();
				return false;
			});
		});
	</script>
</article>