
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
<?= $this->Form->create($marca, ['url'=>['controller'=>'Marcas','action'=>'add_admin'],'type' => 'file']) ?>
<fieldset>	
<div class=marcainput>
<?php echo $this->Form->input('nombre' ,['label'=>'NOMBRE DE MARCA PAGINA']); ?>
</div>
<div class=marcainput>
<?php	echo $this->Form->input('descripcion_sistema', ['label'=>'NOMBRE DE MARCA EN EL SISTEMA ó URL']);  ?>
</div>
</fieldset>	
<fieldset>	
<div class="ofertainputopcion">
<?php	echo $this->Form->input('marcas_tipos_id', ['options' =>$marcastipos]);  ?>
</div>
</fieldset>	
<fieldset>	
<div class="ofertainputopcion">
<?php	echo $this->Form->input('laboratorio_id', ['options' =>$laboratorios]);  ?>
</div>
</fieldset>	
<fieldset>				
<?php echo $this->Form->input('orden'); ?>
</fieldset>			
<fieldset>	
<?php echo $this->Form->input('file',['type' => 'file','label'=>'Imagen']); ?>
<div>Tamaño de la imagen tiene debe ser 250px x 250px. Dependiendo el tipo. jpg o png</div>
</fieldset>		
<fieldset>
<div class="ofertainputbotton">
<?= $this->Form->button(__('GUARDAR')) ?>
</div>
<?= $this->Form->end() ?>
</fieldset>
</article> 
</div>