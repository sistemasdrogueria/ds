<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>

<article class="module width_3_quarter">
	<header><h3 class="tabs_involved"><?= $titulo ?></h3>
		<div class="volveratras">
		<a href="<?= $previous ?>">Volver atras</a>
		</div>
	</header>
	<div id="titulo_resumen"><h4 id="titulo_oferta" align="center"></h4></div>	
	<div id="link_oferta" align="center"></div>
	<div id="cuerpo_oferta" align="center"></div>

	<?= $this->Form->create('Descargas', ['url'=>['controller'=>'Descargas','action'=>'subirarchivo'],'type' => 'file']) ?>
	<fieldset>	
			<?php echo $this->Form->input('descripcion',['label'=>'Dermocosmetica Mes']); ?>
			<?php echo $this->Form->input('status',['type'=>'hidden','value'=>2]); ?>
			<br>
			<?php echo $this->Form->input('file',['type' => 'file','label'=>'Archivo']); ?>
			
	</fieldset>		
	<fieldset>
	<div class="ofertainputbotton">
		<?= $this->Form->button(__('GUARDAR')) ?>
	</div>
    <?= $this->Form->end() ?>
	</fieldset>

	<br/>
	<?= $this->Form->create('Descargas', ['url'=>['controller'=>'Descargas','action'=>'subirarchivo'],'type' => 'file']) ?>
	<fieldset>	
			<?php echo $this->Form->input('descripcion',['label'=>'Consolidados Mes']); ?>
			<?php echo $this->Form->input('status',['type'=>'hidden','value'=>3]); ?>
			<br/>
			<?php echo $this->Form->input('file',['type' => 'file']); ?>
			
	</fieldset>		
	<fieldset>
	<div class="ofertainputbotton">
		<?= $this->Form->button(__('GUARDAR')) ?>
	</div>
    <?= $this->Form->end() ?>
	</fieldset>
 </article> 