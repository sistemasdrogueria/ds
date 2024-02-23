<?php echo $this->Html->script('jquery.printPage');	?>
<script>  
  $(document).ready(function() {  $(".btnPrint").printPage();  });
</script>
<div>	
<div id="tab1" class="tab_content">
<table class="tablesorter" cellspacing="0"> 
<thead> 
<tr>
<th class="header" style=" width:50px;"><?= $this->Paginator->sort('id','N° COD') ?></th>
<th class="header" style=" width:50px;"><?= $this->Paginator->sort('creado','Creado') ?></th>
<th class="header" style=" width:200px;"><?= $this->Paginator->sort('cliente_id','Cliente' )?></th>
<th class="header" style=" width:90px;"><?= $this->Paginator->sort('factura_numero', 'N° Factura') ?></th>
<th class="header" style=" width:60px;"><?= $this->Paginator->sort('fecha_recepcion','Fech Fact.') ?></th>
<th class="header" style=" width:70px;"><?php echo 'N° Pedido'; ?></th>

<th class="header" style=" width:170px;"><?= $this->Paginator->sort('reclamos_tipo_id', 'Tipo') ?></th>
<th class="header" style=" width:50px;"><?= $this->Paginator->sort('estado_id','Estado') ?></th>
<th class="header" style=" width:150px;"><?= $this->Paginator->sort('observaciones') ?></th>
<th class="header"> <?= $this->Paginator->sort('leido') ?></th>
<th class="actions" ><?= __('Acciones') ?></th>

</tr>
</thead>
    <tbody>
	<?php foreach ($reclamos as $reclamo): ?>
        <tr>
            <td style=" width:50px;"><?= $reclamo['id'] ?></td>
			<td style=" width:50px;"><?= $reclamo['creado']?> </td>
			<td style=" width:200px;"><?php echo str_pad($reclamo['cliente']['codigo'] , 5, '0', STR_PAD_LEFT).' - '. $reclamo['cliente']['razon_social']; ?></td>
            <td style=" width:90px;"><?php echo str_pad($reclamo['factura_seccion'], 4, '0', STR_PAD_LEFT).'-'.str_pad($reclamo['factura_numero'], 8, '0', STR_PAD_LEFT); ?></td>
			<td style=" width:60px;"><?= $reclamo['fecha_recepcion'] ?></td>
			
			<td style=" width:70px;"><?= $reclamo['pedido_numero'] ?></td>
			
            <td style=" width:170px;"><?= $reclamo['reclamos_tipo']['nombre'] ?>  </td>
			<td style=" width:50px;"><?= $reclamo['reclamos_estado']['nombre'] ?></td>
            <td style=" min-width:150px; width:20%"><?php echo substr($reclamo['observaciones'], 0, 40);  ?></td>
			<td style=" width:50px; text-align:center;" ><?php if ($reclamo['leido']==0)
						echo $this->Html->image("admin/noleido.png",["alt" => "No leido"]);
					else
						echo $this->Html->image("admin/leido.png",["alt" => "Leido"]);
				?></td>
			<td class="actions" style=" width:80px;">

				<?php
			
			
				echo $this->Form->postLink(
					    $this->Html->image(
					        "admin/icn_check.png", 
					        ["alt" => __('Delete')]
					    ), 
					    ['controller' => 'Tickets', 'action' => 'edit_admin', $reclamo['id'],3],
					    ['escape' => false, 'confirm' => __('Esta seguro de Aprobar ticket?', $reclamo['id'])]
					);
				 echo $this->Form->postLink(
					    $this->Html->image(
					        "admin/icn_no_check.png", 
					        ["alt" => __('Delete')]
					    ), 
					    ['controller' => 'Tickets', 'action' => 'edit_admin', $reclamo['id'],4],
					    ['escape' => false, 'confirm' => __('Esta seguro de rechazar ticket?', $reclamo['id'])]
					);
				echo $this->Html->image("admin/icn_view.png", ["alt" => "Ver",
				'url' => ['controller' => 'Tickets', 'action' => 'view_admin',  $reclamo['id']]		]);
               	echo $this->Html->image("admin/icon-sendmail.png", ["alt" => "Ver",
				'url' => ['controller' => 'Tickets', 'action' => 'ticket_mail',  $reclamo['id']]	]);?>
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
	