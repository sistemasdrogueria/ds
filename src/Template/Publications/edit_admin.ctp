<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<div class="ofertas form large-10 medium-9 columns">
<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="volveratras">
		<a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a>
</div>
</header>
<?= $this->Form->create($publication, ['url'=>['controller'=>'Publications','action'=>'edit_admin'],'type' => 'file']) ?>
<fieldset>	
<?php echo $this->Form->input('descripcion'); ?>
</fieldset>	
<fieldset>	
<?php echo $this->Form->input('url_controlador'); ?>
<?php echo $this->Form->input('url_metodo'); ?>
<?php echo $this->Form->input('url_campo'); ?>
<?php echo $this->Form->input('url_campo2'); ?>
<?php echo $this->Form->input('localidad',['maxlength'=>255]); ?> 
</fieldset>	

<fieldset>				
<?php echo $this->Form->input('orden'); ?>
</fieldset>	
<fieldset>
<div class="ofertainputfecha">
<?= $this->Form->input('fecha_desde', ['label'=>'Desde:','id'=>'fecha_desde','value'=> date_format($publication['fecha_desde'],'d/m/Y'),'name'=>'fecha_desde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="ofertainputfecha">
<?=	$this->Form->input('fecha_hasta', ['label'=>'Hasta:','id'=>'fecha_hasta','value'=>date_format($publication['fecha_hasta'],'d/m/Y'),'name'=>'fecha_hasta', 'type'=>'text','placeholder'=>'Fecha Hasta:']);?>
</div>
</fieldset>	
<fieldset style="text-align: center;"><div style="width: 45%; display: inline-block;"><?php echo $this->Form->control('laboratorio_id', ['options' => $laboratorios,'label'=>'', 'empty' => 'LABORATORIOS',]);?></div>
<div style="width: 45% ;display: inline-block;"><?php echo $this->Form->control('marca_id', ['options' => $marcas, 'empty'=>'MARCAS','label'=>'']);?></div> </fieldset>
<fieldset>	

<fieldset>				
<div class="ofertainputopcion">
<?php  /*echo $this->Form->input('incorporations_tipos_id', ['options' =>$incorporationstipos]);  */?>
</div>
</fieldset>	
<fieldset>
<?php
echo $this->Form->input('ubicacion', ['options' =>$publicationsTipos, 'value'=>$publication['ubicacion']]);  ?>
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