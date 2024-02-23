<article class="module width_3_quarter">
	<table class="tablesorter" cellspacing="0"> 
    <thead>
        <tr>
            <th class="header"><?= $this->Paginator->sort('id') ?></th>
            <th class="header"><?= $this->Paginator->sort('nombre') ?></th>
            <th class="header"><?= $this->Paginator->sort('email') ?></th>
            <th class="header"><?= $this->Paginator->sort('telefono') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($contactos as $contacto): ?>
        <tr>
            <td><?= $this->Number->format($contacto->id) ?></td>
            <td><?= h($contacto->nombre) ?></td>
            <td><?= h($contacto->email) ?></td>
            <td><?= h($contacto->telefono) ?></td>
            <td class="actions">
              
			
			<?=
				$this->Html->image("admin/icn_edit.png", array(
				"alt" => "Edit",
				'url' => array('controller' => 'contactos', 'action' => 'edit',  $contacto->id)
				));
                ?>
				<?=
				$this->Html->image("admin/icn_view.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'contactos', 'action' => 'view',  $contacto->id)
				));?>
               <?php 
					
					echo $this->Form->postLink(
						$this->Html->image('admin/icn_trash.png',
						   array("alt" => __('Delete'), "title" => __('Delete'))), 
						array('action' => 'delete', $contacto->id), 
						array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $contacto->id))
					);
			  ?>
			</td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
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