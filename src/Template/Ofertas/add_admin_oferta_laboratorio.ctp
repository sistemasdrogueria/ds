
<style>
   .busqueda_name{ width: 400px;}
   #busqueda_sect{ width: 400px;}
</style>
<div class="clear"></div>
<article class="module width_full">
<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>
<?= $this->Form->create('Ofertas', ['url'=>['controller'=>'Ofertas','action'=>'add_admin_oferta_laboratorio'],'type' => 'file']) ?>
<div class="module_content">
<fieldset>
<div class=busqueda_name>
<?php echo $this->Form->input('descripcion'); ?>
</div></fieldset>	

<fieldset>
<div class="ofertainputopcion">
<?php echo $this->Form->input('oferta_tipo_id', ['options' =>$ofertastipos, 'label'=>'TIPO DE OFERTA']);  ?>
</div>
<div class="ofertainputopcion" id=laboratorio_id style= 'display:none'>
<?= $this->Form->input('laboratorio_id', ['label'=>'Laboratorio','options' => $laboratorios,'empty'=>'LABORATORIOS']);	?>	
</div>
<div class="ofertainputopcion" id=marca_id style= 'display:none'>
<?= $this->Form->input('marca_id', ['label'=>'Marca','options' => $marcas,'empty'=>'MARCAS']);	?>	
</div>
<div class="ofertainputopcion" id=busqueda_sect style= 'display:none'>
<?= $this->Form->input('busqueda_sect', ['label'=>'Busqueda']);	?>	
</div>
<div class="ofertainputopcion" style="width: 100px ; margin-right: 20px;">
<?= $this->Form->input('orden', ['label'=>'Orden']);	?>	
</div>
</fieldset>		
<fieldset>	
<div class="ofertainputfecha">
<?= $this->Form->input('fecha_desde', ['label'=>'Desde:','id'=>'fecha_desde','name'=>'fecha_desde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="ofertainputfecha">
<?=	$this->Form->input('fecha_hasta', ['label'=>'Hasta:','id'=>'fecha_hasta','name'=>'fecha_hasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','onchange'=>'javascript:document.confirmInput.submit();']);?>
</div>
</fieldset>		
<fieldset>	
<!-- label for="activo" >Imagen</label -->	
<?php echo $this->Form->input('file',['type' => 'file','label'=>'Imagen']);?>
<div>Tamaño de la imagen tiene debe ser 200 x 200px. El tipo debe ser .jpg </div>
</fieldset>	
<fieldset>	
<?php echo $this->Form->input('file2',['type' => 'file','label'=>'Logo del Laboratorio']); ?>
<div>Tamaño de la imagen tiene debe ser 250px de ancho. El tipo debe ser .jpg </div>
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
</div><div class="clear"></div>
<footer>

<div class="ofertainputbotton">
<?= $this->Form->button(__('GUARDAR')) ?>
</div>
<?= $this->Form->end() ?>
</footer>
</article> 

<script>
   document.getElementById("oferta-tipo-id").onchange = function(e) {
    if ((this.value >1 && this.value<5) || this.value==7 || this.value==11 )
    {
      var x = document.getElementById("laboratorio_id");

      var z = document.getElementById("marca_id");

      if (x.style.display === "none") {
         x.style.display = "block";
      } 
      if (z.style.display === "none") {
         z.style.display = "block";
      } 
      
    }

    if (this.value>3)
     {
      var y = document.getElementById("busqueda_sect");
      if (y.style.display === "none") {
         y.style.display = "block";
      } 
   }

};
</script>