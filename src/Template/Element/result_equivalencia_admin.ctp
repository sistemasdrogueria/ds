
<p class="text-muted font-13 m-b-30"></p>		
	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	  <thead>
		<tr>
				<th scope="col"><?= $this->Paginator->sort('id','Codigo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cliente_id','Cliente') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cantidad_disponible','Puntos Disponibles') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modificado','Ultimo cambio') ?></th>
				<th class="actions"><?= __('Actions') ?></th>
		</tr>
	  </thead>
	  <tbody>  
	  <?php foreach ($puntos as $punto): ?>
            <tr>
                
				<td><?= $punto->has('cliente') ? $punto->cliente->codigo : '' ?></td>
                <td><?= $punto->has('cliente') ? $punto->cliente->razon_social : '' ?></td>
                
                  <td><?= number_format(round($punto->cantidad_disponible, 3),0,',','.');?>
				<td><?= date_format($punto['modificado'],'d-m-Y H:i:s'); ?></td>
				<td class="actions">
                    <?=	$this->Html->image("admin/icn_edit.png", ["alt" => "Edit",'url' => ['controller' => 'Puntos', 'action' => 'edit_admin',  $punto['id']]]); ?>
					<?= $this->Form->postLink($this->Html->image('admin/icn_trash.png',
						["alt" => __('Delete'), "title" => __('Delete')]), 
						['action' => 'delete_admin', $punto['id']], 
						['escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $punto['id'])]);
					?>
                </td>
            </tr>
		<?php endforeach; ?>
	  </tbody>
	</table>

<div class="paginator">
	<ul class="pagination">
		<?= $this->Paginator->first('<< ' . __('Primero')) ?>
		<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next(__('Siguiente') . ' >') ?>
		<?= $this->Paginator->last(__('Ultimo') . ' >>') ?>
	</ul>
	<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, {{count}} total')]) ?></p>
</div>

            

