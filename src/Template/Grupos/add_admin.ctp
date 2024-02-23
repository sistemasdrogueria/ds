
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<div class="ofertas form large-10 medium-9 columns">
<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="volveratras"><a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a></div>
</header>
<?= $this->Form->create($grupo, ['url'=>['controller'=>'Grupos','action'=>'add_admin'],'type' => 'file']) ?>
<fieldset>	
<?php echo $this->Form->input('nombre'); ?>
</fieldset>	
<fieldset>	
<div class="ofertainputopcion">
<?php	echo $this->Form->input('grupos_tipos_id', ['options' =>$grupostipos]);  ?>
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