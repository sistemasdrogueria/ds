<style>
.seccion_noticias {display: flex;  justify-content: center}
.noticia_titulo { font-size: 22px;     text-decoration: none;}
.noticia_titulo a { color: black ;font-family: "Open Sans",Arial,sans-serif;color: #2a3f52;font-weight: 700;}
.noticia_div {border-bottom: #ddd solid 1px; margin-top :5px;margin-bottom: 20px; padding-bottom: 10px;}
.noticia_fecha{ font-size: 14px; margin-top: 5px; margin-bottom: 15px; font-weight: bold;}
.noticia_subtitulo {margin-top:15px; margin-bottom: 15px; font-weight: bold; font-size: 15px;}
.noticia_img {margin-top: 10px; margin-bottom: 10px;}
@media (max-width: 500px ) {
.seccion_noticias {display: inline-flex;flex-direction: column;justify-content: center}
} 
</style>
<div class = seccion_noticias>
<div class="col-md-6">
<div class="product-item-3"> 
<div class="product-content3">
<div class="row">
<?php $fecha =0;?>
<?php foreach ($novedades as $novedade): ?>
<div class="noticia_div">
<div class="member-container" data-wow-delay=".1s">
<div class="inner-container">
<div class="member-details">
<div class="member-top">	
<?php if ($fecha ==0)
{
$fecha =date_format($novedade['fecha'],'d-m-Y');
echo '<br><div class= noticia_fecha>'.$fecha.'</div>';
}
else 
{ $fechanew = date_format($novedade['fecha'],'d-m-Y');
if ($fecha != $fechanew)
{
$fecha =date_format($novedade['fecha'],'d-m-Y');
echo '<div class= noticia_fecha>'.$fecha.'</div>';
}
}
?>
<div class=noticia_titulo>
<?php echo $this->Html->link($novedade->titulo,['controller' => 'Novedades', 'action' => 'noticia',$novedade->id ,'_full' => true]); ?>
</div>
<div class=noticia_subtitulo> <?php 
if ($novedade->id <2479)
echo nl2br(h($novedade->descripcion),true);
else echo '<div style="text-align: justify;" >'.$novedade->descripcion.'</div>';
?></div>
</div><!-- /.member-top -->
<p class="texto">
<?php 
if ($novedade->img_file =="" || $novedade->img_file ==null)
echo "";//echo $this->Text->autoParagraph(h($novedade->descripcion_completa)); 
else
{
if ($novedade['archivopdf']>0 && $novedade->img_file !=null)
{
echo '<iframe src="https://docs.google.com/gview?url=https://www.drogueriasur.com.ar/ds/webroot/img/novedades/'.$novedade->img_file.'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe>';						
}														
else
{
if ($novedade->img_file!="" && $novedade->img_file!=null)
$nameimagen="novedades/".$novedade->img_file;
else	
$nameimagen="sinimagen.png";
echo $this->Html->image($nameimagen, ["alt" => "Novedades",'width'=>'100%','loading'=>'lazy','url' => ['controller' => 'novedades', 'action' => 'noticia',  $novedade->id]]);
}
}
?>
</p>
</div><!-- /.member-details -->
<?php
//echo $novedade['img_file2'];
if ($novedade['img_file2']=="" || $novedade['img_file2']==null)
echo "";
else
{
if ($novedade['archivopdf']>0 && $novedade['img_file2']!=null)
{
echo '<div><iframe src="https://docs.google.com/gview?url=https://www.drogueriasur.com.ar/ds/webroot/img/novedades/'.$novedade->img_file2.'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe></div>';						
}	
}
?>
</div><!-- /.inner-container -->
</div><!-- /.member-container -->
</div><!-- /.member -->
<?php endforeach; ?>
</div>
</div>
</div>	
</div>	
<div class="col-md-4">
<div class="product-item-3"> 
<div class="product-content3">	
<?php 
$fecha =0;
foreach ($novedades2 as $novedade): ?>
<div class=noticia_div>
<?php if ($fecha ==0)
{
$fecha =date_format($novedade['fecha'],'d-m-Y');
echo '<br><div class= noticia_fecha>'.$fecha.'</div>';
}
else 
{ $fechanew = date_format($novedade['fecha'],'d-m-Y');
if ($fecha != $fechanew)
{
	$fecha =date_format($novedade['fecha'],'d-m-Y');
	echo '<div class= noticia_fecha>'.$fecha.'</div>';
}
}
?>
<div class="noticia_titulo">
<?php echo $this->Html->link($novedade->titulo,['controller' => 'Novedades', 'action' => 'noticia',$novedade->id ,'_full' => true]);?>
</div>
<div class= noticia_img>
<?php
if ($novedade->img_file!="")
{
if ($novedade->img_file!=null)
{
$nameimagen="novedades/".$novedade->img_file;
echo $this->Html->image($nameimagen, ["alt" => "Novedades",'width'=>'100%','loading'=>'lazy','url' => ['controller' => 'novedades', 'action' => 'noticia',  $novedade->id,]]);
}
}
?>
</div>
</div>			
<?php endforeach; ?>
<div class="row">	
</div>
</div>		
</div>	
</div>
</div>