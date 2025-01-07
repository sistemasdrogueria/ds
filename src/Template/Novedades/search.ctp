<style>
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .news-card {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 400px;
    }

    .news-card:hover {
        transform: translateY(-5px);
    }

    .news-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .news-content {
        padding: 15px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .news-title {
        font-size: 1.2em;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .news-excerpt {
        font-size: 0.9em;
        color: #7f8c8d;
        margin-bottom: 10px;
        flex-grow: 1;
    }

    .news-meta {
        display: flex;
        justify-content: flex-start;
        color: #95a5a6;
        margin-top: auto;
        font-weight: bold;
    }
</style>

<?php echo $this->element('novedades_filter'); ?>

<h1>Resultados de su busqueda</h1>
<div id="newsGrid" class="news-grid">

    <?php foreach ($notasbuscadas as $nota): ?>
        <div class="news-card">
            <?php
            if ($nota->img_file != "") {
                if ($nota->img_file != null) {
                    $nameimagen = "novedades/" . $nota->img_file;
                    echo $this->Html->image($nameimagen, [
                        "alt" => "Novedades",
                        'width' => '100%',
                        'loading' => 'lazy',
                        'url' => ['controller' => 'novedades', 'action' => 'noticia',  $nota->id,]
                    ]);
                }
            }
            ?>
            <div class="news-content">
                <h2 class="news-title"><?php echo $this->Html->link($nota->titulo, ['controller' => 'Novedades', 'action' => 'noticia', $nota->id, '_full' => true]); ?></h2>
                <div style="width: 300px;height: 80px;overflow: hidden;">
                    <?= $nota->descripcion ?>
                </div>
                <div class="news-meta">
                    <?php
                    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    echo date_format($nota->fecha, 'd') . " de " . $meses[date_format($nota->fecha, 'm') - 1] . " del " . date_format($nota->fecha, 'Y');
                    ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="pagination">
    <?= $this->Paginator->prev('« Anterior') ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('Siguiente »') ?>
</div>
