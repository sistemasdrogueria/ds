<div class="articulos index large-10 medium-9 columns">

    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
		    <th rowspan="2"><?= $this->Paginator->sort('id', 'Nº Pedido') ?></th>
            <th rowspan="2"><?= $this->Paginator->sort('creado','Fecha') ?></th>
            <th rowspan="2"><?=$this->Paginator->sort('estado_id','Estado')?></th>
            <th rowspan="2"><?= $this->Paginator->sort('sucursal_id','Forma Envio') ?></th>
            <th rowspan="2"><?= $this->Paginator->sort('tipo_fact','Tipo') ?></th>
			<th rowspan="2"><?= $this->Paginator->sort('nro_pedido_ds','Nº Ped. DS') ?></th>
			
			<th></th>
			<th></th>
			<th></th>
        </tr>
		  
    </thead>
    <tbody>
    <?php foreach ($pedidos as $pedido): ?>
        <tr>
            <td  class="colcenter"><?= $this->Number->format($pedido['id']) ?>	</td>
            <td  class="colcenter">
				<?php 
					echo date_format($pedido['creado'],'d-m-Y H:i:s');
				?>			
			</td>
			<td  class="colcenter"> <?php 
			echo $estados[$pedido['estado_id']-1]['nombre']; ?> </td>
            <td  class="colcenter">
			<?php 
				if ($pedido['forma_envio']==0) 
				{ echo 'Envio A Domicilio';	}
				else
				{
					if ($pedido['forma_envio']==99) 
						{ echo 'Retiro Cadete';	}
					else 
						{ echo 'Envio a Sucursal '.$pedido['sucursal_id'] ; }
						
				}
			?>
			</td>
            <td  class="colcenter"><?= h($pedido['tipo_fact']) ?>		</td>
			 <td  class="colcenter"><?= h($pedido['nro_pedido_ds']) ?>		</td>
			
			<td class="actions">
				<?=
				$this->Html->image("admin/icn_view.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'pedidos', 'action' => 'view',  $pedido['id'])
				));?>
				 </td>
				  <td>
				<?=
				$this->Html->image("txt.png", array(
				"alt" => "txt",
				'url' => array('controller' => 'pedidos', 'action' => 'downloadfiletxt',  $pedido['id'])
				));?>
				  </td>
				  <td>
				
				<?php
				if ($pedido['pedidos_status_id']==7)
				echo $this->Html->image("txt_falta.png", array(
				"alt" => "txt",
				'url' => array('controller' => 'pedidos', 'action' => 'downloadfilefaltastxt',  $pedido['id'])
				));?>
				
				
				  <?php
				  
				$mensaje='';
				switch ($pedido['pedidos_status_id']) {
			                    case 1: $mensaje = 'No Habilitada';break;
                                case 3: $mensaje = 'Pos. Duplicado';break;
                                case 4: $mensaje = 'Cod. Cliente Incorrecto';break;
								case 5: $mensaje = 'Limite Compra';break; 
                            }
							echo $mensaje;
				?>
            </td>
        </tr>
		
    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
			<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Pedidos') ?> </span></div>
        </ul>
    </div>
</div>
<script type="text/javascript">
	$("tr").not(':first').hover(
	function () {
		$(this).css("background","#8FA800");
		$(this).css("color","#000");
		$(this).css("font-weight","");
	  }, 
	function () {
		$(this).css("background","");
		$(this).css("color","");
		$(this).css("font-weight","");
	  }
	);
	
	$("tr#info").click(function() {        // function_tr
		
	});
</script>