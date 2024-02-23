<article class="module width_full">
		<header><h3><?= $titulo ?></h3></header>
		<div class="module_content">
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombres') ?></th>
            <td><?= h($curriculum->nombres) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Apellidos') ?></th>
            <td><?= h($curriculum->apellidos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Documento') ?></th>
            <td><?= h($curriculum->documento) ?></td>
        </tr>
		     
        <tr>
            <th scope="row"><?= __('Fecha Nacimiento') ?></th>
            <td><?= h($curriculum->fecha_nacimiento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($curriculum->email) ?></td>
        </tr>

     
        <tr>
            <th scope="row"><?= __('Telefono') ?></th>
               <td><?= h($curriculum->telefono) ?></td>
        </tr>
        
        <tr>
            <th scope="row"><?= __('Descargar Cv') ?></th>
            <td>
			<?php echo $this->Html->image('admin/icn_download.png',['title' => 'Descargar','url'=>['controller'=>'Curriculums','action' => 'downloadfile', $curriculum->archivo_cv]]); ?>
			</td>
        </tr>

        <tr>
            <th scope="row"><?= __('Enviado el') ?></th>
            <td><?= h($curriculum->creado) ?></td>
        </tr>

    </table>
	</div>
</article><!-- end of styles article -->
