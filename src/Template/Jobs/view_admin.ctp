<article class="module width_full">
		<header><h3><?= $titulo ?></h3></header>

<div class="module_content">
    <h3><?= h($job->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Titulo') ?></th>
            <td><?= h($job->titulo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Puesto') ?></th>
            <td><?= $job->has('puesto') ? $job->puesto->nombre : '' ?></td>
        </tr>
        <tr>
               <th scope="row"><?= __('Area') ?></th>
            <td><?= $job->has('sector') ? $job->sector->nombre : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cantidad Vacantes') ?></th>
            <td><?= $this->Number->format($job->cantidad_vacante) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($job->fecha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Publicación Activa') ?></th>
            <td><?= $job->activo ? __('Si') : __('No'); ?></td>
        </tr>
		 <tr>
            <th scope="row"><?= __('Horario') ?></th>
            <td><?= h($job->horario) ?></td>
        </tr>
		 <tr>
            <th scope="row"><?= __('Edad') ?></th>
            <td><?= h($job->edad) ?></td>
        </tr>
		 <tr>
            <th scope="row"><?= __('Sexo') ?></th>
            <td><?= h($job->sexo) ?></td>
        </tr>
		<tr>
            <th scope="row"><?= __('Disponibilidad') ?></th>
            <td><?= h($job->disponibilidad) ?></td>
        </tr>
		<tr>
            <th scope="row"><?= __('Nivel educativo minimo') ?></th>
            <td><?= h($job->nivel_educacion) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Tareas') ?></h4>
        <?= $this->Text->autoParagraph(h($job->tareas)); ?>
    </div>
    <div class="row">
        <h4><?= __('Requerimiento') ?></h4>
        <?= $this->Text->autoParagraph(h($job->requerimiento)); ?>
    </div>
</div>
</article>