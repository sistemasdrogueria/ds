<article class="module width_full">
			<header><h3><?= $titulo ?></h3></header>
				<div class="module_content">
					<h3><?= __('Nombre') ?></h3>
					<h2><?= h($user->username) ?></h2>
					<br/>
					<h3><?= __('Usuario Rol') ?></h3>
					<h2><?= h($user->role) ?></h2>
					<br/>
					<h3><?= __('Creado') ?></h3>
					<h2><?= h($user->created) ?></h2>
					<br/>
					<h3><?= __('Ultimo Cambio') ?></h3>
					<h2><?= h($user->modified) ?></h2>
				</div>
</article><!-- end of styles article -->