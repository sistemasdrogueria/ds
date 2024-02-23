<div class="tab_container">
	
	
		<div id="tab1" class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
		<thead> 
        <tr>
            <th class="header"><?= $this->Paginator->sort('id','Número') ?></th>
            <th class="header"><?= $this->Paginator->sort('username','Usuario') ?></th>
           	<th class="header"><?= $this->Paginator->sort('cliente_id','Cliente') ?></th>
			<th class="header"><?= $this->Paginator->sort('role','Rol') ?></th>
			<th class="header"><?= $this->Paginator->sort('perfile_id','Perfil') ?></th>
			
            <th class="header"><?= $this->Paginator->sort('created','Creado') ?></th>
            <th class="header"><?= $this->Paginator->sort('modified','Modificado') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $this->Number->format($user['id']) ?></td>
            <td><?= h($user['username']) ?></td>
			<td><?php echo $user['cliente']['nombre'] ?></td>
     
            <td><?= h($user['role']) ?></td>
			<td><?= h($user['perfile_id']) ?></td>
			<td><?= h($user['created']) ?></td>
            <td><?= h($user['modified']) ?></td>
            <td class="actions">
			<?=
				$this->Html->image("admin/icn_edit.png", array(
				"alt" => "Edit",
				'url' => array('controller' => 'users', 'action' => 'edit_admin',  $user['id'])
				));
                ?>
			
               <?php 
					if ($this->request->session()->read('Auth.User.id') === 4985)
					
					echo $this->Form->postLink(
						$this->Html->image('admin/icn_trash.png',
						   array("alt" => __('Delete'), "title" => __('Delete'))), 
						array('action' => 'delete_admin', $user['id']), 
						array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $user['id']))
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