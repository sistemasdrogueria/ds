<div class="jobs view large-9 medium-8 columns content" id="job_view" onload="load()">
<h2> <?= h($job->titulo) ?></h2>
<div class="view_descripcion">
<p class="view_titulo">DESCRIPCION DEL PUESTO</p>
<p class="view_texto">
En Drogueria Sur nos encontramos en búsqueda de un <b><?= $job->has('puesto') ? $job->puesto->nombre : '' ?></b> para el area de 
<b><?= $job->has('sector') ? $job->sector->nombre : '' ?></b>.
</p>
<p class="view_texto">
Las principales tareas serán: <br>
<?= $this->Text->autoParagraph(h($job->tareas)); ?>

</p>
<p class="view_titulo">REQUISITOS</p>
<p class="view_texto">
<?= $this->Text->autoParagraph(h($job->requerimiento)); ?>
</p>
<p class="view_texto">
Lugar de trabajo: Bahía Blanca</br> 
Dedicacion: <?= h($job->disponibilidad) ?>
</p>
</div>
<div class="view_detalle">
<p class="view_titulo">DETALLES</p>
<p class="view_texto"> 
	Nivel mínimo de educación: <?= h($job->nivel_educacion) ?> </br>
	Edad: <?= h($job->edad) ?> </br>
	Sexo: <?= h($job->sexo) ?> </br>
    Cantidad de vacantes: <?= $this->Number->format($job->cantidad_vacante) ?>
</p>
<p>Fecha Publicado: <?= h($job->fecha) ?></p>
</div>
</div>
<script>
window.onload = function(){
    $('html, body').animate({scrollTop:$('#job_view').position().top}, 'slow');
};

	
</script>