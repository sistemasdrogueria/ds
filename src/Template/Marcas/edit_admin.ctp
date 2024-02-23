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
<a href="<?= $previous ?>">Volver atras<a>
</div>
</header>
<?= $this->Form->create($marca, ['url'=>['controller'=>'Marcas','action'=>'edit_admin'],'type' => 'file']) ?>
<fieldset>	
<?php echo $this->Form->input('nombre'); ?>
</fieldset>	
<fieldset>	

<?php	echo $this->Form->input('marcas_tipos_id', ['options' =>$marcastipos]);  ?>
</fieldset>	
<fieldset>	
<div class="ofertainputopcion">
<?php	echo $this->Form->input('laboratorio_id', ['options' =>$laboratorios]);  ?>
</div>
</fieldset>	
<fieldset>	
<div class="ofertainputopcion">
<?php	echo $this->Form->input('descripcion_sistema', ['label'=>'URL']);  ?>
</div>
</fieldset>			
<fieldset>	
<?php echo $this->Form->input('file',['type' => 'file','label'=>'Imagen']); ?>
<div>Tamaño de la imagen tiene debe ser 200px x 200px. El tipo debe ser .jpg </div>
</fieldset>		
<fieldset>	
<div class="ofertainputcheck">
<?php echo $this->Form->input('orden'); ?>
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