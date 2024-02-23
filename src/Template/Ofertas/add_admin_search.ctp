<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
</header>
<?= $this->Form->create('Ofertas', ['url'=>['controller'=>'Ofertas','action'=>'add_admin_oferta'],'type' => 'file']) ?>
<fieldset>	
<div class=ofertainputdescripcion>
<?php echo $this->Form->input('descripcion'); ?>
</div>
</fieldset>	
<fieldset>				
<div class="ofertainputopcion">
<?php	echo $this->Form->input('oferta_tipo_id', ['options' =>$ofertastipos]);  ?>
</div>
</fieldset>
<fieldset>	
<?php
$articulo_id = $articulo['id'];
if ($articulo['descuentos'] !=null ){	
$dto_drogueria = $articulo['descuentos'][0]['dto_drogueria'];
$uni_min = $articulo['descuentos'][0]['uni_min'];
$uni_max = $articulo['descuentos'][0]['uni_max'];
$fecha_desde = $articulo['descuentos'][0]['fecha_desde'];
$fecha_hasta = $articulo['descuentos'][0]['fecha_hasta'];
$plazo = $articulo['descuentos'][0]['plazo'];
$fecha_desde = date_format($fecha_desde,'d/m/Y');
$fecha_hasta = date_format($fecha_hasta,'d/m/Y');	
}
else
{
$dto_drogueria = null;
$uni_min = 1;
$uni_max = 10;
$fecha_desde = date("d/m/Y");
$fecha_hasta = date("d/m/Y");
$plazo = null;
}
?>
<div class="ofertainputdescuento">
<?php	
echo $this->Form->input('articulo_id',['type'=>'hidden','value'=>$articulo_id]);
echo $this->Form->input('codigo_barras',['type'=>'hidden','value'=>$articulo['codigo_barras']]);
echo $this->Form->input('descuento_producto',['value'=>$dto_drogueria,'label'=>'DESCUENTO']); ?>
</div>
<div class="ofertainputdescuento">
<?php echo $this->Form->input('unidades_minimas',['value'=>$uni_min,'label'=>'Unid. Minimas']);	?>
</div>
<div class="ofertainputdescuento">
<?php echo $this->Form->input('unidades_maximas',['value'=>$uni_max, 'label'=>'Unid. Maximas']); ?>
</div>
<div class="ofertainputaplica">
<?php echo $this->Form->input('aplicaen',['value'=>1,'label'=>'APLICA EN']); ?>
</div>
<div class="ofertainputfecha">
<?= $this->Form->input('fecha_desde', ['label'=>'Desde:','id'=>'fecha_desde','value'=>$fecha_desde ,'name'=>'fecha_desde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="ofertainputfecha">
<?=	$this->Form->input('fecha_hasta', ['label'=>'Hasta:','id'=>'fecha_hasta','value'=>$fecha_hasta,'name'=>'fecha_hasta', 'type'=>'text','placeholder'=>'Fecha Hasta:']);?>
</div>
<div class="ofertainputaplica">
<?php	echo $this->Form->input('plazos',['value'=>$plazo]);?>
</div>
</fieldset>		
<fieldset>	
	<div class="ofertainputfile">
<?php echo $this->Form->input('file',['type' => 'file','label'=>'Imagen']);  ?>

</div>
<div>Tamaño de la imagen 200px x 200px. Tipo .jpg </div>
</fieldset>		
<fieldset>	
<div class="ofertainputcheck">
<label for="activo" >Activo</label>	
<?php	echo $this->Form->checkbox('activo', ['hiddenField' => true,'checked'=>true]);?>
</div>	
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