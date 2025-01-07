
<style>
   .busqueda_name{ width: 400px;}
   #busqueda_sect{ width: 400px;}
</style>
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_4_quarter">
<header>
    <h3 class="tabs_involved"><?= $titulo ?></h3>
    <div class="tabs_bt_nuevo">
    <?php echo $this->Html->image('admin/icn_volver.png', ['url' => $previous]);?>	</div>
  </header>
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
            if (file.size > 524288) { // 1 MB en bytes
            alertify.alert('Alerta Imagen pesada','<span style="color: red;">El archivo no debe pesar más de 500kb.</span>', function(){ //alertify.success('Ok');
              }
             );
             
                event.target.value = ''; // Restablecer el valor del input
            }
        }
    });
</script>