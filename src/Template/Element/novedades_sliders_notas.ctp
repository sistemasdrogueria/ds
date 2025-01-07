<section class="category-section">
    <?php if (!empty($id)): ?>
        <h2><?php echo $this->Html->link($titulo, ['controller' => 'Novedades', 'action' => 'search', $id, '_full' => true], ['class' => 'menu__link']); ?></h2>
    <?php else: ?>
        <h2><?= $titulo ?></h2>
    <?php endif; ?>
    
    <div class="swiper-container category-news">
        <div class="swiper-wrapper">
            <?php foreach ($items as $nota): ?>
                <div class="swiper-slide category-news-item">
                    <?php
                    if ($nota->img_file != "") {
                        if ($nota->img_file != null) {
                            $nameimagen = "novedades/" . $nota->img_file;
                            echo $this->Html->image($nameimagen, ["alt" => "Novedades", 'width' => '100%', 'loading' => 'lazy', 'url' => ['controller' => 'novedades', 'action' => 'noticia',  $nota->id]]);
                        }
                    }
                    ?>
                    <div class="category-news-content">
                        <div class="news-date">
                            <?php
                            $diassemana = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
                            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                            echo date_format($nota['fecha'], 'd') . " de " . $meses[date_format($nota['fecha'], 'm') - 1] . " del " . date_format($nota['fecha'], 'Y');
                            ?>
                        </div>
                        <h4><?php echo $this->Html->link($nota->titulo, ['controller' => 'Novedades', 'action' => 'noticia', $nota->id, '_full' => true]); ?></h4>
                        <div>
                            <?= $nota->descripcion ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>
<hr>

<script>
    function initializeAllSwipers() {
        document.querySelectorAll('.swiper-container').forEach(swiperElement => {
            new Swiper(swiperElement, {
                slidesPerView: 1,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: swiperElement.querySelector('.swiper-pagination'),
                    clickable: true,
                },
                breakpoints: {
                    412: {
                        slidesPerView: 1
                    },
                    640: {
                        slidesPerView: 2
                    },
                    768: {
                        slidesPerView: 3
                    },
                    1024: {
                        slidesPerView: 5
                    }
                }
            });
        });
    }
</script>