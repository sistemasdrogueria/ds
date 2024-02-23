<article class="module width_full">
			<header><h3><?= $titulo ?></h3></header>
				<div class="module_content">

					<h3><?= __('Nombre') ?></h3>
					<h2><?= h($usuario->nombre) ?></h2>
					<br/>
					<h3><?= __('Cliente') ?></h3>
					<h2><?= h($usuario->cliente->nombre) ?></h2>
					<br/>
					<h3><?= __('Perfile') ?></h3>
					<h2><?= h($usuario->perfile->nombre) ?></h2>
					<br/>
					<h3><?= __('Usuarios Tipo') ?></h3>
					<h2><?= h($usuario->usuarios_tipo->nombre) ?></h2>
					<br/>
					<h3><?= __('Creado') ?></h3>
					<h2><?= h($usuario->creacion) ?></h2>
					<br/>
					<h3><?= __('Ultimo Cambio') ?></h3>
					<h2><?= h($usuario->ultimo_cambio) ?></h2>
					
				</div>
</article><!-- end of styles article -->