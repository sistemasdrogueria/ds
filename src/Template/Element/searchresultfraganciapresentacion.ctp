<div class="fraganciasPresentaciones index large-9 medium-8 columns content">
    <h3><?= __('Fragancias Presentaciones') ?></h3>
    <table class="tablesorter" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
               
            <th><?= $this->Paginator->sort('descripcion_pag','Decripción') ?></th>
            <th><?= $this->Paginator->sort('stock','Stock') ?></th>
                <th><?= $this->Paginator->sort('detalle','Tamaño') ?></th>
                <th><?= $this->Paginator->sort('creado') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php

                                    use App\Model\Entity\Articulo;

foreach ($fraganciaspresentaciones as $fraganciasPresentacione): ?>
            <tr>
            <td><?= h($fraganciasPresentacione['articulo']['descripcion_pag']) ?></td>
            <td>
                
            <?php 
            
            

            switch ($fraganciasPresentacione['articulo']['stock']) {
				case 'B':
					echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );
					break;
				case 'F':
					echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);
					break;
				case 'S':
					echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);
					break;
				case 'R':
					echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);
					break;
				case 'D':
					echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);
					break;
			}
             ?></td>
                <td><?= h($fraganciasPresentacione->detalle) ?></td>
                <td><?= h($fraganciasPresentacione->creado) ?></td>
                <td class="actions">
				
				   
			<?=	$this->Html->image("admin/icn_edit.png", array(
				"alt" => "Edit",
				'url' => array('controller' => 'fraganciaspresentaciones', 'action' => 'edit_admin',  $fraganciasPresentacione->id)
				));
                ?>
			
             <?php 
					
					echo $this->Form->postLink(
						$this->Html->image('admin/icn_trash.png',
						   array("alt" => __('Delete'), "title" => __('Delete'))), 
						array('action' => 'delete_admin', $fraganciasPresentacione->id), 
						array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $fraganciasPresentacione->detalle))
					);
			  ?>
			  
                   </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
</div>
