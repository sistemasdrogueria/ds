<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>

<div class="clear"></div>

<article class="module width_full">
	
	<header id="titulo_header"><h3><?= $titulo ?></h3>
		
		 <?= $this->Html->image("admin/icon-sendmail.png", array(
				"alt" => "Ver",
				'url' => array('controller' => 'reclamos', 'action' => 'reclamo_mail',  $reclamo['id']),
			
				));?>
		
		
		<div class="volveratras">
		<a href="<?= $previous ?>">Volver atras</a>
		</div>
		<?= $this->Html->image("admin/icon-print.png", array(
				"alt" => "Ver",
				
				'class'=>'btnPrint'
				));?>
	</header>
	<div id="dvContainer">
	<div class="module_content" id="printable">
	<table class="viewlabel">
	<tr>
		<td class="columna_reclamo_nombre"><h4 ><?= __('Nro de Reclamo') ?></h4></td>
            <td><h4><?= $this->Number->format($reclamo->id) ?></h4></td>
	</tr>
	<tr>			
		<td><h4 ><?= __('Fecha y Hora') ?></h4></td>
				<td><h4>
				<?php echo date_format($reclamo->creado,'d-m-Y H:i:s');?>
				</h4></td>
			
	</tr>	
	<tr>			
            <td><h4 ><?= __('Cliente') ?></h4></td>
            <td><h4>
			<?= $reclamo->has('cliente') ? h($reclamo->cliente->codigo): '' ?> - 
			<?= $reclamo->has('cliente') ? h($reclamo->cliente->nombre): '' ?>
				    
			</h4></td>
	</tr>
	<tr>    
	<td><h4 ><?= __('Reclamos Tipo') ?></h4></td>
            <td><h4><?= $reclamo->has('reclamos_tipo') ? h($reclamo->reclamos_tipo->nombre) : '' ?></h4></td>
	</tr>
	<tr>    
	<td><h4 ><?= __('Email') ?></h4></td>
            
			<td><h4><?= $reclamo->has('cliente') ? h($reclamo->cliente->email): '' ?></h4></td>
	</tr>
	
	<tr>			
            <td><h4 ><?= __('Pedido Nro') ?></h4></td>
            <td><h4><?= $this->Number->format($reclamo->factura_numero) ?></h4></td>
	</tr>
	
	<tr>			
		<td><h4 ><?= __('Fecha Recepcion') ?></h4></td>
				<td><h4>
				<?php echo date_format($reclamo->fecha_recepcion,'d-m-Y');?>
				</h4></td>
			
	</tr>	
	
	<td><h4 ><?= __('Estado') ?></h4></td>
            <td><h4><?= $reclamo->has('reclamos_estado') ? h($reclamo->reclamos_estado->nombre) : ''?></h4></td>
	</tr>
	<tr>    
	<td><h4 ><?= __('Observaciones') ?></h4></td>
            <td><h4><?= h($reclamo->observaciones) ?></h4></td>
	</tr>
	</table>
	
    


    <div class="articulos index large-10 medium-9 columns">
    <table class='tablesorter' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			<th>Cant.</th>
            <th>Descripción</th>
            <th>Laboratorio</th>
			<th>Fecha Venc.</th>
            <th>Lote</th>
			<th>Serie</th>
			
        </tr>
    </thead>
    <tbody>
	<?php $lab = $laboratorios; ?>

    <tbody>
    <?php foreach ($reclamositemstemps as $reclamosItemsTemp): ?>
        <tr>
            <td class='form_reclamo_cant_td'><?= $this->Number->format($reclamosItemsTemp['cantidad']) ?></td>
            <td><?= h($reclamosItemsTemp['detalle']) ?></td>
			<td> 
			<?php echo $lab[$reclamosItemsTemp['a']['laboratorio_id']];?>
			</td>
            <td class="form_reclamo_fv_td">
			<?php 
			if ($reclamosItemsTemp['fecha_vencimiento']!=null)
					echo date_format($reclamosItemsTemp['fecha_vencimiento'],'d-m-Y');
			?>	
			</td>
            <td class="form_reclamo_lote_td"><?= h($reclamosItemsTemp['lote']) ?></td>
			<td class="form_reclamo_serie_td"><?= h($reclamosItemsTemp['serie']) ?></td>
            
        </tr>

    <?php endforeach; ?>
    </tbody>
	 </table>
	</div>
</div>
</div>
 
<script>
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

    </script>
	 <?php echo $this->Html->css('print');	?>
  <script>  

  
  $(document).ready(function() {
 //$('ul#tools').prepend('<li class="print"><a href="#print">Click me to print</a></li>');
 $('.btnPrint').click(function() {
  window.print();
  return false;
 });
}); 
  </script>
	
</article>
