<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_full">
<header><h3><?= $titulo ?></h3>
<div class="volveratras"><a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a></div>
</header>
<div class="module_content">

<h2><?= h($novedade->titulo) ?></h2>
<br/>

<h4><?= h($novedade->tipo) ?></h4>
<br/>
<?php  

if ($novedade->img_file !="") 
{
if ($novedade['archivopdf']>0)
{
echo '<iframe src="http://docs.google.com/gview?url=http://200.117.237.178/ds/webroot/img/novedades/'.$novedade->img_file.'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe>';						
}														
else
echo $this->Html->image('novedades/'.$novedade->img_file, ["alt" => "COMUNIDADO", 'style'=>"width:95%;"]);
}

?>
<p style=" font-weight: bold; text-align : justify;" >
<?php 
if ($novedade->id <2479)
echo nl2br(h($novedade->descripcion),true);
else echo '<div style="text-align: justify;" >'.$novedade->descripcion.'</div>';

//echo nl2br(h($novedade->descripcion)); ?>
</p>
<p style=" text-align : justify;">
<?php 
if ($novedade->id <2479)
echo nl2br(h($novedade->descripcion_completa),true);
else echo '<div style="text-align: justify;" >'.$novedade->descripcion_completa.'</div>';
?>
</p>
<br/>
<br/>
<h4><?= __('Archivo PDF') ?><?php if ($novedade->archivopdf>0)
{
echo ' SI';
}
else
echo ' NO';
?></h4>	
<h4><?= h($novedade->fecha) ?></h4>	
<h4><?= __('Noticia Activa ') ?><?php if ($novedade->activo)
echo ' SI';
else
echo ' NO';
?></h4>
<h4><?= __('Noticia Interna ') ?><?php if ($novedade->interno)
{
echo ' SI';
}
else
echo ' NO';
?></h4>			
</div>
</article><!-- end of styles article -->