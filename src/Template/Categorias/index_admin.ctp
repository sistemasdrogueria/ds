<article class="module width_3_quarter">
		<header>
			<h3 class="tabs_involved"><?= $titulo ?></h3>
		</header>
	<div class="tab_container">
	<div id="tab1" class="tab_content">
	<table class="tablesorter" cellspacing="0"> 
	<thead> 
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('nombre') ?></th>
            <th><?= $this->Paginator->sort('descripcion') ?></th>
            <th class="actions"><?= __('Acciones') ?></th>
        </tr>
    </thead>
    <tbody>
	
	<?php foreach ($categorias as $categoria): ?>
        <tr>
            <td><?= $this->Number->format($categoria->id) ?></td>
            <td><?= h($categoria->nombre) ?></td>
            <td><?= h($categoria->descripcion) ?></td>
			<td class="actions">
			<?=
				$this->Html->image("admin/icn_edit.png", array(
				"alt" => "Edit",
				'url' => array('controller' => 'categorias', 'action' => 'edit_admin',  $categoria->id)
				));
                ?>
				<?=
				$this->Html->image("admin/icn_view.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'categorias', 'action' => 'view_admin',  $categoria->id)
				));?>
               <?php 
					
					echo $this->Form->postLink(
						$this->Html->image('admin/icn_trash.png',
						   array("alt" => __('Delete'), "title" => __('Delete'))), 
						array('action' => 'delete_index', $categoria->id), 
						array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $categoria->id))
					);
			  ?>
			  <?=
			  $this->Html->image("admin/icn_new.png", array(
				"alt" => "Agregar Subcategoria",
				'url' => array('controller' => 'categorias', 'action' => 'add_sub_admin',  $categoria->id)
			  ));?>
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