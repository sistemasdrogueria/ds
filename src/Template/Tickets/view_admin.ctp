<style>
.header_icon{
	float: right;	
	margin-right: 10px;
	margin-top: 5px;

 
}
.header_icon_print{
	float: left;
margin-top: 5px;
margin-left: 5px;
margin-right: 5px;
}
.header_icon_mail {
float: left;

margin-left: 5px;
margin-right: 5px;
}
.header_icon_return{ 
	float: left;
}
</style>
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>

<div class="clear"></div>

<article class="module width_full">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class = header_icon> 
<div class="header_icon_mail">
<?= $this->Html->image("admin/icon-sendmail.png", ["alt" => "Ver",'url' => ['controller' => 'Tickets', 'action' => 'ticket_mail', $reclamo['id']]]);?>
</div>
<div class="header_icon_print">
<?= $this->Html->image("admin/icon-print2.png", ["alt" => "Ver",'class'=>'btnPrint']);?>
</div>
<div class="header_icon_return">
<?php echo $this->Html->image('admin/icn_volver.png', ['url' => $previous]);?>	</div>
</div>
</header>

	<div id="dvContainer">
	<div class="module_content" id="printable">
	<table class="viewlabel">
	<tr>
		<td class="columna_reclamo_nombre"><h4 ><?= __('Nro') ?></h4></td>
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
	<td><h4 ><?= __('Motivo') ?></h4></td>
            <td><h4><?= $reclamo->has('reclamos_tipo') ? h($reclamo->reclamos_tipo->nombre) : '' ?></h4></td>
	</tr>
	<tr>    
	<td><h4 ><?= __('Email') ?></h4></td>
            
			<td><h4><?= $reclamo->has('cliente') ? h($reclamo->cliente->email): '' ?></h4></td>
	</tr>
	
	<tr>			
            <td><h4 ><?= __('Factura Nro') ?></h4></td>
            <td><h4><?php echo str_pad($reclamo['factura_seccion'], 4, '0', STR_PAD_LEFT).'-'.str_pad($reclamo['factura_numero'], 8, '0', STR_PAD_LEFT); ?>
			</h4></td>
	</tr>
		<tr>			
            <td><h4 ><?= __('Pedido Nro') ?></h4></td>
            <td><h4><?php echo $reclamo['pedido_numero']; ?>
			</h4></td>
	</tr>
	<tr>			
		<td><h4 ><?= __('Factura Fecha') ?></h4></td>
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
            <th>EAN</th>
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
			<?php echo $reclamosItemsTemp['a']['codigo_barras'];?>
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
