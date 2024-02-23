<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?= $titulo ?></h3>
		</header>
	<div class="tab_container">
		<div id="tab1" class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
		<thead> 
        <tr>
            <th class="header"><?= $this->Paginator->sort('id') ?></th>
            <th class="header"><?= $this->Paginator->sort('nombre') ?></th>
            <th class="header"><?= $this->Paginator->sort('cliente_id') ?></th>
            <th class="header"><?= $this->Paginator->sort('perfile_id') ?></th>
            <th class="header"><?= $this->Paginator->sort('role') ?></th>
            <th class="header"><?= $this->Paginator->sort('creacion') ?></th>
            <th class="header"><?= $this->Paginator->sort('ultimo_cambio') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $this->Number->format($user->id) ?></td>
            <td><?= h($user->nombre) ?></td>
            <td>
                <?= $user->has('cliente') ? $this->Html->link($user->cliente->nombre, ['controller' => 'Clientes', 'action' => 'view', $user->cliente->id]) : '' ?>
            </td>
            <td>
                <?= $user->has('perfile') ? $this->Html->link($user->perfile->nombre, ['controller' => 'Perfiles', 'action' => 'view', $user->perfile->id]) : '' ?>
            </td>
            <td>
                <?=$user->role ?>
            </td>
            <td><?= h($user->creacion) ?></td>
            <td><?= h($user->ultimo_cambio) ?></td>
            <td class="actions">
			<?=
				$this->Html->image("admin/icn_edit.png", array(
				"alt" => "Edit",
				'url' => array('controller' => 'Users', 'action' => 'edit',  $user->id)
				));
                ?>
				<?=
				$this->Html->image("admin/icn_view.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'users', 'action' => 'view',  $user->id)
				));?>
               <?php 
					
					echo $this->Form->postLink(
						$this->Html->image('admin/icn_trash.png',
						   array("alt" => __('Delete'), "title" => __('Delete'))), 
						array('action' => 'delete', $user->id), 
						array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $user->id))
					);
			  ?>
            </td>
        </tr>
		<?php endforeach; ?>
	</tbody> 
			</table>
			</div><!-- end of #tab1 -->

		</div><!-- end of .tab_container -->
		
 
	    <div class="pagination">
        <ul >
            <?php
						echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
						echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
						echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
					?>
        </ul>
		
        <div class="total">
		<?php
			echo $this->Paginator->counter('{{count}} Total');
		?>
		</div>
		</div>
		 
</article><!-- end of content manager article -->

