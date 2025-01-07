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
<?php echo $this->Form->input('provincia_id',['options' =>$provincias,'value'=>$publication['provincia_id']]); ?> 
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
<script>
    document.getElementById('file').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const validExtensions = ['jpg', 'jpeg', 'png', 'mp3', 'mp4'];
            const fileExtension = file.name.split('.').pop().toLowerCase();

            // Validar extensión
            if (!validExtensions.includes(fileExtension)) {
                 alertify.alert('Alerta archivo Incorrecto','<span style="color: orange;">El archivo debe ser una imagen (.jpg, .jpeg, .png) o un audio/video (.mp3, .mp4).</span>');
                event.target.value = ''; // Restablecer el valor del input
                return;
            }

            // Validar tamaño
            if (file.size > 1048576) { // 1 MB en bytes
            alertify.alert('Alerta Imagen pesada','<span style="color: red;">El archivo no debe pesar más de 1 MB.</span>', function(){ //alertify.success('Ok');
              }
             );
             
                event.target.value = ''; // Restablecer el valor del input
            }
        }
    });
</script>