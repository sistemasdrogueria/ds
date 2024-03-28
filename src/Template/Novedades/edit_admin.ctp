<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<style>
.descripcionck label{display:block; float:none; width:200px;height:25px;line-height:25px;text-shadow:0 1px 0 #fff;font-weight:700;padding-left:10px;margin:-5px 0 5px;text-transform:uppercase}

</style>
<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="clear"></div>
<article class="module width_full">
<header><h3 class="tabs_involved" id="titulobarra"><?= $titulo ?></h3>
<div class="volveratras">
<a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a>
</div>
</header>
<?= $this->Form->create($novedade, ['url'=>['controller'=>'Novedades','action'=>'edit_admin'],'type' => 'file']) ?>
<div class="module_content">
<fieldset>
<?php	echo $this->Form->input('titulo');?>
</fieldset>
<fieldset class=descripcionck>
<?php echo $this->Form->input('descripcion', ['label'=>'Descripción', 'class'=>'ckeditor','id'=>'descripcion']);?> 
<?php //echo $this->Form->input('descripcion');?>
</fieldset>
<fieldset class=descripcionck>
<?php echo $this->Form->input('descripcion_completa', ['label'=>'Descripción Completa','class'=>'ckeditor','id'=>'descripcion_completa']);?> 
<?php	//echo $this->Form->input('descripcion_completa');?>
</fieldset>
<fieldset style="width:98%;float:left;">
<?php	echo $this->Form->input('tipo');?>
</fieldset>
<fieldset>		
<?= $this->Form->input('fecha', ['label'=>'fecha:','id'=>'fechadesde','name'=>'fecha', 'type'=>'text','placeholder'=>'Fecha']);?>
</fieldset>
<fieldset>	
<div class="input select">
<?php
echo $this->Form->input('file',['type' => 'file','label'=>'Portada']);
?>
</div>
<div class="input select">
<?php
echo $this->Form->input('file2',['type' => 'file','label'=>'Imagen Grande']);
?>
</div>
</fieldset>
<fieldset>
<div class="input select">
<label for="activo" >Noticia Activa</label>			
<?php	echo $this->Form->checkbox('activo');?>
</div>
</fieldset>
<fieldset>
<div class="input select">
<label for="activo" >Noticia Pagina Interna</label>			
<?php echo $this->Form->checkbox('interno');?>
</div>
</fieldset>
<fieldset>
<div class="input select">
<?php	echo $this->Form->input('importante', ['label'=>'Noticia Importente:']);?>
0 por defecto, 1 Importante, 2 muy importante(sección Resumen)
</div>
</fieldset>
</div><div class="clear"></div>
<footer>
<div class="submit_link">
<?= $this->Form->button(__('Guardar')) ?>
<?= $this->Form->end() ?>
</div>
<div class="submit_link">
<a href="<?= $previous ?>">Volver</a>
</div>
</footer>
</article><!-- end of post new article -->