<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<?= $this->Html->css('novedades_sliders_notas') ?>
<?= $this->Html->css('novedades_comunicado') ?>

<div class="container">
	<?php echo $this->element('novedades_filter'); ?>
	<div class="main-content">
		<section class="featured-news">
			<?php if (!empty($destacadas)): ?>
				<!-- Noticia Principal -->
				<article class="news-item principal">
					<?php
					if ($destacadas[0]->img_file != "") {
						if ($destacadas[0]->img_file != null) {
							$nameimagen = "novedades/" . $destacadas[0]->img_file;
							echo $this->Html->image($nameimagen, [
								"alt" => "Novedades",
								'width' => '100%',
								'loading' => 'lazy',
								'url' => ['controller' => 'novedades', 'action' => 'noticia',  $destacadas[0]->id,]
							]);
						}
					}
					?>
					<div class="news-item-content">
						<h3><?php echo $this->Html->link($destacadas[0]->titulo, ['controller' => 'Novedades', 'action' => 'noticia', $destacadas[0]->id, '_full' => true]); ?></h3>
						<?= $destacadas[0]->descripcion ?>
						<div class="news-date">
							<?php
							$diassemana = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
							$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
							echo date_format($destacadas[0]['fecha'], 'd') . " de " . $meses[date_format($destacadas[0]['fecha'], 'm') - 1] . " del " . date_format($destacadas[0]['fecha'], 'Y');
							?>
						</div>
					</div>
				</article>

				<!-- Noticias Secundarias -->
				<div class="secondary-news">
					<?php foreach (array_slice($destacadas, 1) as $secundaria): ?>
						<article class="news-item secundaria">
							<div class="news-item-inner">
								<?php
								if ($secundaria->img_file != "") {
									if ($secundaria->img_file != null) {
										$nameimagen = "novedades/" . $secundaria->img_file;
										echo $this->Html->image($nameimagen, [
											"alt" => "Novedades",
											'class' => 'news-img',
											'width' => '100%',
											'loading' => 'lazy',
											'url' => ['controller' => 'novedades', 'action' => 'noticia', $secundaria->id]
										]);
									}
								}
								?>
								<div class="news-date">
									<?php
									$diassemana = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
									$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
									echo date_format($secundaria['fecha'], 'd') . " de " . $meses[date_format($secundaria['fecha'], 'm') - 1] . " del " . date_format($secundaria['fecha'], 'Y');
									?>
								</div>
								<div class="news-item-content">
									<h4><?= $this->Html->link($secundaria->titulo, ['controller' => 'Novedades', 'action' => 'noticia', $secundaria->id, '_full' => true]); ?></h4>
									<?= $secundaria->descripcion ?>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>

			<?php endif; ?>
		</section>
		<?php echo $this->element('novedades_aside_sidebar'); ?>
	</div>

	<?php echo $this->element('novedades_img_divisor'); ?>


	<?php foreach ($agrupadasPorCategoria as $categoriaId => $categoria): ?>
		<?php if (count($categoria['items']) > 0): ?>
			<?php echo $this->element('novedades_sliders_notas', [
				'id' => $categoriaId,
				'titulo' => $categoria['titulo'],
				'items' => $categoria['items']
			]); ?>
		<?php endif; ?>
	<?php endforeach; ?>
</div>



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