<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<style>
	.header_icon{
	float: right;	
	margin-right: 10px;
	margin-top: 5px;
}
.header_icon_delete{
float: left;
margin-top: 5px;
margin-left: 5px;
margin-right: 5px;
}
.header_icon_return{ 
	float: left;
}
</style>

<div class="ofertas form large-10 medium-9 columns">
    <article class="module width_4_quarter">
	<header><h3 class="tabs_involved"><?= $titulo ?></h3>
		<div class = header_icon> 
<div class="header_icon_delete">
<?php 
echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
["alt" => __('Delete'), "title" => __('Delete')]), 
['action' => 'delete_admin', $oferta->id], 
['escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $oferta->id)]
);
?>
</div>
<div class="header_icon_return">
<?php echo $this->Html->image('admin/icn_volver.png', ['url' => $previous]);?>	</div>
</div>
	</header>
	<?= $this->Form->create($incorporation, ['url'=>['controller'=>'Incorporations','action'=>'edit_admin'],'type' => 'file']) ?>
	<fieldset>	
		<?php echo $this->Form->input('descripcion'); ?>
	</fieldset>	
		
	<fieldset>
	<div class="ofertainputfecha">
		<?= $this->Form->input('fecha_desde', ['label'=>'Desde:','id'=>'fecha_desde','value'=> date_format($incorporation['fecha_desde'],'d/m/Y'),'name'=>'fecha_desde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
	</div>
	<div class="ofertainputfecha">
		<?=	$this->Form->input('fecha_hasta', ['label'=>'Hasta:','id'=>'fecha_hasta','value'=>date_format($incorporation['fecha_hasta'],'d/m/Y'),'name'=>'fecha_hasta', 'type'=>'text','placeholder'=>'Fecha Hasta:']);?>
	</div>
	</fieldset>		
	<fieldset>				
	<div class="ofertainputopcion">
		<?php	echo $this->Form->input('incorporations_tipos_id', ['options' =>$incorporationstipos]);  ?>
	</div>
	</fieldset>	
	<fieldset>				
<div style="width: 30% ; float: left;  margin-right: 20px;" >
<?php echo $this->Form->input('url_controlador'); ?>
<?php echo $this->Form->input('url_metodo'); ?>
<?php echo $this->Form->input('url_campo'); ?>
</div>
<div style="width: 60% ; float: left">
<h1>INFO</h1>
<table>
<tr>
<td style="width: 50% ">Agregar producto al carro</td>
<td style="width: 50%">carritos => searchadd => EAN</td>
</tr>
<tr><td>Mostrar resultado de productos </td><td>carritos => search -> parámetro de búsqueda</td></tr>
<tr><td>Para dirigir a una sección</td><td>nombre de sección -> método <br>EJ: ortopedias -> index</td></tr>
</table>
</div>
</fieldset>	
		
	<fieldset>	
		<?php echo $this->Form->input('file',['type' => 'file','label'=>'Imagen']); ?>
		<div>Tamaño de la imagen tiene debe ser 200px x 200px. El tipo debe ser .jpg </div>
	</fieldset>		
	<fieldset>	

	<div class="ofertainputcheck">
		<label for="activo" >Habilitada</label>	
		<?php	echo $this->Form->checkbox('habilitada', ['hiddenField' => true,'checked'=>true]);?>
	</div>	
    </fieldset>
	<fieldset>
	<div class="ofertainputbotton">
		<?= $this->Form->button(__('GUARDAR')) ?>
	</div>
    <?= $this->Form->end() ?>
	</fieldset>
 </article> 
</div>