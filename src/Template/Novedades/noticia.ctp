<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<?= $this->Html->css('novedades_sliders_notas') ?>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<style>
	:root {
		--primary-color: #f0f8ff;
		--secondary-color: #87cefa;
		--accent-color: #1e90ff;
		--text-color: #333;
	}



	.main-content {
		display: grid;
		grid-template-columns: 2fr 1fr;
		gap: 20px;
		margin-top: 20px;
	}

	.featured-news {
		background-color: white;
		padding: 20px;
		border-radius: 8px;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	}


	.full-width-divider {
		width: 100vw;
		margin-left: calc(-50vw + 50%);
		height: 300px;
		object-fit: cover;
		margin-top: 2rem;
		margin-bottom: 2rem;
	}

	.article-image {
		width: 100%;
		object-fit: cover;
		border-radius: 8px;
		margin-bottom: 20px;
	}

	.noticia_subtitulo {
		margin-top: 15px;
		margin-bottom: 15px;
		font-weight: bold;
		font-size: 15px;
		color: #2a80b9;
	}

	@media (max-width: 900px) {
		.main-content {
			grid-template-columns: 1fr;
		}
	}

	/* === Estilo de Notas Relacionadas ===*/
	.related-news {
		margin-top: 2rem;
		padding: 1rem;
		background-color: #f8f9fa;
		border-radius: 8px;
	}

	.related-news h2 {
		color: var(--accent-color);
		margin-bottom: 1rem;
	}

	.related-news-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
		gap: 1rem;
	}

	.related-news-item {
		background-color: white;
		border-radius: 8px;
		overflow: hidden;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		transition: transform 0.3s ease;
	}

	.related-news-item:hover {
		transform: translateY(-5px);
	}

	.related-news-content {
		padding: 1rem;
	}

	.related-news-title {
		font-size: 1rem;
		font-weight: bold;
		margin-bottom: 0.5rem;
		color: var(--text-color);
	}

	.related-news-excerpt {
		font-size: 0.9rem;
		color: #6c757d;
		display: -webkit-box;
		-webkit-line-clamp: 3;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}
</style>

<div class="container">
	<?php echo $this->element('novedades_filter'); ?>
	<main class="main-content">
		<section class="featured-news">

			<div class="containera">
				<main class="main-article">
					<h1><?= $novedade->titulo ?></h1>
					<p class="article-meta">
						<?php
						$diassemana = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
						$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
						echo date_format($novedade['fecha'], 'd') . " de " . $meses[date_format($novedade['fecha'], 'm') - 1] . " del " . date_format($novedade['fecha'], 'Y');
						?>
					</p>

					<div class=noticia_subtitulo>
						<?php echo '<div style="text-align: justify;" >' . $novedade->descripcion . '</div>'; ?>
					</div>

					<?php
					$nameimagen = "";
					if ($novedade['archivopdf'] == 1) {
						if (substr($novedade->img_file, -4) === '.pdf') {
							echo '<iframe src="https://docs.google.com/gview?url=https://drogueriasur.com.ar/dsx/webroot/img/novedades/' . $novedade->img_file . '&embedded=true" style="width:95%; min-height:1000px;" frameborder="0"></iframe>';
						} elseif (substr($novedade->img_file2, -4) === '.pdf') {
							echo '<iframe src="https://docs.google.com/gview?url=https://drogueriasur.com.ar/dsx/webroot/img/novedades/' . $novedade->img_file2 . '&embedded=true" style="width:95%; min-height:1000px;" frameborder="0"></iframe>';
						}
					} else if ($novedade->img_file != "") {
						$nameimagen = "novedades/" . $novedade->img_file;
						echo $this->Html->image($nameimagen, ["alt" => "Novedades", 'class' => 'article-image']);
					}



					?>


					<?php echo '<div style="text-align: justify;color: #2a80b9;">' . $novedade->descripcion_completa . '</div>'; ?>
				</main>
			</div>

		</section>

		<?php echo $this->element('novedades_aside_sidebar'); ?>


	</main>

	<?php echo $this->element('novedades_img_divisor'); ?>

	<script>
		function esDispositivoMovil() {
			return /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
		}

		const imagenResponsive = document.getElementById('responsive-image');

		if (esDispositivoMovil()) {
			imagenResponsive.src = '<?php echo $this->Html->Url->image('novedades_content/Header-Noticias-2.jpg') ?>';
		} else {
			imagenResponsive.src = '<?php echo $this->Html->Url->image('novedades_content/Header-Noticias-1.jpg') ?>';

		}
	</script>


	<?php if (count($relacionadas) > 0): ?>
		<?php echo $this->element('novedades_sliders_notas', ['id' => $novedade->categorias_novedades_id, 'titulo' => 'Notas Relacionadas', 'items' => $relacionadas]); ?>
	<?php endif; ?>
</div>



<script>
	const newsList = document.getElementById('news-list');

	function formatDate(fechaISO) {
		const fecha = new Date(fechaISO);
		const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
		const dia = fecha.getDate();
		const mes = meses[fecha.getMonth()];
		const anio = fecha.getFullYear();
		return `${dia} de ${mes} del ${anio}`;
	}

	function updateNewsList(news) {
		newsList.innerHTML = news.map(item => {
			const noticiaUrl = '<?php echo $this->Url->build(['controller' => 'Novedades', 'action' => 'noticia', '']); ?>' + '/' + item.id;
			const fechaFormateada = formatDate(item.fecha);

			return `
            <a href="${noticiaUrl}"><li>
				<img src="https://drogueriasur.com.ar/ds/img/novedades/${item.img_file}" alt="Imagen alternativa" onerror="this.onerror=null; this.src='https://drogueriasur.com.ar/dsx/img/pdf-imagen.png';"  width="100%" loading="lazy">
				<div>
                    <h3 class="tituloaside">${item.titulo}</h3>
					<p class="tituloaside" style="color:gray;">${fechaFormateada}</p>
                </div>
            </li>
            </a>
            <hr>
            `;
		}).join('');
	}
</script>


<script>
	const leidoBtn = document.getElementById('leidoBtn');
	const nuevoBtn = document.getElementById('nuevoBtn');

	function toggleNews(isNuevo) {
		if (isNuevo) {
			nuevoBtn.classList.add('active');
			leidoBtn.classList.remove('active');
			fetchMasNuevo();
		} else {
			leidoBtn.classList.add('active');
			nuevoBtn.classList.remove('active');
			fetchMasLeido();
		}
	}

	leidoBtn.addEventListener('click', () => toggleNews(false));
	nuevoBtn.addEventListener('click', () => toggleNews(true));
</script>

<script>
	function fetchMasLeido() {
		$.ajax({
			type: "GET",
			url: '<?php echo \Cake\Routing\Router::url(['controller' => 'Novedades', 'action' => 'notasmasleidas']); ?>',
			dataType: "json",
			success: function(data) {
				updateNewsList(data);
			},
			error: function(xhr, status, error) {
				console.error('Error en la solicitud AJAX:', status, error);
			},
		});
	}

	function fetchMasNuevo() {
		$.ajax({
			type: "GET",
			url: '<?php echo \Cake\Routing\Router::url(['controller' => 'Novedades', 'action' => 'notasmasnuevas']); ?>',
			dataType: "json",
			success: function(data) {
				updateNewsList(data);
			},
			error: function(xhr, status, error) {
				console.error('Error en la solicitud AJAX:', status, error);
			},
		});
	}
</script>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		toggleNews(false);
		initializeAllSwipers();
	});
</script>