<style>
.seccion_noticias {display: flex;  justify-content: center}
.noticia_titulo { font-size: 22px;     text-decoration: none;}
.noticia_titulo a { color: black ;font-family: "Open Sans",Arial,sans-serif;color: #2a3f52;font-weight: 700;}
.noticia_div {border-bottom: #ddd solid 1px; margin-top :5px;margin-bottom: 20px; padding-bottom: 10px;}
.noticia_fecha{ font-size: 14px; margin-top: 5px; margin-bottom: 15px; font-weight: bold;}
.noticia_subtitulo {margin-top:15px; margin-bottom: 15px; font-weight: bold; font-size: 15px;}
.noticia_img {margin-top: 10px; margin-bottom: 10px;}
.noticia_texto {margin-top:15px; font-size: 14px;     line-height: 2.2;}
</style>
<div class = seccion_noticias>
<div class="col-md-7">
<div class="product-item-3"> 
<div class="product-content3">
<div class="row">
<h2>
<?= h($novedade->titulo) ?>
</h2>
<div>
<div class="columns large-9">
<div class=noticia_subtitulo> 
<?php 
if ($novedade->id <2479)
echo nl2br(h($novedade->descripcion)); 
else echo '<div style="text-align: justify;" >'.$novedade->descripcion.'</div>';
?>
</div>
<div class="large-2 columns dates end"><p><?php 
$diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
echo date_format($novedade['fecha'],'d')." de ".$meses[date_format($novedade['fecha'],'m')-1]. " del ".date_format($novedade['fecha'],'Y') ;
?></p></div>
<div class =  noticia_img>
<?php
if ($novedade->img_file!="")
$nameimagen="novedades/".$novedade->img_file;
else	
$nameimagen="sinimagen.png";
echo $this->Html->image($nameimagen, ["alt" => "Novedades",'width'=>'100%']);
?>
</div>
<div class= noticia_texto>
<p>
<?php 
if ($novedade->id <2479)
echo nl2br(h($novedade->descripcion_completa),true);
else echo '<div style="text-align: justify;" >'.$novedade->descripcion_completa.'</div>';
?>
</p>
</div>
</div>
</div>
<p class="texto">
<?php 
if ($novedade->img_file =="")
echo "";
else
{
if ($novedade['archivopdf']==1)
echo '<iframe src="https://docs.google.com/gview?url=https://drogueriasur.com.ar/ds/webroot/img/novedades/'.$novedade->img_file.'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe>';																			
else
echo $this->Html->image('novedades/'.$novedade->img_file, ["alt" => "COMUNIDADO", 'style'=>"width:95%;",'id'=>'myImg' ]);
}
?>
</p>
<!-- The Modal -->
<div id="myModal" class="modal">
<span class="close">&times;</span>
<img class="modal-content" id="img01">
<div id="caption"></div>
</div>
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
$nameimagen="novedades/".$novedade->img_file;
else	
$nameimagen="sinimagen.png";
echo $this->Html->image($nameimagen, ["alt" => "Novedades",'width'=>'100%','url' => ['controller' => 'novedades', 'action' => 'noticia',  $novedade->id]]);
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