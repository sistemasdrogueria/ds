<div class="tab_container">
		<div id="tab1" class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
		<thead> 
        <tr>

            <th class="header"><?= $this->Paginator->sort('descripcion') ?></th>
			<th class="header"><?= $this->Paginator->sort('name') ?></th>
            <th class="header"><?= $this->Paginator->sort('status') ?></th>
			  <th class="header"><?= $this->Paginator->sort('createad') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($files as $file): ?>
        <tr>
           
            <td><?= h($file->descripcion) ?></td>
            
			<td><?php echo $file->name; ?></td>
           <td> 
		    <?php echo $file['status']; ?>
		   </td>
		   <td> 
		    <?php echo $file['created']; ?>
		   </td>
            <td class="actions">
			<?=
				$this->Html->image("admin/icn_edit.png", array(
				"alt" => "Edit",
				'url' => array('controller' => 'descargas', 'action' => 'edit_admin',  $file->id)
				));
                ?>
				<?=
				$this->Html->image("admin/icn_view.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'descargas', 'action' => 'view_admin',  $file->id)
				));?>
               <?php 
					
					echo $this->Form->postLink(
						$this->Html->image('admin/icn_trash.png',
						   array("alt" => __('Delete'), "title" => __('Delete'))), 
						array('action' => 'delete_admin', $file->id), 
						array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $file->id))
					);
			  ?>
			</td>
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