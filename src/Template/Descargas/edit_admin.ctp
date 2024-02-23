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

	<?= $this->Form->create('Descargas', ['url'=>['controller'=>'Descargas','action'=>'edit_admin',$file->id],'type' => 'file']) ?>
	<fieldset>	
			<?php echo $this->Form->input('descripcion',['label'=>'Dermocosmetica Mes','value'=>$file->descripcion]); ?>
			<?php echo $this->Form->input('status',['type'=>'hidden','value'=>$file->status]); ?>
			<?php echo $this->Form->input('id',['type'=>'hidden','value'=>$file->id]); ?>
			<br>
			<?php echo $this->Form->input('file',['type' => 'file','label'=>'Archivo']); ?>		
	</fieldset>		
	<fieldset>
	<div class="ofertainputbotton">
		<?= $this->Form->button(__('GUARDAR')) ?>
	</div>
    <?= $this->Form->end() ?>
	</fieldset>

 </article> 
 <article class="module width_3_quarter">
		<div> 
	<?php
			$nombre_fichero = 'descargas'. DS .$file->name;
		    echo '<iframe src="http://docs.google.com/gview?url=http://200.117.237.178/ds2/webroot/'.$nombre_fichero.'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe>';
		?>
		</div> 
</article><!-- end of content manager article -->