<?php echo $this->Html->script('jquery.printPage');	?>
<script>  
  $(document).ready(function() {  $(".btnPrint").printPage();  });
</script>
<div>	
<div id="tab1" class="tab_content">
<table class="tablesorter" cellspacing="0"> 
<thead> 
<tr>
<th class="header" style=" width:50px;"><?= $this->Paginator->sort('id','Número') ?></th>
<th class="header" style=" width:50px;"><?= $this->Paginator->sort('cliente_id','Código') ?></th>
<th class="header" style=" width:200px;"><?= $this->Paginator->sort('cliente_id','Razón Social' )?></th>
<th class="header" style=" width:100px;"><?= $this->Paginator->sort('factura_numero','Fact. Número') ?></th>
<th class="header" style=" width:75px;"><?= $this->Paginator->sort('fecha_recepcion','Fact. Fecha') ?></th>
<th class="header" style=" width:170px;"><?= $this->Paginator->sort('reclamos_tipo_id') ?></th>
<th class="header" style=" width:50px;"><?= $this->Paginator->sort('estado_id','Estado') ?></th>
<th class="header" style=" width:250px;"><?= $this->Paginator->sort('observaciones') ?></th>
<th class="header"> <?= $this->Paginator->sort('leido') ?></th>
<th class="actions" ><?= __('Acciones') ?></th>

</tr>
</thead>
    <tbody>
	<?php foreach ($reclamos as $reclamo): ?>
        <tr>
            <td style=" width:50px;"><?= $reclamo['id'] ?></td>
			<td style=" width:50px;"><?= $reclamo['cliente']['codigo']; ?> </td>
			<td style=" width:200px;"><?= $reclamo['cliente']['razon_social']; ?></td>
            <td style=" width:100px;"><?= $reclamo['factura_numero'] ?></td>
			<td style=" width:75px;"><?= $reclamo['fecha_recepcion'] ?></td>
            <td style=" width:170px;"><?= $reclamo['reclamos_tipo']['nombre'] ?>  </td>
			<td style=" width:50px;"><?= $reclamo['reclamos_estado']['nombre'] ?></td>
            <td style=" min-width:250px; width:30%"><?= h($reclamo['observaciones']) ?></td>
			<td style=" width:50px; text-align:center;" ><?php if ($reclamo['leido']==0)
						echo $this->Html->image("admin/icn_no_check.png",["alt" => "No leido"]);
					else
						echo $this->Html->image("admin/icn_check.png",["alt" => "Leido"]);
				?></td>
			<td class="actions" style=" width:70px;">
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
               <!--?= $this->Html->image("admin/icon-print.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'reclamos', 'action' => 'view_admin',  $reclamo['id']),
				'class'=>'btnPrint'
				));?-->
			<?= $this->Html->image("admin/icon-sendmail.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'reclamos', 'action' => 'reclamo_mail',  $reclamo['id']),
			
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
?>
</ul>
<div class="total">
<?php
echo $this->Paginator->counter('{{count}} Total');
?>
</div>
</div>
	