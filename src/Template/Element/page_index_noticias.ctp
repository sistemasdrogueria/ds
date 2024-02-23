<!--page_section-->
<section class="page_section team" id="novedades"><!--main-section team-start-->
<div class="container">
<h2>Novedades</h2>
<h6>Noticias Farmacéuticas y de Medio Ambiente.</h6>
<div class="member-area">
<div class="row"> 
<div class="content-section">
<div class="container">
<div class="row">
<?php 
$cont=0;
foreach ($novedades as $novedade): ?>
<div class="col-md-3 col-sm-6">
<div class="product-item-vote">
<div class="product-thumb-igual">
<?php
if ($cont<4)
{if ($novedade->img_file!="")
$nameimagen="novedades/".$novedade->img_file;
else	
$nameimagen="sinimagen.png";
echo $this->Html->image($nameimagen, ["alt" => "Novedades","class"=>"img-circle-igual",
'url' => ['controller' => 'novedades', 'action' => 'view',  $novedade->id]]);
}
?>
</div> <!-- /.product-thum -->
<div class="product-content">
<h5><?= h($novedade->titulo) ?></h5>
<?= h($novedade->fecha) ?>
<?= $this->Html->link(__('Mas'), ['controller' => 'Novedades', 'action' => 'view',$novedade->id]) ?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item-vote -->
</div> <!-- /.col-md-3 -->
<?php 
$cont++;
endforeach; ?>
</div> <!-- /.row -->
</div> <!-- /.container -->
</div> <!-- /.content-section -->
</div>
</div>		
</div>
</section> 