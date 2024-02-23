<div>	
		<div id="tab1" class="tab_content">
		<?= $this->Form->create('Fragancias',['url'=>['controller'=>'Fragancias','action'=>'edit_admin']]); ?>
		<table class="tablesorter"> 
		<thead> 
        <tr>
			<th><?= $this->Paginator->sort('id','Imagen') ?></th>
            <th><?= $this->Paginator->sort('nombre','Descripción') ?></th>
			<th><?= $this->Paginator->sort('marca_id') ?></th>
            <th><?= $this->Paginator->sort('genero_id') ?></th>
			<th><?= $this->Paginator->sort('eliminado','Activa') ?></th>
			<th><?= $this->Paginator->sort('creado') ?></th>
            <th class="actions"><?= __('') ?></th>
        </tr>
    </thead>
    <tbody>
	
	<?php $indice=0; ?>
	
    <?php foreach ($fragancias as $fragancia): ?>
        <tr>
		<td>
			<?php 
			
			$uploadPath = 'fragancias/';
			
			if (file_exists('www.drogueriasur.com.ar/ds2/webroot/img/'.$uploadPath.$fragancia['imagen'] ))
			echo $this->Html->image($uploadPath.$fragancia['imagen'], ['alt' => str_replace('"', '', $fragancia['nombre']),'height' => 100]);
			else
				echo $this->Html->image($uploadPath.$fragancia['imagen'], ['alt' => str_replace('"', '', $fragancia['nombre']),'height' => 100]);
		
			//echo $uploadPath.$fragancia['imagen'];	
			?> 
			           
			</td>
         
            
			<td>
                <?= $fragancia->nombre ?>
            </td>
             <td><?= $fragancia->has('marca') ? $fragancia->marca->nombre : '' ?></td>
                <td><?= $fragancia->has('genero') ? $fragancia->genero->nombre : '' ?></td>
                 <td><?php if($fragancia->eliminado==0)
					echo "SI";
				else
					echo "NO";
			?>
			
		
				</td>
                <td><?= h($fragancia->creado) ?></td>
         
			
            <td class="actions">
              
			<?=	$this->Html->image("admin/icn_edit.png", array(
				"alt" => "Edit",
				'url' => array('controller' => 'fragancias', 'action' => 'edit_admin',  $fragancia->id)
				));
                ?>
			<?=	$this->Html->image("admin/icn_view.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'fragancias', 'action' => 'view_admin',  $fragancia->id)
				));?>
             <?php 
					
					echo $this->Form->postLink(
						$this->Html->image('admin/icn_trash.png',
						   array("alt" => __('Delete'), "title" => __('Delete'))), 
						array('action' => 'delete_admin', $fragancia->id), 
						array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $fragancia->id))
					);
			  ?>
			</td>
        </tr>

    <?php endforeach; ?>
		</tbody> 
		</table>
			
	
	
		</div><!-- end of .tab_container -->
		 <div class="pagination">
        <ul>
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
</div>		