<div class="tab_container">
		<div id="tab1" class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
		<thead> 
        <tr>
            <th class="header"><?= $this->Paginator->sort('codigo') ?></th>
            <th class="header"><?= $this->Paginator->sort('razon_social') ?></th>
			<th class="header"><?= $this->Paginator->sort('habilitado') ?></th>
            <th class="header"><?= $this->Paginator->sort('ClientesCreditos.compra_minima','Compra Minima') ?></th>
            <th class="header">Crédito Disponible</th>
            
			<th class="actions"><?= __('') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?= h($cliente->codigo) ?></td>
            <td><?= h($cliente->razon_social) ?></td>
            
			<td><?php if ($cliente->habilitado==1) 
						echo "SI";
					else
						echo "NO";
				?></td>
           <td> 
		    <?php 
					if ($cliente['clientes_creditos']!=null)
					echo $cliente['clientes_creditos'][0]['compra_minima']; ?>
		   </td>
		   <td> 
		    <?php 
					if ($cliente['clientes_creditos']!=null)
					echo $cliente['clientes_creditos'][0]['credito_maximo']-$cliente['clientes_creditos'][0]['credito_consumo']; ?>
		   </td>

            <td class="actions">
			<?=
				$this->Html->image("admin/icn_edit.png", array(
				"alt" => "Edit",
				'url' => array('controller' => 'clientes', 'action' => 'edit_admin',  $cliente->id)
				));
                ?>
				<?=
				$this->Html->image("admin/icn_view.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'clientes', 'action' => 'view_admin',  $cliente->id)
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
						//echo $this->Paginator->current([500]);
			?>
        </ul>
		
        <div class="total">
		<?php
			echo $this->Paginator->counter('{{count}} Total');
		?>
		</div>
		</div>