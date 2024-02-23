<div class="articulos index large-10 medium-9 columns">
    <table class='tablesorter' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			
			
            <th><?= $this->Paginator->sort('descripcion_pag','Descripción') ?></th>
            <th><?= $this->Paginator->sort('troquel','Troquel') ?></th>
			<th><?= $this->Paginator->sort('codigo_barras','EAN') ?></th>
			<th><?= $this->Paginator->sort('precio_publico','P.Farmacia') ?></th>
			<th><?= $this->Paginator->sort('stock','Stock') ?></th>
			<th>Presentación</th>
			<th></th>
		</tr>

    </thead>
    <tbody>
	<div id="flotante"></div>
    <?php $indice=0; 
	$descuento_pf =$this->request->session()->read('Auth.User.pf_dcto');
	?>
	<?php foreach ($articulos as $articulo): ?>
       <?= $this->Form->create('Fragancias',['url'=>['controller'=>'Fragancias','action'=>'add_admin_presentacion'],'id'=>'formaddcart','onsubmit'=>'return validaragregar()']); ?>
		<tr onchange="javascript:document.confirmInput.submit();">
		<?php $indice+=1;?>
			<?php echo $this->Form->input('fragancia_id',['type'=>'hidden','value'=>$fragancia->id]);?>
			<?php echo $this->Form->input('articulo_id',['type'=>'hidden','value'=>$articulo['id']]);?>
			<td>
				<?php echo $articulo['descripcion_pag'];?>
			</td>
			<td>
				<?php echo $articulo['troquel']; ?>
			</td>
			<td>
				<?php echo $articulo['codigo_barras']; ?>
			</td>
			<td class='colprecio'>
				<?php 
						$precio = $articulo['precio_publico']*$descuento_pf;
						echo '$ '.number_format(round($precio, 3),2,',','.'); 
					
				?>
			</td>
			<td>
					<?php
					switch ($articulo['stock']) {
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
			?>
					</td>
		
			<td class='coliva'>
				<?php echo $this->Form->input('detalle',['label'=>'']);?>
			</td> 
			<td>
			<?= $this->Form->submit('Selecionar')?>
			</td> 
		 <?= $this->Form->end() ?>	
        </tr>
		
		   
    <?php endforeach; $indice+=2; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
			<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
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
		$(this).css("color","#464646");
		$(this).css("font-weight","");
		}
	);
</script>