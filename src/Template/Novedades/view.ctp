<section class="page_section team" id="novedades"><!--main-section team-start-->
<div class="container">
<h2>Novedades</h2>
<h6>Noticias Farmacéuticas y de Medio Ambiente.</h6>
<div class="member-area">
<div class="row"> 
<div class="content-section">
<div class="container">
<div class="row"  style =" margin-right: 5px;  margin-left: 5px; ">
<div class="novedades view large-10 medium-9 columns">
<h2>
<?= h($novedade->titulo) ?>
</h2>
<div class="large-5 columns strings">
<a href="#" onclick="history.go(-1);return false;">Volver atras
</a>
</div>
<div class="row" style =" margin-right: 5px;  margin-left: 5px; " >
<div class="large-2 columns dates end">
<p><?= h($novedade->fecha) ?></p><br/>
</div>
</div>
<div>
<?php 
if ($novedade->img_file2 =="")
echo "";//echo $this->Text->autoParagraph(h($novedade->descripcion_completa)); 
else
{
if ($novedade['archivopdf']>0)
{
echo '<iframe src="https://docs.google.com/gview?url=http://200.117.237.178/ds/webroot/img/novedades/'.$novedade->img_file2.'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe>';						
}														
else
echo $this->Html->image('novedades/'.$novedade->img_file2, ["alt" => "COMUNIDADO", 'style'=>"width:95%;",'id'=>'myImg' ]);
}
?>
</div>
<div class="row texts" style ="margin-right: 5px;  margin-left: 5px; ">
<div class="columns large-9">
<p class="texto" style=" font-weight: bold;" >
<?php 
if ($novedade->id <2479)
echo nl2br(h($novedade->descripcion),true);
else echo '<div style="text-align: justify;" >'.$novedade->descripcion.'</div>';
?>
</p>

<br/>
<p class="texto">
<?php 
if ($novedade->id <2479)
echo nl2br(h($novedade->descripcion_completa),true);
else echo '<div style="text-align: justify;" >'.$novedade->descripcion_completa.'</div>';
 ?>
</p>
</div>
</div>
</div>
</div> <!-- /.row -->
</div> <!-- /.container -->
</div> <!-- /.content-section -->
</div>
</div>		
</div>
</section> 

<script>
location.href = "#novedades";
</script>