<div>	
		<div id="tab1" class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
		<thead> 
        <tr>
			<th class="header"><?= $this->Paginator->sort('id','Número') ?></th>
            <th class="header"><?= $this->Paginator->sort('cliente_id') ?></th>
            <th class="header"><?= $this->Paginator->sort('factura_numero','Pedido Número') ?></th>
            
            <th class="header"><?= $this->Paginator->sort('reclamos_tipo_id') ?></th>
			<th class="header"><?= $this->Paginator->sort('estado_id','Estado') ?></th>
            <th class="header"><?= $this->Paginator->sort('observaciones') ?></th>
			
			
            <th class="actions"><?= __('Acciones') ?></th>
			<th class="header"><?= $this->Paginator->sort('leido') ?></th>
        </tr>
    </thead>
    <tbody>
	<?php foreach ($reclamos as $reclamo): ?>
        <tr>
            <td><?= $reclamo['id'] ?></td>
            <td>
                <?php echo $reclamo['cliente']['codigo']. ' - '. $reclamo['cliente']['razon_social']; ?>
            </td>
            <td><?= $reclamo['factura_numero'] ?></td>
            
            <td>
                <?= $reclamo['reclamos_tipo']['nombre'] ?>
            </td>
			<td><?= $reclamo['reclamos_estado']['nombre'] ?></td>
			
            <td><?= h($reclamo['observaciones']) ?></td>
			<td class="actions">
			<?=
				$this->Html->image("admin/icn_edit.png", array(
				"alt" => "Edit",
				'url' => array('controller' => 'reclamos', 'action' => 'edit_admin',  $reclamo['id'])
				));
                ?>
				<?=
				$this->Html->image("admin/icn_view.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'reclamos', 'action' => 'view_admin',  $reclamo['id'])
				));?>
               <?= $this->Html->image("admin/icon-sendmail.png", array(
				"alt" => "mail",
				'url' => array('controller' => 'reclamos', 'action' => 'reclamo_mail',  $reclamo['id']),
			
				));?>
            </td>
			<td><?php if ($reclamo['leido']==0)
						echo 'NO Leido';
					else
						echo 'Leido';
						?></td>
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
</div>		