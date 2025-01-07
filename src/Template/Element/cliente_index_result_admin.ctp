<div class="tab_container">
		<div id="tab1" class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
		<thead> 
        <tr>
            <th class="centrado"><?= $this->Paginator->sort('codigo') ?></th>
            <th class="centrado"><?= $this->Paginator->sort('razon_social') ?></th>
			<th class="centrado"><?= $this->Paginator->sort('localidad') ?></th>
			<th class="centrado"><?= $this->Paginator->sort('codigo_postal') ?></th>
			<th class="centrado"><?= $this->Paginator->sort('habilitado') ?></th>
            <th class="centrado"><?= $this->Paginator->sort('ClientesCreditos.compra_minima','Compra Minima') ?></th>
            <th class="centrado">Crédito Disponible</th>
            
			<th class="actions"><?= __('') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($clientes as $cliente): ?>
        <tr>
		<td class=centrado><?= h($cliente->codigo) ?></td>
            <td><?= h($cliente->razon_social) ?></td>
            <td><?= h($cliente['localidad']['nombre']) ?></td>
			<td class=centrado><?= h($cliente->codigo_postal) ?></td>
			<td class=centrado><?php if ($cliente->habilitado==1) 
						echo "SI";
					else
						echo "NO";
				?></td>
           <td style="text-align: right; margin-right: 5px;"> 
		    <?php 
					if ($cliente['clientes_creditos']!=null)
					{
					
					
					$precio =  $cliente['clientes_creditos'][0]['compra_minima'];
					echo '$ ' . number_format($precio, 2, ',', '.');
					}
					?>


		   </td>
		   <td style="text-align: right; margin-right: 5px;"> 
		    <?php 
					if ($cliente['clientes_creditos']!=null)

					{
						$precio =  $cliente['clientes_creditos'][0]['credito_maximo']-$cliente['clientes_creditos'][0]['credito_consumo'];
					echo '$ ' . number_format($precio, 2, ',', '.');
					}
					?>
		   </td>

		   <td class=centrado >
			<?php
			echo $this->Html->image("admin/admin_edit.png", ["alt" => "Edit",'url' => ['controller' => 'clientes', 'action' => 'edit_admin',  $cliente->id],
			'data-static'=>'../img/admin/admin_edit.png','data-hover'=>'../img/admin/admin_edit.gif','class'=>'hover-gif','style'=>'width=50px']);
			echo $this->Html->image("admin/admin_view.png", ["alt" => "Edit",'url' => ['controller' => 'clientes', 'action' => 'view_admin',  $cliente->id],
			'data-static'=>'../img/admin/admin_view.png','data-hover'=>'../img/admin/admin_view.gif','class'=>'hover-gif','style'=>'width=50px']);
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
						//echo $this->Paginator->current([500]);
			?>
        </ul>
		
        <div class="total">
		<?php
			echo $this->Paginator->counter('{{count}} Total');
		?>
		</div>
		</div>