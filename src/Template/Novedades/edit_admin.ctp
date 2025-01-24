<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
	$previous = $_SERVER['HTTP_REFERER'];
}
?>
<?php echo $this->Html->css('novedades/novedades_editAdmin'); ?>
<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<div class="clear"></div>
<article class="module">
	<header>
		<h3 class="tabs_involved" id="titulobarra"><?= $titulo ?></h3>
		<div class="volveratras">
			<a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png'); ?></a>
		</div>
	</header>
	<?= $this->Form->create($novedade, ['url' => ['controller' => 'Novedades', 'action' => 'edit_admin'], 'type' => 'file']) ?>
	<div class="module_content">

		<fieldset>
			<?php echo $this->Form->input('titulo'); ?>
		</fieldset>
		<fieldset class=descripcionck>
			<?php echo $this->Form->input('descripcion', ['label' => 'Descripción', 'class' => 'ckeditor', 'id' => 'descripcion']); ?>
		</fieldset>
		<fieldset class=descripcionck>
			<?php echo $this->Form->input('descripcion_completa', ['label' => 'Descripción Completa', 'class' => 'ckeditor', 'id' => 'descripcion_completa']); ?>
		</fieldset>
		<fieldset>
			<?php echo $this->Form->input('tipo'); ?>
		</fieldset>
		<fieldset>
			<div class="input select">
				<label class="">Categoria</label>
				<div class="">
					<?php
					echo $this->Form->select('categorias_novedades_id', $categorias, [
						'class' => 'select2_single form-control',
						'empty' => 'Selecciona una categoría'
					]);
					?>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<?= $this->Form->input('fecha', ['label' => 'fecha:', 'id' => 'fechadesde', 'name' => 'fecha', 'type' => 'text', 'placeholder' => 'Fecha', 'value' => date_format($novedade['fecha'], 'd/m/Y')]); ?>
		</fieldset>
		<fieldset>
			<div class="maincontenedorImagenes">
				<div class="contenedorImagen">
					<p style="font-weight: bold;">Imagen de Portada</p>
					<div id="coverDropzone" class="dropzone">
						<div class="dropzone-content">
							<p>Arrastra y suelta la portada aquí</p>
							<p>o</p>
							<p><label for="coverInput">Selecciona un archivo</label></p>
						</div>
						<input type="file" id="coverInput" accept="application/pdf,image/*" style="display: none;z-index:1000">
						<input type="file" id="realcoverInput" name="file" accept="application/pdf,image/*" style="display: none;z-index:1000">
					</div>
				</div>
				<div class="contenedorImagen">
					<p style="font-weight: bold;">Imagen Grande</p>
					<div id="largeImageDropzone" class="dropzone">
						<div class="dropzone-content">
							<p>Arrastra y suelta la imagen grande aquí</p>
							<p>o</p>
							<p><label for="largeImageInput">Selecciona un archivo</label></p>
						</div>
						<input type="file" id="largeImageInput" accept="application/pdf,image/*" style="display: none;z-index:1000">
						<input type="file" id="realimg" name="file2" accept="application/pdf,image/*" style="display: none;z-index:1000">
					</div>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="input select">
				<label for="activo">Noticia Activa</label>
				<label class="neon-checkbox">
					<?php echo $this->Form->checkbox('activo'); ?>
					<div class="neon-checkbox__frame">
						<div class="neon-checkbox__box">
							<div class="neon-checkbox__check-container">
								<svg viewBox="0 0 24 24" class="neon-checkbox__check">
									<path d="M3,12.5l7,7L21,5"></path>
								</svg>
							</div>
							<div class="neon-checkbox__glow"></div>
							<div class="neon-checkbox__borders">
								<span></span><span></span><span></span><span></span>
							</div>
						</div>
						<div class="neon-checkbox__effects">
							<div class="neon-checkbox__particles">
								<span></span><span></span><span></span><span></span> <span></span><span></span><span></span><span></span> <span></span><span></span><span></span><span></span>
							</div>
							<div class="neon-checkbox__rings">
								<div class="ring"></div>
								<div class="ring"></div>
								<div class="ring"></div>
							</div>
							<div class="neon-checkbox__sparks">
								<span></span><span></span><span></span><span></span>
							</div>
						</div>
					</div>
				</label>
			</div>
		</fieldset>
		<fieldset>
			<div class="input select">
				<label for="activo">Noticia Pagina Interna</label>
				<label class="neon-checkbox">
					<?php echo $this->Form->checkbox('interno'); ?>
					<div class="neon-checkbox__frame">
						<div class="neon-checkbox__box">
							<div class="neon-checkbox__check-container">
								<svg viewBox="0 0 24 24" class="neon-checkbox__check">
									<path d="M3,12.5l7,7L21,5"></path>
								</svg>
							</div>
							<div class="neon-checkbox__glow"></div>
							<div class="neon-checkbox__borders">
								<span></span><span></span><span></span><span></span>
							</div>
						</div>
						<div class="neon-checkbox__effects">
							<div class="neon-checkbox__particles">
								<span></span><span></span><span></span><span></span> <span></span><span></span><span></span><span></span> <span></span><span></span><span></span><span></span>
							</div>
							<div class="neon-checkbox__rings">
								<div class="ring"></div>
								<div class="ring"></div>
								<div class="ring"></div>
							</div>
							<div class="neon-checkbox__sparks">
								<span></span><span></span><span></span><span></span>
							</div>
						</div>
					</div>
				</label>
			</div>
		</fieldset>
		<fieldset>
			<div class="input select">
				<?php echo $this->Form->input('importante', [
					'label' => 'Noticia Importante:',
					'class' => 'inputImportante',
					'type' => 'number',
					'min' => '0',
					'max' => '2',
					'oninput' => "this.value = Math.max(0, Math.min(2, this.value));"
				]); ?>
				0 por defecto, 1 Importante, 2 muy importante(sección Resumen)
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<footer>
		<div class="submit_link">
			<?= $this->Form->button(__('Guardar'), ['class' => 'confirmarButton']) ?>
			<?= $this->Form->end() ?>
		</div>
		<div class="submit_link">
			<a href="<?= $previous ?>">Volver</a>
		</div>
	</footer>
</article><!-- end of post new article -->
<script>
	function setupDropzone(dropzoneId, inputId, realImgId, originalImgUrl) {
		const dropzone = document.getElementById(dropzoneId);
		const fileInput = document.getElementById(inputId);
		const realImgInput = document.getElementById(realImgId);
		let currentFile = null;

		// Mostrar imagen original si existe
		if (originalImgUrl) {
			restoreOriginalImage(dropzone, originalImgUrl);
		}

		// Manejo de eventos de arrastre y soltado
		['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
			dropzone.addEventListener(eventName, preventDefaults, false);
		});

		['dragenter', 'dragover'].forEach(eventName => {
			dropzone.addEventListener(eventName, () => highlight(dropzone), false);
		});

		['dragleave', 'drop'].forEach(eventName => {
			dropzone.addEventListener(eventName, () => unhighlight(dropzone), false);
		});

		dropzone.addEventListener('drop', (e) => handleDrop(e, dropzone, fileInput), false);
		fileInput.addEventListener('change', (e) => handleFiles(e, dropzone, realImgInput), false);

		dropzone.addEventListener('click', (e) => {
			if (!e.target.classList.contains('removeButton')) {
				fileInput.click();
			}
		});

		function preventDefaults(e) {
			e.preventDefault();
			e.stopPropagation();
		}

		function highlight(element) {
			element.classList.add('dragover');
		}

		function unhighlight(element) {
			element.classList.remove('dragover');
		}

		function handleDrop(e, dropzone, fileInput) {
			const dt = e.dataTransfer;
			const files = dt.files;
			handleFiles({
				target: {
					files
				}
			}, dropzone, realImgInput);
		}

		function handleFiles(e, dropzone, realImgInput) {
			const file = e.target.files[0];
			if (file) {
				currentFile = file;

				// Actualiza el input real programáticamente
				const dataTransfer = new DataTransfer();
				dataTransfer.items.add(file);
				realImgInput.files = dataTransfer.files;

				previewFile(file, dropzone);
			}
		}

		function previewFile(file, dropzone) {
			const reader = new FileReader();
			reader.readAsDataURL(file);

			reader.onloadend = function() {
				const img = document.createElement('img');

				// Verificar si el archivo es un PDF
				if (reader.result.startsWith('data:application/pdf')) {
					img.src = "<?= $this->Url->build('/img/novedades/imagen_pdf.png', ['fullBase' => true]) ?>";
				} else {
					img.src = reader.result; // Mostrar la imagen cargada
				}

				img.alt = "Vista previa de la imagen";

				// Eliminar la imagen anterior si existe
				const oldImg = dropzone.querySelector('img');
				if (oldImg) {
					dropzone.removeChild(oldImg);
				}

				dropzone.appendChild(img);

				// Actualizar el contenido del dropzone
				const content = dropzone.querySelector('.dropzone-content');
				content.innerHTML = `
    							    <p>Arrastra una nueva imagen para cambiarla</p>
    							    <button type="button" class="removeButton">Eliminar imagen</button>
    							`;

				// Configurar botón para eliminar imagen
				dropzone.querySelector('.removeButton').addEventListener('click', (event) => {
					event.preventDefault();
					removeImage(dropzone, fileInput, realImgInput, originalImgUrl);
				});
			};

		}

		function removeImage(dropzone, fileInput, realImgInput, originalImgUrl) {
			const img = dropzone.querySelector('img');
			if (img) {
				dropzone.removeChild(img);
			}
			currentFile = null;

			// Limpiar ambos inputs
			fileInput.value = '';
			realImgInput.value = '';

			// Restaurar imagen original si existe
			if (originalImgUrl) {
				restoreOriginalImage(dropzone, originalImgUrl);
			} else {
				// Restaurar contenido inicial si no hay imagen original
				const content = dropzone.querySelector('.dropzone-content');
				content.innerHTML = `
            					    <p>Arrastra y suelta una imagen aquí</p>
            					    <p>o</p>
            					    <p><label for="${fileInput.id}">Selecciona un archivo</label></p>
            					`;
			}
		}

		function restoreOriginalImage(dropzone, originalImgUrl) {
			const img = document.createElement('img');
			img.src = originalImgUrl;
			img.alt = "Imagen actual";

			const oldImg = dropzone.querySelector('img');
			if (oldImg) {
				dropzone.removeChild(oldImg);
			}

			dropzone.appendChild(img);

			const content = dropzone.querySelector('.dropzone-content');
			content.innerHTML = `
        				    <p>Arrastra una nueva imagen para cambiarla</p>
        				    <button type="button" class="removeButton">Eliminar imagen</button>
        					`;

			dropzone.querySelector('.removeButton').addEventListener('click', (event) => {
				event.preventDefault();
				removeImage(dropzone, fileInput, realImgInput, originalImgUrl);
			});
		}
	}

	const coverImageUrl = 
    "<?= !empty($novedade->img_file) 
        ? (strtolower(pathinfo($novedade->img_file, PATHINFO_EXTENSION)) === 'pdf' 
            ? $this->Url->build('/img/novedades/imagen_pdf.png', ['fullBase' => true]) 
            : $this->Url->build('/img/novedades/' . $novedade->img_file, ['fullBase' => true])) 
        : $this->Url->build('/img/novedades/sin_imagen_novedades.jpg', ['fullBase' => true]) ?>";

const largeImageUrl = 
    "<?= !empty($novedade->img_file2) 
        ? (strtolower(pathinfo($novedade->img_file2, PATHINFO_EXTENSION)) === 'pdf' 
            ? $this->Url->build('/img/novedades/imagen_pdf.png', ['fullBase' => true]) 
            : $this->Url->build('/img/novedades/' . $novedade->img_file2, ['fullBase' => true])) 
        : $this->Url->build('/img/novedades/sin_imagen_novedades.jpg', ['fullBase' => true]) ?>";


	// Inicializar los dropzones
	setupDropzone('coverDropzone', 'coverInput', 'realcoverInput', coverImageUrl);
	setupDropzone('largeImageDropzone', 'largeImageInput', 'realimg', largeImageUrl);
</script>